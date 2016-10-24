<?php
  require_once 'config.php';

  $dsn = "sqlite:".$dbpath;
  $db = new PDO($dsn); // add some error handling/checking...
  $series = $db->query('SELECT * FROM seriesinfo;')->fetch(PDO::FETCH_ASSOC);
  $episodes = $db->query('SELECT * FROM episodes ORDER BY number DESC;');

?>
