<?php
  require_once 'db.php';
?>

<div id="podpub-episodes">
  <?php
    while ($episode = $episodes->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)) {
  ?>

  <?php //add even+odd episode classes? ?>
  <div class="podpub-episode" id="podpub-ep-<?= $episode['number'] ?>">
    <h2 class="podpub-title"><?= $episode['number'] ?> - <?= $episode['title'] ?></h2>
    <span class="podpub-timestamp"><?= date('l F jS, Y', $episode['timestamp']); ?></span>
    <div class="podpub-longdesc"><?= str_replace(['<![CDATA[',']]>'],"",$episode['longdesc']) ?></div>
    <a class="podpub-mediaurl" href="<?= $episode['mediaurl'] ?>">mp3</a>
  </div>

  <?php } ?>

</div>