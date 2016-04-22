<?php
  // pull show info from database
  // pull list of episodes 
  include 'db.php';
?>
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
  <channel>
    <title><?= $series['title'] ?></title>
    <link><!-- URL: http://www.EXAMPLE.com/directory --></link>
    <copyright><!-- CC BY-NC  --></copyright>
    <itunes:author><!-- Goes into Artist tag --></itunes:author>
    <itunes:owner><!-- Should not be displayed... -->
      <itunes:name><!-- Admin contact name --></itunes:name>
      <itunes:email><!-- Admin contact email --></itunes:email>
    </itunes:owner>
    <itunes:subtitle><!-- Short description --></itunes:subtitle>
    <itunes:summary><?= $series['description'] ?></itunes:summary>
    <description><?= $series['description'] ?></description>
    <itunes:image href="URL" />
    <itunes:category text="Comedy">
    </itunes:category>
    <itunes:explicit><!-- Yes / No --></itunes:explicit>
    <language><!-- Canadian English: en-CA --></language>

<?php

  foreach ($episodes as $episode) {
  //

?>
    <item>
      <title><?= $episode['number'] ?> - <?= $episode["title"]; ?></title>
      <itunes:author><!-- Artist --></itunes:author>
      <itunes:subtitle><!-- Short episode description --></itunes:subtitle>
      <itunes:summary><?= $episode['description'] ?>
      </itunes:summary>
      <itunes:image href="IMAGE URL" />
      <enclosure url="MP3 URL" length="SIZE IN BYTES" type="audio/mpeg" />
      <guid><!-- Theoretically GUID, defaults to episode URL --></guid>
      <pubDate><!-- RFC 2822 format: Mon, 15 Feb 2016 20:00:00 GMT --></pubDate>
      <itunes:duration><!-- Format = HH:MM:SS --></itunes:duration>
    </item>

 <?php
  }
 ?>

  </channel>
</rss>
