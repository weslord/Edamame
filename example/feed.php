<?php
  include '../src/edamame.php';
  $sample = new Edamame(__DIR__."/podcast.db3");
  $sample->rss();
?>