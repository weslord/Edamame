<?php
  $db = new SQLite3('./podcast.db3');
  $series = $db->query('SELECT * FROM seriesinfo;')->fetchArray(SQLITE3_ASSOC);

  // order by date instead?
  $episodes = $db->query('SELECT * FROM episodes ORDER BY number DESC;');
?>