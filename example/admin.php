<?php ?>
<html>
<head>
  <title>Admin Page</title>
  <link rel="stylesheet" type="text/css" href="edamame-default.css">
</head>
<body>
  <a href='index.php'>Listings</a>
  <h1>Admin Dashboard</h1>

  <?php
    include '../src/edamame.php';
  
    $dbpath = getcwd()."/podcast.db3";
    $sample = new Edamame($dbpath);
  
    $sample->adminSeries();
    $sample->adminEpisode();
  ?>

</body>
</html>
