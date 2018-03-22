<?php
  class Edamame {
    protected $db;
    protected $series;
    protected $verified = FALSE;
    protected $mediaPath;
    protected $mediaURI;

    function __construct($dbpath) {
      if (file_exists($dbpath)) {
        $dsn = "sqlite:".$dbpath;
        $this->db = new PDO($dsn); // add error handling...

        $this->adminVerify();

      } else {
        // this warning is clearly misplaced, need better error system
        echo "<div class=\"edamame-warning\">Database not found.</div>";
      }

      $this->series = $this->db->query('SELECT * FROM seriesinfo;')->fetch(PDO::FETCH_ASSOC);

      $this->mediaPath = dirname($_SERVER['SCRIPT_FILENAME']) . '/media/';

      $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
      $scriptDir = $scriptDir === '/' ? '' : $scriptDir;
      $this->mediaURI = $scriptDir . '/media/';

    }

    protected function setTokens($email,$persistent){
      $token = bin2hex(random_bytes(32));
      $hashedToken = hash("sha256",$token);

      if ($persistent) {
        $cookieExpiry = time()+60*60*24*7;
        $tokenExpiry = time()+60*60*24*7;
        $persistent = TRUE;
      } else {
        $cookieExpiry = 0;
        $tokenExpiry = time()+60*30;
        $persistent = FALSE;
      }

      setcookie("edamame-admin-token",$token,$cookieExpiry);
      setcookie("edamame-admin-email",$email,$cookieExpiry);

      $query = $this->db->prepare('UPDATE admin SET token=:token, timestamp=:expiry, persistent=:persistent WHERE email = :email;');
      $query->execute(array(':token' => $hashedToken, ':expiry' => $tokenExpiry, ':persistent' => $persistent, ':email' => $email));
    }
    
    protected function adminVerify() {
      if (isset($_POST['login']) && $_POST['login'] == "Log In"){
        $email = $_POST['email'];
        $formPass = $_POST['password'];
        
        $query = $this->db->prepare('SELECT password FROM admin WHERE email = :email;');
        $query->execute(array(':email' => $email));
        $dbPass = $query->fetch(PDO::FETCH_ASSOC)['password'];

        if (password_verify($formPass,$dbPass)){
          $this->setTokens($email,$_POST['remember']);
          $this->verified = TRUE;
        } else {
          $this->verified = FALSE;
        }
        
      } else if (isset($_COOKIE['edamame-admin-token']) && $_COOKIE['edamame-admin-token']) {
        $userToken = hash("sha256",$_COOKIE['edamame-admin-token']);
        $email = $_COOKIE['edamame-admin-email'];

        $query = $this->db->prepare('SELECT token, persistent, timestamp FROM admin WHERE email=:email;');
        $query->execute(array(':email' => $email));
        $results = $query->fetch(PDO::FETCH_ASSOC);
        $dbToken = $results['token'];
        $persistent = $results['persistent'];
        $expiry = $results['timestamp'];

        if ($dbToken && $expiry > time() && hash_equals($dbToken,$userToken)) {
          if (isset($_POST['login']) && $_POST['login'] == "Log Out"){
            $query = $this->db->prepare('UPDATE admin SET token = null, timestamp = null, persistent = null WHERE email=:email');
            $query->execute(array(':email'=>$email));

            setcookie("edamame-admin-token",NULL,time()-3600);
            setcookie("edamame-admin-email",NULL,time()-3600);

            $this->verified = FALSE;
          } else {
            $this->setTokens($email,$persistent);
            $this->verified = TRUE;
          }
        } else {
         $this->verified = FALSE;
        }
      } else {
        $this->verified = FALSE;
      }
    }
    
    public function adminStatus() {
      return $this->verified;
    }
    
    public function adminLogin() {
      if ($this->verified){
        ?>
          <form enctype="multipart/form-data" method="post" action="">
            <input type="hidden" name="login" value="Log Out">
            <input type="submit" value="Log Out"/>
          </form>
        <?php
      } else {
        ?>
          <form enctype="multipart/form-data" method="post" action="">
            <input type="hidden" name="login" value="Log In">
            <input type="email" name="email">
            <input type="password" name="password">
            <label><input type="checkbox" name="remember">Remember Me</label>
            <br>
            <input type="submit" value="Log In"/>
          </form>
        <?php
      }
    }

    public function seriesInfo() {
      ?>
        <div id="edamame-series-info">
          <h2><?= $this->series['title']; ?></h2>
          <p><?= str_replace(["\r\n","\n","\r"]," <br />", $this->series['longdesc']); ?></p>
          <img src="<?= $this->mediaURI . $this->series['imagefile']  ?>" width="250px" height="250px" />
        </div>
      <?php
    } // seriesInfo

    public function seriesTitle() {
      $title = $this->db->query('SELECT title FROM seriesinfo;')->fetch(PDO::FETCH_ASSOC);
      return $title['title'];
    } // seriesTitle

    protected function deleteEpisode($episodeGuid) {
      if ($this->verified) {
        $query = $this->db->prepare('DELETE FROM episodes WHERE id=:episode;');
        $query->execute(array(':episode' => $episodeGuid));
        // TODO: delete mp3 (and image file, if unique)
      }
    }

    public function listEpisodes() {
      if (isset($_POST['delete-episode']) && $_POST['delete-episode']) {
        $this->deleteEpisode($_POST['delete-episode']);
      }
      if (isset($_GET['episode'])) {
        $episodes = $this->db->prepare('SELECT * FROM episodes WHERE permalink = :episode;');
        $episodes->execute(array(':episode' => $_GET['episode']));
      } else {
        if ($this->verified) {
          // TODO: set order based on episodic vs serial
          $episodes = $this->db->query('SELECT * FROM episodes ORDER BY timestamp ASC;');
        } else {
          $episodes = $this->db->prepare('SELECT * FROM episodes WHERE timestamp < :now ORDER BY timestamp ASC;');
          $episodes->execute(array(':now' => date('U')));
        }
      }

      include "episode-list.php";

    } // listEpisodes

    public function adminSeries($formTargetPath = "") {
      if ($this->verified) {
        if (isset($_POST['form-type']) && $_POST['form-type'] == "series") {
          $this->writeSeries();
        }

        $series = $this->series;
        
        include "series-form.php";
      } else {
        echo "<div class=\"edamame-warning\">Please log in to edit series info</div>";
      }
    } // adminSeries
    
    public function adminEpisode($formTargetPath = "") {
      if ($this->verified) {
        if (isset($_POST['form-type']) && $_POST['form-type'] == "episode") {
          $this->writeEpisode();
        }

        $series = $this->series;
        $episodes = $this->db->query('SELECT * FROM episodes ORDER BY number DESC;');
        $lastepisode = $episodes->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT);

        include "new-episode-form.php";
      } else {
        echo "<div class=\"edamame-warning\">Please log in to edit episode info</div>";
      }
    }

    protected function writeEpisode() {
      $imagefilename = NULL;
      if ($_FILES['ep-imagefile']['error'] == UPLOAD_ERR_OK) {
        if ($_POST['ep-imagename']) {
          $imagefilename = $_POST['ep-imagename'];
        } else {
          $imagefilename = $_FILES['ep-imagefile']['name'];
        }
        $imagefullpath = $this->mediaPath . $imagefilename; 
        move_uploaded_file($_FILES['ep-imagefile']['tmp_name'],$imagefullpath);
      }

      $mediafilename = NULL;
      if ($_FILES['ep-mediafile']['error'] == UPLOAD_ERR_OK) {
        if ($_POST['ep-medianame']) {
          $mediafilename = $_POST['ep-medianame'];
        } else {
          $mediafilename = $_FILES['ep-mediafile']['name'];
        }

        $mediafullpath = $this->mediaPath . $mediafilename;
        move_uploaded_file($_FILES['ep-mediafile']['tmp_name'],$mediafullpath);
      }

      $guid = $this::generateGUID();
      $permalink = $guid;
      if ($_POST['ep-permalink']) {
        $permalinkcheck = $this->db->prepare("SELECT count(*) FROM episodes WHERE permalink=:permalink;");
        $permalinkcheck->execute(array(':permalink' => $_POST['ep-permalink']));
        $results = $permalinkcheck->fetch(PDO::FETCH_ASSOC);

        if ($results['count(*)'] == 0) {
          $permalink = $_POST['ep-permalink'];
        }
      }

      $episodeupdate = $this->db->prepare("
        INSERT INTO `episodes` (
          season,
          number,
          title,
          artist,
          episodetype,
          shortdesc,
          longdesc,
          imagefile,
          mediafile,
          mediatype,
          mediasize,
          timestamp,
          duration,
          permalink,
          guid)
        VALUES (
          :season,
          :number,
          :title,
          :artist,
          :episodetype,
          :shortdesc,
          :longdesc,
          :imagefile,
          :mediafile,
          :mediatype,
          :mediasize,
          :timestamp,
          :duration,
          :permalink,
          :guid);
        ");

      $episodeupdate->execute(array(
        ':season'      => $_POST['ep-season'],
        ':number'      => $_POST['ep-number'],
        ':title'       => $_POST['ep-title'],
        ':artist'      => $_POST['ep-artist'],
        ':episodetype' => $_POST['ep-type'],
        ':shortdesc'   => $_POST['ep-shortdesc'],
        ':longdesc'    => $_POST['ep-longdesc'],
        ':imagefile'   => $imagefilename,
        ':mediafile'   => $mediafilename,
        ':mediatype'   => 'audio/mpeg',
        ':mediasize'   => $_POST['ep-mediasize'],
        ':timestamp'   => strtotime($_POST['ep-releasedate'].' '.$_POST['ep-releasetime']),
        ':duration'    => $_POST['ep-duration'],
        ':permalink'   => $permalink,
        ':guid'        => $guid
      ));
    } // writeEpisode

    protected function updateEpisode() {
      $epQuery = $this->db->prepare('SELECT * FROM episodes WHERE id=:id;');
      $epQuery->execute(array(':id' => $_POST['ep-id']));
      $episode = $epQuery->fetch(PDO::FETCH_ASSOC);

      $imagefilename = $episode['imagefile'];
      if ($_FILES['ep-imagefile']['error'] == UPLOAD_ERR_OK) {
        if ($_POST['ep-imagename']) {
          $imagefilename = $_POST['ep-imagename'];
        } else {
          $imagefilename = $_FILES['ep-imagefile']['name'];
        }

        $imagefullpath = $this->mediaPath . $imagefilename; 
        move_uploaded_file($_FILES['ep-imagefile']['tmp_name'],$imagefullpath);
      }

      $mediafilename = NULL;
      if ($_FILES['ep-mediafile']['error'] == UPLOAD_ERR_OK) {
        if ($_POST['ep-medianame']) {
          $mediafilename = $_POST['ep-medianame'];
        } else {
          $mediafilename = $_FILES['ep-mediafile']['name'];
        }

        $mediafullpath = $this->mediaPath . $mediafilename;
        move_uploaded_file($_FILES['ep-mediafile']['tmp_name'],$mediafullpath);
      }

      $guid = $episode['guid'];
      $permalink = $guid;
      if ($_POST['ep-permalink']) {
        $permalinkcheck = $this->db->prepare("SELECT count(*) FROM episodes WHERE permalink=:permalink;");
        $permalinkcheck->execute(array(':permalink' => $_POST['ep-permalink']));
        $results = $permalinkcheck->fetch(PDO::FETCH_ASSOC);

        if ($results['count(*)'] == 0) {
          $permalink = $_POST['ep-permalink'];
        }
      }

      $episodeupdate = $this->db->prepare("
        UPDATE `episodes` SET (
          season,
          number,
          title,
          artist,
          episodetype,
          shortdesc,
          longdesc,
          imagefile,
          mediafile,
          mediatype,
          mediasize,
          timestamp,
          duration,
          permalink,
          guid)
        = (
          :season,
          :number,
          :title,
          :artist,
          :episodetype,
          :shortdesc,
          :longdesc,
          :imagefile,
          :mediafile,
          :mediatype,
          :mediasize,
          :timestamp,
          :duration,
          :permalink,
          :guid)
        WHERE
          id=:id;
        ");

      $episodeupdate->execute(array(
        ':season'      => $_POST['ep-season'],
        ':number'      => $_POST['ep-number'],
        ':title'       => $_POST['ep-title'],
        ':artist'      => $_POST['ep-artist'],
        ':episodetype' => $_POST['ep-type'],
        ':shortdesc'   => $_POST['ep-shortdesc'],
        ':longdesc'    => $_POST['ep-longdesc'],
        ':imagefile'   => $imagefilename,
        ':mediafile'   => $mediafilename,
        ':mediatype'   => 'audio/mpeg',
        ':mediasize'   => $_POST['ep-mediasize'],
        ':timestamp'   => strtotime($_POST['ep-releasedate'].' '.$_POST['ep-releasetime']),
        ':duration'    => $_POST['ep-duration'],
        ':permalink'   => $permalink,
        ':guid'        => $guid,
        ':id'          => $_POST['ep-id']
      ));
    } // updateEpisode

    public function editEpisode($formTargetPath = "") {
      if ($this->verified) {
        if (isset($_POST['form-type']) && $_POST['form-type'] == "episode") {
          $this->updateEpisode();
        }

        $series = $this->series;

        $episodeQuery = $this->db->prepare("SELECT * FROM episodes WHERE id=:id;");
        $episodeQuery->execute(array(':id' => $_GET['id']));
        $episode = $episodeQuery->fetch(PDO::FETCH_ASSOC);

        include "edit-episode-form.php";
      } else {
        echo "<div class=\"edamame-warning\">Please log in to edit episode info</div>";
      }
    } // editEpisode


    // TODO: this is for testing purposes, delete at some point
    // alt:  call on every page load? preview page?
    public function writeData() {
      if ($_POST['form-type'] == "series") {
        $this->writeSeries();
      } else if ($_POST['form-type'] == "episode") {
        $this->writeEpisode();
      } else if ($_POST['form-type'] == "updateEpisode") {
        $this->updateEpisode();
      }
    }

    protected function writeSeries() {
      // TODO: CHECK INPUT

      $imagefilename = NULL;
      if ($_FILES['series-imagefile']['error'] == UPLOAD_ERR_OK) {
        if ($_POST['series-imagename']) {
          $imagefilename = $_POST['series-imagename'];
        } else {
          $imagefilename = $_FILES['series-imagefile']['name'];
        }
        $imagefullpath = $this->mediaPath . $imagefilename; 
        move_uploaded_file($_FILES['series-imagefile']['tmp_name'],$imagefullpath);
      }

      $seriesupdate = $this->db->prepare("
        UPDATE `seriesinfo`
        SET `title`       =:title,
            `artist`      =:artist,
            `copyright`   =:copyright,
            `url`         =:url,
            `owner`       =:owner,
            `email`       =:email,
            `shortdesc`   =:shortdesc,
            `longdesc`    =:longdesc,
            `imagefile`   =:imagefile,
            `seriestype`  =:seriestype,
            `category`    =:category,
            `explicit`    =:explicit,
            `language`    =:language
        WHERE `_rowid_`='1';");
      // add subcategory

      $seriesupdate->execute(array(
        ':title'       => $_POST['series-title'],
        ':artist'      => $_POST['series-artist'],
        ':copyright'   => $_POST['series-copyright'],
        ':url'         => $_POST['series-url'],
        ':owner'       => $_POST['series-owner'],
        ':email'       => $_POST['series-email'],
        ':shortdesc'   => $_POST['series-shortdesc'],
        ':longdesc'    => $_POST['series-longdesc'],
        ':imagefile'   => $imagefilename,
        ':seriestype'  => $_POST['series-type'],
        ':category'    => $_POST['series-category'],
        ':explicit'    => $_POST['series-explicit'],
        ':language'    => $_POST['series-language']
      ));

    }
    
    public function rss() {
      $series = $this->db->query('SELECT * FROM seriesinfo;')->fetch(PDO::FETCH_ASSOC);
      // TODO: filter out future episodes
      $episodes = $this->db->prepare('SELECT * FROM episodes WHERE timestamp < :now ORDER BY timestamp DESC;');
      $episodes->execute(array(':now' => date('U')));
      include "feed.rss";
    }

    protected static function generateGUID() {
      $bytes = random_bytes(16);

      $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
      $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

      $guid = vsprintf("%s%s-%s-%s-%s-%s%s%s", str_split(bin2hex($bytes), 4));
      return $guid;
    }
  }

?>
