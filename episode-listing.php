<?php
  require_once 'db.php';
?>
  <div id="podpub-episodes">
    <?php
      while ($episode = $episodes->fetchArray(SQLITE3_ASSOC)) {
    ?>

    <div id="podpub-ep-<?= $episode['number'] ?>" class="podpub-episode">
      <h2><?= $episode['number'] ?> - <?= $episode['title'] ?></h2>
      <p>Released <?= $episode['timestamp'] ?></p>
      <p><?= $episode['shortdesc'] ?></p>
    </div>

    <?php } ?>

  </div>
</div>