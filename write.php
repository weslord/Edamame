<?php
  require "db.php";

  var_dump($_POST);

  $statement = $db->prepare("
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

  $statement->execute(array(
    ':title' => $_POST['title'],
    ':artist' => $_POST['artist'],
    ':copyright' => $_POST['copyright'],
    ':url' => $_POST['url'],
    ':owner' => $_POST['owner'],
    ':email' => $_POST['email'],
    ':shortdesc' => $_POST['shortdesc'],
    ':longdesc' => $_POST['longdesc'],
    ':category' => $_POST['category'],
    ':explicit' => $_POST['explicit'],
    ':language' => $_POST['language'],
    ));
?>