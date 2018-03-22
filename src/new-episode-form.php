<div>
  <h2>Add Episode</h2>
  <form enctype="multipart/form-data" method="post" action="<?= $formTargetPath ?>">
    <input type="hidden" name="form-type" value="episode" />
    <input type="hidden" name="ep-id" value="" />

    <hr>
    <label>MP3 file:<br>
      <input id="ep-mediafile" name="ep-mediafile" type="file" accept="audio/mpeg" /><br>
      <audio id="ep-audiopreview" controls ></audio>
    </label><br>
    <label>Length: (HH:MM:SS)
      <input id="ep-duration" name="ep-duration" type="text" readonly />
    </label><br>
    <label>File size: (bytes)
      <input id="ep-mediasize" name="ep-mediasize" type="text" readonly />
    </label><br>
    <label>Filename:
      <input id="ep-medianame" name="ep-medianame" type="text" readonly />
    </label><br>

    <hr>
    <label>Cover image:<br>
      <input id="ep-imagefile" name="ep-imagefile" type="file" accept="image/*"/><br>
      <img id="ep-imagepreview" width='250px' height='250px' src='<?= $this->mediaURI . $series['imagefile'] ?>' />
    </label><br>
    <label>Image filename:
      <input id="ep-imagename" name="ep-imagename" type="text" value='<?= $series['imagefile'] ?>' readonly />
    </label><br>

    <hr>
    <label>Season #: (optional)
      <input name="ep-season" type="text" value="<?= $lastepisode['season']; ?>"/></label><br>
    <label>Episode #:
      <input name="ep-number" type="text" value="<?= $lastepisode['number']+1; ?>"/></label><br>
    <label>Episode title:
      <input name="ep-title" type="text" value="<?= "Episode ".($lastepisode['number']+1); ?>"/></label><br>
    <?php // <label>Artist: ?>
      <input type="hidden" name="ep-artist" type="text" value="<?= $series['artist']; ?>"/></label>
    <label>Long description:<br>
      <textarea name="ep-longdesc" ></textarea>
    </label><br>
    <label>Short description:
      <input name="ep-shortdesc" type="text" />
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
      <input name="ep-permalink" type="text" pattern="[\w-]+" />
    </label><br>
    <input type="submit" />
  </form>
</div>
