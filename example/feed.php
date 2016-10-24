<?php
  include '../src/edamame.php';

  $dbpath = getcwd()."/podcast.db3";
  $sample = new Edamame($dbpath);

  $sample->rss();
?>