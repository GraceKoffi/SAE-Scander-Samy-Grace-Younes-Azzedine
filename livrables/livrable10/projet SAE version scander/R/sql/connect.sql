CREATE TABLE User (
    userId SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Recherche (
    RechercheId SERIAL PRIMARY KEY,
    UserId INTEGER REFERENCES User(userId),
    TypeRecherche VARCHAR(255) NOT NULL,
    MotsCles VARCHAR(255) NOT NULL,
    DateConnection TIMESTAMP NOT NULL
);
