<div>
  <h2>Add Episode</h2>
  <form enctype="multipart/form-data" method="post" action="<?= $formTargetPath ?>">
    <input type="hidden" name="form-type" value="episode" />
    <input type="hidden" name="ep-id" value="<?= $episode['id'] ?>" />

    <hr>
    <label>MP3 file:<br>
      <input id="ep-mediafile" name="ep-mediafile" type="file" accept="audio/mpeg" /><br>
      <audio id="ep-audiopreview" controls ></audio>
    </label><br>
    <label>Length: (HH:MM:SS)
      <input id="ep-duration" name="ep-duration" type="text" readonly value="<?= $episode['duration'] ?>" />
    </label><br>
    <label>File size: (bytes)
      <input id="ep-mediasize" name="ep-mediasize" type="text" readonly value="<?= $episode['mediasize'] ?>" />
    </label><br>
    <label>Filename:
      <input id="ep-medianame" name="ep-medianame" type="text" readonly value="<?= $episode['mediafile'] ?>" />
    </label><br>

    <hr>
    <label>Cover image:<br>
      <input id="ep-imagefile" name="ep-imagefile" type="file" accept="image/*"/><br>
      <img id="ep-imagepreview" width='250px' height='250px' src='<?= $this->mediaURI . $episode['imagefile'] ?>' />
    </label><br>
    <label>Image filename:
      <input id="ep-imagename" name="ep-imagename" type="text" readonly value="<?= $episode['imagefile'] ?>" />
    </label><br>

    <hr>
    <label>Season #: (optional)
      <input name="ep-season" type="text" value="<?= $episode['season']; ?>"/></label><br>
    <label>Episode #:
      <input name="ep-number" type="text" value="<?= $episode['number'] ?>"/></label><br>
    <label>Episode title:
      <input name="ep-title" type="text" value="<?= $episode['title'] ?>"/></label><br>
    <?php // <label>Artist: ?>
      <input type="hidden" name="ep-artist" type="text" value="<?= $series['artist']; ?>"/>
    <?php // </label> ?>
    <label>Long description:<br>
      <textarea name="ep-longdesc" ><?= $episode['longdesc'] ?></textarea>
    </label><br>
    <label>Short description:
      <input name="ep-shortdesc" type="text" value="<?= $episode['shortdesc'] ?>" />
    </label><br>
    <label>Episode type:
      <select name="ep-type">
        <option 'selected'>Full</option>
        <option>Bonus</option>
        <option>Trailer</option>
      </select>
    </label><br>
    <label>Release Date:<br>
      <input name="ep-releasedate" type="date" value="<?= date('Y-m-d'); //['timestamp'] ?>"/>
      <input name="ep-releasetime" type="time" value="00:00"/>
    </label><br><br>
    <label>Episode Permalink:
      <br>(Valid characters: 'A-Z', 'a-z', '0-9', '_' and '-')<br>
      <input name="ep-permalink" type="text" pattern="[\w-]+" value="<?= $episode['permalink'] ?>" />
    </label><br>
    <input type="submit" />
  </form>
</div>
