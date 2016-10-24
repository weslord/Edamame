CREATE TABLE `seriesinfo` (
  `title` TEXT,
  `artist`  TEXT,
  `copyright` TEXT,
  `url` TEXT,
  `owner` TEXT,
  `email` TEXT,
  `shortdesc` TEXT,
  `longdesc`  TEXT,
  `imageurl`  TEXT,
  `category`  TEXT,
  `subcategory` TEXT,
  `explicit`  NUMERIC,
  `language`  TEXT
);

CREATE TABLE `episodes` (
  `number`  INTEGER,
  `title` TEXT,
  `artist`  TEXT,
  `shortdesc` TEXT,
  `longdesc`  TEXT,
  `imageurl`  TEXT,
  `mediaurl`  TEXT,
  `mediasize` INTEGER,
  `mediatype` TEXT,
  `timestamp` INTEGER,
  `duration`  INTEGER # should this be text?
);
