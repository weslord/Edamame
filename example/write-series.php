<?php ?>
<html>
<head>
  <title>Sample Page</title>
  <link rel="stylesheet" type="text/css" href="edamame-default.css">
</head>
<body>
  <a href='index.php'>Listings</a> /
  <a href='admin.php'>Admin</a>

  <?php
    include '../src/edamame.php';
  
    $dbpath = getcwd()."/podcast.db3";
    $sample = new Edamame($dbpath);
  
    $sample->writeSeries();
  ?>

</body>
</html>
