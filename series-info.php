<?php
  require_once 'db.php';
?>
<div id="podpub-series-info">
  <h1><?= $series['title']; ?></h1>
  <p><?= $series['longdesc']; ?></p>
  <a href="feed.rss">RSS feed</a>
</div>