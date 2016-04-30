<?php
  require "db.php";

  var_dump($_POST);

  $seriesupdate = $db->prepare("
    INSERT INTO `episodes`  ( number, title, artist, shortdesc, longdesc, mediatype, timestamp, duration)
    VALUES                  (:number,:title,:artist,:shortdesc,:longdesc,:mediatype,:timestamp,:duration);");

  $seriesupdate->execute(array(
    ':number' => $_POST['ep-number'],
    ':title' => $_POST['ep-title'],
    ':artist' => $_POST['ep-artist'],
    ':shortdesc' => $_POST['ep-shortdesc'],
    ':longdesc' => $_POST['ep-longdesc'],
    ':mediatype' => $_POST['ep-mediatype'],
    ':timestamp' => strtotime($_POST['ep-timestamp']),
    ':duration' => $_POST['ep-duration'],
    ));
?>