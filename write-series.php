<?php
  require "db.php";

  var_dump($_POST);

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
?>