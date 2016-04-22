<?php
  include 'db.php';
?>
<div id="podpub-episode-listing">
  <div id="podpub-series-info">
    <h1><?= $series['title']; ?></h1>
    <p><?= $series['description']; ?></p>
    <a href="feed.rss">RSS feed</a>
  </div>

  <div id="podpub-episodes">

    <?php
      // need to sort db query as descending by date (or by episode number?)
      foreach ($episodes as $episode) {
    ?>

    <div id="podpub-ep-<?= $episode['number'] ?>" class="podpub-episode">
      <h2><?= $episode['number'] ?> - <?= $episode['title'] ?></h2>
      <p>Released <?= $episode['date'] ?></p>
      <p><?= $episode['description'] ?></p>
    </div>

    <?php } ?>

  </div>
</div>