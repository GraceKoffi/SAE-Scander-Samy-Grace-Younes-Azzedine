DROP TABLE IF EXISTS name_basics;
CREATE TABLE IF NOT EXISTS name_basics (
  nconst VARCHAR(11) PRIMARY KEY,
  primaryName TEXT,
  birthyear INTEGER,
  deathYear INTEGER,
  primaryProfession TEXT,
  knownForTitles TEXT
);

DROP TABLE IF EXISTS title_akas;
CREATE TABLE IF NOT EXISTS title_akas (
  titleId TEXT,
  ordering INTEGER,
  title TEXT,
  region TEXT,
  language TEXT,
  types TEXT,
  attributes TEXT,
  isOriginalTitle INTEGER,
  PRIMARY KEY(titleId, ordering)
);

DROP TABLE IF EXISTS title_basics;
CREATE TABLE IF NOT EXISTS title_basics (
  tconst VARCHAR(11) PRIMARY KEY,
  titleType TEXT,
  primaryTitle TEXT,
  originalTitle TEXT,
  isAdult INTEGER,
  startYear INTEGER,
  endYear TEXT,
  runtimeMinutes INTEGER,
  genres TEXT
);

DROP TABLE IF EXISTS title_crew;
CREATE TABLE IF NOT EXISTS title_crew (
  tconst VARCHAR(11) PRIMARY KEY,
  directors TEXT,
  writers TEXT
);

DROP TABLE IF EXISTS title_episode;
CREATE TABLE IF NOT EXISTS title_episode (
  tconst VARCHAR(11) PRIMARY KEY,
  parentTconst TEXT,
  seasonNumber INTEGER,
  episodeNumber INTEGER
);

DROP TABLE IF EXISTS title_principals;
CREATE TABLE IF NOT EXISTS title_principals (
  tconst TEXT,
  ordering INTEGER,
  nconst TEXT,
  category TEXT,
  job TEXT,
  characters TEXT,
  PRIMARY KEY(tconst, ordering)
);

DROP TABLE IF EXISTS title_ratings;
CREATE TABLE IF NOT EXISTS title_ratings (
  tconst VARCHAR(11) PRIMARY KEY,
  averageRating DOUBLE PRECISION,
  numVotes INTEGER
);
-- Création de la table UserData
DROP TABLE IF EXISTS UserData;
CREATE TABLE UserData (
    userId SERIAL PRIMARY KEY,
    username TEXT,
    password TEXT,
    connectionTime TIMESTAMP
);

-- Création de la table RechercheData
DROP TABLE IF EXISTS RechercheData;
CREATE TABLE RechercheData (
    rechercheId SERIAL PRIMARY KEY,
    motCle TEXT,
    userId INT,
    typeRecherche TEXT,
    FOREIGN KEY (userId) REFERENCES UserData(userId)
);

