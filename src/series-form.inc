<div>
  <h2>Series Info</h2>
  <form enctype="multipart/form-data" method="post" action="">
    <input type="hidden" name="form-type" value="series">
    <label>Title
      <input name="series-title" type="text" value="<?= $series['title'] ?>"/>
    </label><br>
    <label>Artist
      <input name="series-artist" type="text" value="<?= $series['artist']?>"/>
    </label><br>
    <label>Copyright<input name="series-copyright" type="text" value="<?= $series['copyright']?>"/></label><br>
    <label>Main site URL<input name="series-url" type="text" value="<?= $series['url']?>"/></label><br>
    <label>Admin contact<input name="series-owner" type="text" value="<?= $series['owner']?>"/></label><br>
    <label>Admin email<input name="series-email" type="email" value="<?= $series['email']?>"/></label><br>
    <label>Short description<input name="series-shortdesc" type="text" value="<?= $series['shortdesc']?>"/></label><br>
    <label>Long description<br>
      <textarea name="series-longdesc" placeholder="<?= $series['shortdesc']?>"><?= $series['longdesc']?></textarea>
    </label><br>
    <label>Cover image<br>
      <input name="series-imagefile" type="file" accept="image/*"/><br>
      <img src="<?= $series['mediafolder'] . $series['imagefile'] ?>" width="250px" height="250px"/>
    </label><br>
    <label>Type of Series
      <select name="series-type">
        <option <?php if ($series['seriestype'] == 'Episodic') { echo 'selected'; } ?>>Episodic</option>
        <option <?php if ($series['seriestype'] == 'Serial')   { echo 'selected'; } ?>>Serial</option>
      </select>
    </label><br>
    <label>Category
      <select name="series-category"><?php // loop thru, populating with options, add selected to db match, populate appropriate subcategory ?>
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
      <select name="series-subcategory" disabled>
        <option></option>
      </select>
    </label><br>
*/ ?>
    <label>Language<br>
      <select name="series-language">
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
    <label>Clean<input type="radio" name="series-explicit" value="clean" <?php if ($series['explicit'] == 'clean') { echo 'checked'; } ?> /></label>
    <label>Explicit<input type="radio" name="series-explicit" value="explicit" <?php if ($series['explicit'] == 'explicit') { echo 'checked'; } ?> /></label><br>
<?php /* 
    <label>Media Folder
      <?= $server ?><input name="series-mediafolder" type="text" value="<?= $mediafolder ?>"/>
    </label><br>
*/ ?>
    <br><input type="submit" />
  </form>
</div>
