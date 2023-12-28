
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
('Anderson', 'Christopher', 'M'),
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
('Santos', 'Sophia', 'F');

INSERT INTO Medecin (Id_Personne) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
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
(36);

-- Inserting new Users
INSERT INTO Usager (N_securite_sociale, Adresse, Date_naissance, Lieu_naissance, Id_Personne, Id_Medecin)
VALUES
('1234567890125', '123 Birch St', '1993-04-05', 'City16', 16, 13),
('9876543210989', '456 Cedar St', '1984-09-12', 'City17', 17, 13),
('1111222233336', '789 Elm St', '1994-02-28', 'City18', 38, 1),
('4444555566669', '101 Maple St', '1981-06-15', 'City19', 39, 2),
('7777888899992', '202 Oak St', '1997-10-20', 'City20', 40, NULL);

-- Inserting Future Appointments for new Users
INSERT INTO Rdv (Id_Usager, Id_Medecin, Date_rdv, Heure_debut, Heure_fin)
VALUES
(1, 1, '2024-01-20', '11:30:00', '12:30:00'),
(3, 2, '2024-02-25', '15:00:00', '16:00:00'),
(4, 36, '2024-03-30', '12:30:00', '13:30:00'),
(5, 35, '2023-05-05', '10:45:00', '11:45:00');