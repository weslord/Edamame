<?php
  require 'db.php';

  $seriesupdate = $db->prepare("
    UPDATE `seriesinfo`
    SET `title`=:title,
        `artist`=:artist,
        `copyright`=:copyright,
        `url`=:url,
        `owner`=:owner,
        `email`=:email,
        `shortdesc`=:shortdesc,
        `longdesc`=:longdesc,
        `category`=:category,
        `explicit`=:explicit,
        `language`=:language
    WHERE `_rowid_`='1';");

  $seriesupdate->execute(array(
    ':title' => $_POST['series-title'],
    ':artist' => $_POST['series-artist'],
    ':copyright' => $_POST['series-copyright'],
    ':url' => $_POST['series-url'],
    ':owner' => $_POST['series-owner'],
    ':email' => $_POST['series-email'],
    ':shortdesc' => $_POST['series-shortdesc'],
    ':longdesc' => $_POST['series-longdesc'],
    ':category' => $_POST['series-category'],
    ':explicit' => $_POST['series-explicit'],
    ':language' => $_POST['series-language'],
    ));

    if (!$imagedir) {
      $imagedir = getcwd();
    }

    // check $_FILE for errors, type, etc
    if ($_FILES['series-imageurl']['error'] == UPLOAD_ERR_OK) {
      // save to series cover location
      $imagepath = $imagedir . "/cover.png"; // check for type, set extension
      move_uploaded_file($_FILES['series-imageurl']['tmp_name'],$imagepath);

      // delete/archive existing, if different
    }

?>
