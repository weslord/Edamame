<?php
  include '../src/edamame.php';
  $sample = new Edamame(__DIR__."/podcast.db3");
?>
<html>
<head>
  <title>Sample Page</title>
  <link rel="stylesheet" type="text/css" href="edamame-default.css">
</head>
<body>
  <?php
    $sample->adminLogin();
  ?>
  <a href='admin.php'>Admin</a>

  <?php
    $sample->seriesInfo();
    $sample->listEpisodes();
  ?>

</body>
</html>
