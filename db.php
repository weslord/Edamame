<?php
  //  $dbpath = "/FULL/PATH/TO/podcast.db3" // Absolute path to db3 file
  $dsn = "sqlite:".$dbpath;
  $db = new PDO($dsn); // add some error handling/checking...
  $series = $db->query('SELECT * FROM seriesinfo;')->fetch(PDO::FETCH_ASSOC);
  $episodes = $db->query('SELECT * FROM episodes ORDER BY number DESC;');

?>