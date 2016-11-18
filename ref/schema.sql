CREATE TABLE admin (
  email TEXT,
  password TEXT,
  token TEXT,
  timestamp INTEGER,
  persistent bool
);

CREATE TABLE episodes (
  number INTEGER,
  title TEXT,
  artist TEXT,
  shortdesc TEXT,
  longdesc TEXT,
  imagefile TEXT,
  mediafile TEXT,
  mediasize INTEGER,
  mediatype TEXT,
  timestamp INTEGER,
  duration INTEGER,
  guid TEXT UNIQUE
);

CREATE TABLE seriesinfo (
  title TEXT,
  artist TEXT,
  copyright TEXT,
  url TEXT,
  owner TEXT,
  email TEXT,
  shortdesc TEXT,
  longdesc TEXT,
  imagefile TEXT,
  mediafolder TEXT,
  category TEXT,
  subcategory TEXT,
  explicit NUMERIC,
  language TEXT
);