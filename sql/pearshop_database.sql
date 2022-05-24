CREATE DATABASE IF NOT EXISTS pearstore_database;
USE pearstore_database;
CREATE TABLE Artikel_Art (
    AArtid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    AArt_Name VARCHAR(25) NOT NULL
);
CREATE TABLE Artikel (
    Anr INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    AArtid INT NOT NULL,
    Preis INT NOT NULL,
    Beschreibung VARCHAR(280) NOT NULL,
    Name VARCHAR(40) NOT NULL,
	Menge INT,
    FOREIGN KEY(AArtid) REFERENCES Artikel_Art (AArtid)
);
CREATE TABLE Ort (
    OrtId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    PLZ INT NOT NULL,
	Ort VARCHAR(32) NOT NULL
);
CREATE TABLE Benutzer (
    BNR INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Vorname VARCHAR(20) NOT NULL,
    Nachname VARCHAR(30) NOT NULL,
	Typ INT NOT NULL DEFAULT 0,
    Email VARCHAR(40) NOT NULL,
    Passwort VARCHAR(64) NOT NULL,
    Adresse VARCHAR(80) NOT NULL,
    Ortid INT NOT NULL,
    FOREIGN KEY (Ortid) REFERENCES Ort(Ortid)
);
CREATE TABLE Bestellung (
    BID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    BNR INT NOT NULL,
    FOREIGN KEY (BNR) REFERENCES Benutzer(BNR)
);
CREATE TABLE Bestpos (
    BestNr INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    BID INT NOT NULL,
    Anr INT NOT NULL,
    FOREIGN KEY (Anr) REFERENCES Artikel(Anr),
    FOREIGN KEY (BID) REFERENCES Bestellung(BID)
);
CREATE TABLE Login (
    SessionId VARCHAR(40) PRIMARY KEY,
    Zeitstempel datetime NOT NULL,
    BNR INT NOT NULL,
    FOREIGN KEY (BNR) REFERENCES Benutzer(BNR)
);

# Einfuegen von Artikel Arten
INSERT INTO Artikel_Art (AArt_Name) VALUES ('CPU');
INSERT INTO Artikel_Art (AArt_Name) VALUES ('GPU');
INSERT INTO Artikel_Art (AArt_Name) VALUES ('RAM');

# Einfuegen von Artikeln

INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 100, 'Dies ist eine CPU', 'Intel Core i5 8600k', 50);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 250, 'Dies ist eine GPU', 'Nvidia Geforce GTX1050Ti', 55);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 400, 'Dies ist eine CPU', 'Intel Core i7 7700k', 20);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 800, 'Dies ist eine GPU', 'Nvidia Geforce GTX1080Ti', 10);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 150, 'Dies ist eine CPU', 'Intel Core i3 8100k', 5);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 780, 'Dies ist eine GPU', 'Nvidia Geforce RTX3070Ti', 7);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 285, 'Dies ist eine CPU', 'Intel Core i7 9700k', 10);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "RAM"), 35,  'Kingston FURY Beast 8GB DDR4-3200 Mhz',	'Kingston Arbeitsspeicher 8GB', 60);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 330, "Dies ist eine CPU", "AMD Ryzen 7 3700X", 50);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 3000, "Dies ist eine Goldene GPU", "Nvidia Titan RTX", 10);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 3000, "Dies ist eine Extrem Goldene GPU", "Nvidia Titan V", 3);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 6072, "Dies ist eine Shiny GPU", "Nvidia Quadro RTX 8000", 2);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 950, "Dies ist eine GPU", "AMD Radeon Rx 6800", 9);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "RAM"), 1285, "128GB PowerEdge C6520 C-Serie Arbeitsspeicher - RAM 2933MHz", "ECC", 60);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 500, 'Dies ist eine CPU', 'AMD AM4 Ryzen 9 5950X', 20);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "RAM"), 285, "VENGEANCE® RGB 32 GB (4 x 8 GB) DDR4 DRAM 4.000 MHz - RAM 4000MHz", "Corsair VENGEANCE Arbeitsspeicher 4x8GB", 25);


# Ort
INSERT INTO Ort (PLZ,Ort) VALUES (70565,"Stuttgart");
INSERT INTO Ort (PLZ,Ort) VALUES (71131,"Jettingen");
INSERT INTO Ort (PLZ,Ort) VALUES (70439,"Stuttgart");



# User Temporary
INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid, Typ) VALUES ('Dennis', 'Just', 'dennis.just@its-stuttgart.de', '$2y$11$CK6twagYBBYdDq/T3Nxzv.7uuhLm5MnmteqY/jI6P3HwRXWweWz7i', 'BreitwiesenstraÃŸe 20-22', (SELECT OrtId FROM Ort WHERE PLZ = 70565), 3);
INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid, Typ) VALUES ('Nico', 'Flister', 'nico.flister@web.de', '$2y$11$CK6twagYBBYdDq/T3Nxzv.P6rGYOhuv0ITgBqOlxkSpSRZU1XBiqO', 'Hebelstraße 1', (SELECT OrtId FROM Ort WHERE PLZ = 71131),0);
INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid, Typ) VALUES ('Binyam', 'Tefera', 'binyam@tefera.de', '$2y$11$CK6twagYBBYdDq/T3Nxzv.7uuhLm5MnmteqY/jI6P3HwRXWweWz7i', 'BreitwiesenstraÃŸe 20-22', (SELECT OrtId FROM Ort WHERE PLZ = 70439), 0);
