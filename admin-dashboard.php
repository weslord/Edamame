<?php
  require_once 'db.php';
  $lastepisode = $episodes->fetch(PDO::FETCH_ASSOC);
?>
<div>
  <h1>Admin Dashboard</h1>
  <div>
    <h2>Series Info</h2>
    <form>
      <label>Title<input type="text" value="<?= $series['title'] ?>"/></label><br>
      <label>Artist<input type="text" value="<?= $series['artist']?>"/></label><br>
      <label>Copyright<input type="text" value="<?= $series['copyright']?>"/></label><br>
      <label>Main site URL<input type="text" value="<?= $series['url']?>"/></label><br>
      <label>Admin contact<input type="text" value="<?= $series['owner']?>"/></label><br>
      <label>Admin email<input type="email" value="<?= $series['email']?>"/></label><br>
      <label>Short description<input type="text" value="<?= $series['shortdesc']?>"/></label><br>
      <label>Long description<br>
        <textarea placeholder="<?= $series['shortdesc']?>"><?= $series['longdesc']?></textarea>
      </label><br>
      <label>Cover image<br>
        <input type="file" accept="image/*"/><br>
        <img src="<?= $series['imageurl']?>" width="250px" height="250px"/>
      </label><br>
      <label>Category
        <select><?php // loop thru, populating with options, add selected to db match, populate appropriate subcategory ?>
          <option></option>
          <option>Arts</option>
          <option>Business</option>
          <option>Comedy</option>
          <option>Education</option>
          <option>Games &amp; Hobbies</option>
          <option>Government &amp; Organizations</option>
          <option>Health</option>
          <option>Kids &amp; Family</option>
          <option>Music</option>
          <option>News &amp; Politics</option>
          <option>Religion &amp; Spirituality</option>
          <option>Science &amp; Medicine</option>
          <option>Society &amp; Culture</option>
          <option>Sports &amp; Recreation</option>
          <option>Technology</option>
          <option>TV &amp; Film</option>
        </select>
      </label><br>
<?php /*
      <label>Subcategory
        <select disabled>
          <option></option>
        </select>
      </label><br>
*/ ?>
      <label>Language<br>
        <select>
          <option value="zh-Hans">Chinese (Simplified)</option>
          <option value="zh-Hant">Chinese (Traditional)</option>
          <option value="da"     >Danish</option>
          <option value="nl"     >Dutch</option>
          <option value="en" selected>English</option>
          <option value="en-AU"  >English (Australian)</option>
          <option value="en-GB"  >English (British)</option>
          <option value="en-CA"  >English (Canadian)</option>
          <option value="en-US"  >English (United States)</option>
          <option value="fi"     >Finnish</option>
          <option value="fr"     >French</option>
          <option value="fr-CA"  >French (Canadian)</option>
          <option value="de"     >German</option>
          <option value="el"     >Greek</option>
          <option value="id"     >Indonesian</option>
          <option value="it"     >Italian</option>
          <option value="ja"     >Japanese</option>
          <option value="ko"     >Korean</option>
          <option value="ms"     >Malay</option>
          <option value="nb"     >Norwegian (Bokmal)</option>
          <option value="pt"     >Portuguese</option>
          <option value="pt-BR"  >Portuguese (Brazil)</option>
          <option value="ru"     >Russian</option>
          <option value="es"     >Spanish</option>
          <option value="es-MX"  >Spanish (Mexican)</option>
          <option value="sv"     >Swedish</option>
          <option value="th"     >Thai</option>
          <option value="tr"     >Turkish</option>
          <option value="vi"     >Vietnamese</option>
        </select>
      </label><br>
      <label>Clean<input type="radio" name="explicit" value="clean" checked/></label>
      <label>Explicit<input type="radio" name="explicit" value="explicit"/></label><br>
      <br><input type="submit" />
    </form>
  </div>

  <div>
    <h2>Add Episode</h2>
    <label>Episode #<input type="text" value="<?= $lastepisode['number']+1; ?>"/></label><br>
    <label>Episode title: <input type="text" value="<?= $series['title']; ?>"/></label><br>
    <label>Artist: <input type="text" value="<?= $series['artist']; ?>"/></label><br>
    <label>Short description: <input type="text" value="<?= $series['shortdesc']; ?>"/></label><br>
      <label>Long description<br>
        <textarea placeholder="<?= $series['shortdesc']?>"><?= $series['longdesc']?></textarea>
      </label><br>
    <label>Cover image<br>
      <input type="file" accept="image/*"/><br>
      <img width='250px' height='250px' src='<?= $series['imageurl'] ?>' />
    </label><br>
    <label>MP3 File:<br>
      <input type="file" accept="audio/mpeg"/>
    </label><br>
    <label>Timestamp: <input type="text" value="<?=  date('l F jS, Y'); //['timestamp'] ?>"/></label><br>
    <label>Length: (HH:MM:SS)<input type="text" value="<?php //['duration'] ?>"/></label>
  </div>
</div>

