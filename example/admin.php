<?php
  include '../src/edamame.php';
  $sample = new Edamame(__DIR__."/podcast.db3");
?>
<html>
<head>
  <title>Admin Page</title>
  <link rel="stylesheet" type="text/css" href="edamame-default.css">
</head>
<body>
  <a href='index.php'>Listings</a>
  <h1>Admin Dashboard</h1>

  <?php
    $sample->adminSeries();
    $sample->adminEpisode();
  ?>

</body>
</html>
