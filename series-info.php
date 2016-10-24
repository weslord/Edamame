<?php
  require_once 'db.php';
?>
<div id="podpub-series-info">
  <h1><?= $series['title']; ?></h1>
  <p><?= $series['longdesc']; ?></p>
  <img src="<?= $series['imageurl']?>" width="250px" height="250px" />
  <a href="feed.rss">RSS feed</a><?php //get from db ?>
</div>
