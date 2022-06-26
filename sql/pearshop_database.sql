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

INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 100, 'Anzahl der Kerne: 6 <br> Anzahl der Threads: 6 <br> Max. Turbo-Taktfrequenz 4,30 GHz <br> Taktfrequenz: 4.30 GHz <br> Grundtaktfrequenz des Prozessors: 3,60 GHz <br> Cache: 9 MB Intel® Smart Cache <br> Bus-Taktfrequenz: 8 GT/', 'Intel Core i5 8600k', 50);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 250, 'NVIDIA GeForce GTX 1050TI <br> 1417/1303MHz <br> 7008MHz <br> 4096MB <br> DDR5 RAM (128bit) <br> 1x DVI, 1x HDMI, 1x Display Port', 'Nvidia Geforce GTX1050Ti', 55);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 400, 'CPU-Hersteller: Intel <br> CPU-Modell: Core i7-870 <br> CPU-Taktfrequenz: 3.7 GHz <br> CPU-Sockel: 1151 ', 'Intel Core i7 7700k', 20);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 800, 'Grafik: NVIDIA GeForce GTX 1080 Ti - 11GB GDDR5X <br> Chip: GP102-350-K1-A1 "Pascal", 28SM, 471mm² <br> Schnittstelle: PCIe 3.0 x16 <br> ', 'Nvidia Geforce GTX1080Ti', 10);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 150, 'Produktsortiment: Intel® Core™ i3 Prozessoren der achten Generation <br> Prozessornummer: i3-8100 <br> Grundtaktfrequenz: 3.60 GHz <br> Bus-Taktfrequenz: 8GT/s ', 'Intel Core i3 8100k', 5);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 780, 'NVIDIA GeForce RTX 3070 Ti Founders Edition <br> Speichergröße: 8GB <br>  Speichergeschwindigkeit: GDDR6X <br> Anschlüsse: HDMI, 3x DP', 'Nvidia Geforce RTX3070Ti', 7);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 285, 'Intel Core i7-9700K Prozessor <br> Anzahl der Kerne: 8 <br> Max. Turbo-Taktfrequenz: 4.90 GHz <br> Bus-Taktfrequenz: 8GT/s ', 'Intel Core i7 9700k', 10);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "RAM"), 35,  'Kingston FURY Beast 8GB DDR4-3200 Mhz',	'Kingston Arbeitsspeicher 8GB', 60);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 330, "AMD Tyzen 7 3700X <br> Anzahl der CPU-Kerne: 8 <br> Anzahl der Threads: 16 <br> Basistaktrate: 3.60GHz  ", "AMD Ryzen 7 3700X", 50);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 3000, "NVIDIA Titan RTX <br> Basistakt der GPU: 1.350MHz <br> Grafikspeicher: 24KB GDDR6 <br> Speichertakt: 7.000MHz ", "Nvidia Titan RTX", 10);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 3000, "NVIDIA TITAN V Volta <br> RAM-Größe: 12280MB <br> Anschlüsse: 3x DP, 1xHDMI <br> ", "Nvidia Titan V", 3);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 6072, "NVIDIA Quadro RTX 8000 <br> RAM-Größe: 48GB <br> RAM-Typ: GDDR6 <br> Anschlüsse: 4x DP, USB-C <br> GPU-Taktfrequenz: 1396 MHz", "Nvidia Quadro RTX 8000", 2);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((Select AArtid FROM Artikel_Art WHERE AArt_Name = "GPU"), 950, "Radeon RX 6800 Gaming <br> Max. Speichergröße: 16 GB <br> Speichertyp: GDDR6 <br> Max. Speicherbandbreite: Bis zu 512 GB/s", "AMD Radeon Rx 6800", 9);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "RAM"), 1285, "128GB PowerEdge C6520 C-Serie Arbeitsspeicher - RAM 2933MHz", "ECC", 60);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "CPU"), 500, 'AMD Ryzen 9 5950X <br> Anzahl der CPU Kerne: 16x <br> Max. Turbotakt: 4.90GHz <br>  Prozessortakt: 3.40GHz', 'AMD AM4 Ryzen 9 5950X', 20);
INSERT INTO Artikel (AArtid, Preis, Beschreibung, Name, Menge) VALUES ((SELECT AArtid FROM Artikel_Art WHERE AArt_Name = "RAM"), 285, " Corsair VENGEANCE Arbeitsspeicher RGB <br> 32 GB (4 x 8 GB) <br> DDR4 DRAM 4.000 MHz", "Corsair VENGEANCE Arbeitsspeicher 4x8GB", 25);


# Ort
INSERT INTO Ort (PLZ,Ort) VALUES (70565,"Stuttgart");
INSERT INTO Ort (PLZ,Ort) VALUES (71131,"Jettingen");
INSERT INTO Ort (PLZ,Ort) VALUES (70439,"Stuttgart");



# User Temporary
INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid, Typ) VALUES ('Dennis', 'Just', 'dennis.just@its-stuttgart.de', '$2y$11$CK6twagYBBYdDq/T3Nxzv.7uuhLm5MnmteqY/jI6P3HwRXWweWz7i', 'BreitwiesenstraÃŸe 20-22', (SELECT OrtId FROM Ort WHERE PLZ = 70565), 3);
INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid, Typ) VALUES ('Nico', 'Flister', 'nico.flister@web.de', '$2y$11$CK6twagYBBYdDq/T3Nxzv.P6rGYOhuv0ITgBqOlxkSpSRZU1XBiqO', 'Hebelstraße 1', (SELECT OrtId FROM Ort WHERE PLZ = 71131),0);
INSERT INTO Benutzer (Vorname, Nachname, Email, Passwort, Adresse, Ortid, Typ) VALUES ('Binyam', 'Tefera', 'binyam@tefera.de', '$2y$11$CK6twagYBBYdDq/T3Nxzv.7uuhLm5MnmteqY/jI6P3HwRXWweWz7i', 'BreitwiesenstraÃŸe 20-22', (SELECT OrtId FROM Ort WHERE PLZ = 70439), 0);
