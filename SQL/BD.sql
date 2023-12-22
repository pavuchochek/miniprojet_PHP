
CREATE OR REPLACE TABLE Personne(
   Id_Personne INT(11) AUTO_INCREMENT NOT NULL,
   Nom VARCHAR(50),
   Prenom VARCHAR(50),
   Civilite CHAR(1),
   PRIMARY KEY(Id_Personne)
);

CREATE OR REPLACE TABLE Medecin(
   Id_Medecin INT(11) AUTO_INCREMENT NOT NULL,
   Id_Personne INT NOT NULL,
   PRIMARY KEY(Id_Medecin),
   FOREIGN KEY(Id_Personne) REFERENCES Personne(Id_Personne)
);

CREATE OR REPLACE TABLE Usager(
   Id_Usager INT(11) AUTO_INCREMENT NOT NULL,
   N_securite_sociale CHAR(13) NOT NULL,
   Adresse VARCHAR(200),
   Date_naissance DATE,
   Lieu_naissance VARCHAR(50),
   Id_Personne INT NOT NULL,
   Id_Medecin INT,
   PRIMARY KEY(Id_Usager),
   UNIQUE(N_securite_sociale),
   FOREIGN KEY(Id_Personne) REFERENCES Personne(Id_Personne),
   FOREIGN KEY(Id_Medecin) REFERENCES Medecin(Id_Medecin)
);

CREATE OR REPLACE TABLE Rdv(
   Id_Usager INT NOT NULL,
   Id_Medecin INT NOT NULL,
   Date_rdv DATE,
   Heure_debut TIME,
   Heure_fin TIME,
   PRIMARY KEY(Id_Usager, Id_Medecin),
   FOREIGN KEY(Id_Usager) REFERENCES Usager(Id_Usager),
   FOREIGN KEY(Id_Medecin) REFERENCES Medecin(Id_Medecin)
);
commit;
INSERT INTO Personne (Nom, Prenom, Civilite) VALUES
('Doe', 'John', 'M'),
('Smith', 'Jane', 'F'),
('Johnson', 'Michael', 'M'),
('Williams', 'Emily', 'F'),
('Brown', 'David', 'M'),
('Jones', 'Sarah', 'F'),
('Miller', 'Robert', 'M'),
('Davis', 'Jennifer', 'F'),
('Wilson', 'Daniel', 'M'),
('Taylor', 'Jessica', 'F'),
('Anderson', 'Christopher', 'M');

INSERT INTO Medecin (Id_Personne) VALUES
(4),
(5),
(6),
(7),
(8),
(9),
(10);

INSERT INTO Personne (Nom, Prenom, Civilite)
VALUES
('Lee', 'Michelle', 'F'),
('Garcia', 'Carlos', 'M'),
('Lopez', 'Maria', 'F'),
('Martinez', 'Juan', 'M'),
('Hernandez', 'Ana', 'F'),
('Gonzalez', 'Pedro', 'M'),
('Rodriguez', 'Laura', 'F'),
('Perez', 'Luis', 'M'),
('Sanchez', 'Sofia', 'F'),
('Ramirez', 'Diego', 'M'),
('Torres', 'Isabella', 'F'),
('Flores', 'Miguel', 'M'),
('Rivera', 'Valentina', 'F'),
('Gomez', 'Alejandro', 'M'),
('Reyes', 'Camila', 'F'),
('Morales', 'Gabriel', 'M'),
('Ortiz', 'Lucia', 'F'),
('Vargas', 'Daniel', 'M'),
('Castillo', 'Emma', 'F'),
('Jimenez', 'Adrian', 'M'),
('Moreno', 'Julia', 'F'),
('Romero', 'David', 'M'),
('Alvarez', 'Sara', 'F'),
('Ramos', 'Samuel', 'M'),
('Gutierrez', 'Victoria', 'F'),
('Chavez', 'Alex', 'M'),
('Mendoza', 'Elena', 'F'),
('Ruiz', 'Max', 'M'),
('Santos', 'Sophia', 'F'),
('Valdez', 'Leo', 'M');


INSERT INTO Medecin (Id_Personne)
VALUES
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40);

