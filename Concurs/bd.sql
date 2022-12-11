CREATE TABLE Usuaris (
    Usuari varchar(255),
    Contrassenya varchar(255)
);

CREATE TABLE Rondes (
    Numero varchar(255),
    DataInici varchar(255),
    DataFi varchar(255)
);

CREATE TABLE Gossos (
    ID int,
    Nom varchar(255),
    Imatge varchar(255),
    Amo varchar(255),
    Raca varchar(255),
    Ronda varchar(255),
    Punts int
);