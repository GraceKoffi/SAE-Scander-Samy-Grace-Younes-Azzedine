-- Création de la table name_basics (acteurs/actrices)
DROP TABLE IF EXISTS name_basics CASCADE;
CREATE TABLE IF NOT EXISTS name_basics (
  nconst VARCHAR(11) PRIMARY KEY,
  primaryName TEXT,
  birthyear INTEGER,
  deathYear INTEGER,
  primaryProfession TEXT,
  knownForTitles TEXT
);

INSERT INTO name_basics (nconst, primaryName, birthyear, deathYear, primaryProfession, knownForTitles) VALUES
('nm0000151', 'John Travolta', 1954, NULL, 'actor', 'tt0110912,tt0102926,tt0118751'),
('nm0000194', 'Harrison Ford', 1942, NULL, 'actor', 'tt0080684,tt0076759,tt0120915'),
('nm0000273', 'Rosanna Arquette', 1959, NULL, 'actress', 'tt0110912,tt0092099,tt0106332'),
('nm0000604', 'Jean Reno', 1948, NULL, 'actor', 'tt0110912,tt0110413,tt0097978'),
('nm0000198', 'Ewan McGregor', 1971, NULL, 'actor', 'tt0120915,tt0241527,tt0080684'),
('nm0000204', 'Natalie Portman', 1981, NULL, 'actress', 'tt0120915,tt0120737,tt0241527'),
('nm0000102', 'Samuel L. Jackson', 1948, NULL, 'actor', 'tt0110912,tt0378194,tt0343121'),
('nm0000243', 'Uma Thurman', 1970, NULL, 'actress', 'tt0110912,tt0266697,tt0266695'),
('nm0000217', 'Bruce Willis', 1955, NULL, 'actor', 'tt0110912,tt0378194,tt0110413'),
('nm0000323', 'Lucy Liu', 1968, NULL, 'actress', 'tt0266697,tt0167261,tt0110912'),
('nm0000318', 'Quentin Tarantino', 1963, NULL, 'director,writer,actor', 'tt0110912,tt0378194,tt0105236'),
('nm0000301', 'George Lucas', 1944, NULL, 'writer,producer,director', 'tt0120915,tt0076759,tt0086190'),
('nm0009190', 'Christopher Nolan', 1970, NULL, 'writer,producer,director', 'tt0468569,tt1375666,tt0209144'),
('nm0000229', 'Martin Scorsese', 1942, NULL, 'director,producer,writer', 'tt0110912,tt0407887,tt0068646'),
('nm0000108', 'Halle Berry', 1966, NULL, 'actress', 'tt0248667,tt0114148,tt0120338'),
('nm0000196', 'Tom Hanks', 1956, NULL, 'actor', 'tt0109830,tt0120815,tt0162222'),
('nm0000226', 'Julia Roberts', 1967, NULL, 'actress', 'tt0195685,tt0112384,tt0113277');

-- Création de la table title_principals (participations dans des films)
DROP TABLE IF EXISTS title_principals CASCADE;
CREATE TABLE IF NOT EXISTS title_principals (
  tconst TEXT,
  ordering INTEGER,
  nconst TEXT,
  category TEXT,
  job TEXT,
  characters TEXT,
  PRIMARY KEY(tconst, ordering)
);

INSERT INTO title_principals (tconst, ordering, nconst, category, job, characters) VALUES
('tt0110912', 1, 'nm0000151', 'actor', NULL, 'Vincent Vega'),
('tt0110912', 2, 'nm0000273', 'actress', NULL, 'Jody'),
('tt0110912', 3, 'nm0000604', 'actor', NULL, 'Léon'),
('tt0120915', 1, 'nm0000194', 'actor', NULL, 'Qui-Gon Jinn'),
('tt0120915', 2, 'nm0000198', 'actor', NULL, 'Obi-Wan Kenobi'),
('tt0120915', 3, 'nm0000204', 'actress', NULL, 'Padmé Amidala'),
('tt0266697', 1, 'nm0000243', 'actress', NULL, 'The Bride'),
('tt0266697', 2, 'nm0000323', 'actor', NULL, 'Bill'),
('tt0266697', 3, 'nm0000273', 'actress', NULL, 'O-Ren Ishii'),
('tt0468569', 1, 'nm0009190', 'director', NULL, NULL),
('tt1375666', 1, 'nm0009190', 'director', NULL, NULL),
('tt0080684', 1, 'nm0000301', 'writer', NULL, NULL),
('tt0076759', 1, 'nm0000301', 'writer', NULL, NULL),
('tt0068646', 1, 'nm0000229', 'director', NULL, NULL),
('tt0248667', 1, 'nm0000108', 'actress', NULL, 'Leticia Musgrove'),
('tt0248667', 2, 'nm0000273', 'actress', NULL, 'Miranda'),
('tt0248667', 3, 'nm0000323', 'actor', NULL, 'Hank'),
('tt0114148', 1, 'nm0000108', 'actress', NULL, 'Khaila Richards'),
('tt0114148', 2, 'nm0000196', 'actor', NULL, 'Dr. Malcolm Sayer'),
('tt0114148', 3, 'nm0000604', 'actor', NULL, 'Peter Ince'),
('tt0120338', 1, 'nm0000108', 'actress', NULL, 'Leticia Musgrove'),
('tt0120338', 2, 'nm0000194', 'actor', NULL, 'Hank Grotowski'),
('tt0120338', 3, 'nm0000226', 'actress', NULL, 'Sonny Grotowski');

-- Création de la table title_basics (films)
DROP TABLE IF EXISTS title_basics CASCADE;
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

INSERT INTO title_basics (tconst, titleType, primaryTitle, originalTitle, isAdult, startYear, endYear, runtimeMinutes, genres) VALUES
('tt0110912', 'movie', 'Pulp Fiction', 'Pulp Fiction', 0, 1994, NULL, 154, 'Crime,Drama'),
('tt0120915', 'movie', 'Star Wars: Episode I - The Phantom Menace', 'Star Wars: Episode I - The Phantom Menace', 0, 1999, NULL, 136, 'Action,Adventure,Fantasy'),
('tt0266697', 'movie', 'Kill Bill: Vol. 1', 'Kill Bill: Vol. 1', 0, 2003, NULL, 111, 'Action,Crime,Thriller'),
('tt0468569', 'movie', 'The Dark Knight', 'The Dark Knight', 0, 2008, NULL, 152, 'Action,Crime,Drama'),
('tt1375666', 'movie', 'Inception', 'Inception', 0, 2010, NULL, 148, 'Action,Adventure,Sci-Fi'),
('tt0209144', 'movie', 'Memento', 'Memento', 0, 2000, NULL, 113, 'Mystery,Thriller'),
('tt0248667', 'movie', 'Monsters Ball', 'Monsters Ball', 0, 2001, NULL, 111, 'Drama,Romance'),
('tt0114148', 'movie', 'Losing Isaiah', 'Losing Isaiah', 0, 1995, NULL, 111, 'Drama'),
('tt0120338', 'movie', 'Introducing Dorothy Dandridge', 'Introducing Dorothy Dandridge', 0, 1999, NULL, 120, 'Biography,Drama,Music');

-- Vos autres tables existantes restent inchangées

-- ... (les autres tables)

-- Insérez les autres données si nécessaire
