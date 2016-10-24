<?php
  class Edamame {
    protected $db;
    protected $series;
    protected $episodes;

    function __construct($dbpath) {
      $dsn = "sqlite:".$dbpath;
      $this->db = new PDO($dsn); // add some error handling/checking...
      $this->series = $this->db->query('SELECT * FROM seriesinfo;')->fetch(PDO::FETCH_ASSOC);
      $this->episodes = $this->db->query('SELECT * FROM episodes ORDER BY number DESC;');
    }

    public function seriesInfo() {
      ?>
        <div id="podpub-series-info">
          <h1><?= $this->series['title']; ?></h1>
          <p><?= $this->series['longdesc']; ?></p>
          <img src="<?= $this->series['imageurl']?>" width="250px" height="250px" />
          <a href="feed.rss">RSS feed</a><?php //get from db ?>
        </div>
      <?php
    } // seriesInfo

    public function listEpisodes() {
      ?>
        <div id="podpub-episodes">
          <?php
            while ($episode = $this->episodes->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)) {
          ?>

            <div class="podpub-episode" id="podpub-ep-<?= $episode['number'] ?>">
              <h2 class="podpub-title"><?= $episode['number'] ?> - <?= $episode['title'] ?></h2>
              <span class="podpub-timestamp"><?= date('l F jS, Y', $episode['timestamp']); ?></span>
              <div class="podpub-longdesc"><?= str_replace(['<![CDATA[',']]>'],"",$episode['longdesc']) ?></div>
              <a class="podpub-mediaurl" href="<?= $episode['mediaurl'] ?>">mp3</a>
            </div>

          <?php } ?>

        </div>
      <?php

    } // listEpisodes

    public function adminSeries() {
      include "series-form.inc";
    } // adminSeries

    public function adminEpisode() {
      $lastepisode = $this->episodes->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT);
      include "episode-form.inc";
    }
  }

?>
