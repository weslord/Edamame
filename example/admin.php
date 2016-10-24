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
    require 'admin-series.php';
    require 'admin-episodes.php';
  ?>

</body>
</html>
