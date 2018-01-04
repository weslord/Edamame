<div>
  <h2>Add Episode</h2>
  <form enctype="multipart/form-data" method="post" action="<?= $formTargetPath ?>">
    <input type="hidden" name="form-type" value="episode" />

    <label>MP3 File:<br>
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
    <label>Cover image<br>
      <input id="ep-imagefile" name="ep-imagefile" type="file" accept="image/*"/><br>
      <img id="ep-imagepreview" width='250px' height='250px' src='<?= $series['mediafolder'] . $series['imagefile'] ?>' />
    </label><br>
    <label>Image Filename:
      <input id="ep-imagename" name="ep-imagename" type="text" readonly />
    </label><br>

    <hr>
    <label>Season #: (optional)
      <input name="ep-season" type="text" value="<?= $lastepisode['season']; ?>"/></label><br>
    <label>Episode #:
      <input name="ep-number" type="text" value="<?= $lastepisode['number']+1; ?>"/></label><br>
    <label>Episode title:
      <input name="ep-title" type="text" value="<?= $series['title']." Episode ".($lastepisode['number']+1); ?>"/></label><br>
    <?php // <label>Artist: ?>
      <input type="hidden" name="ep-artist" type="text" value="<?= $series['artist']; ?>"/></label>
    <label>Episode type:
      <select name="ep-type">
        <option 'selected'>Full</option>
        <option>Bonus</option>
        <option>Trailer</option>
      </select>
    </label><br>
    <label>Short description:
      <input name="ep-shortdesc" type="text" value="<?= $series['shortdesc']; ?>"/></label><br>
    <label>Long description:<br>
      <textarea name="ep-longdesc" placeholder="<?= $series['shortdesc']?>"><?= $series['longdesc']?></textarea>
    </label><br>
    <label>Release Date:<br>
      <input name="ep-releasedate" type="date" value="<?= date('Y-m-d'); //['timestamp'] ?>"/>
      <input name="ep-releasetime" type="time" value="00:00"/></label><br>
    <input type="submit" />
  </form>
</div>
