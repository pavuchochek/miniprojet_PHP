
-- Création des tables
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
   Date_rdv DATE NOT NULL,
   Heure_debut TIME NOT NULL,
   Heure_fin TIME NOT NULL,
   PRIMARY KEY(Id_Usager, Id_Medecin,Date_rdv,Heure_debut,Heure_fin),
   FOREIGN KEY(Id_Usager) REFERENCES Usager(Id_Usager),
   FOREIGN KEY(Id_Medecin) REFERENCES Medecin(Id_Medecin)
);
commit;


-- Insertion de données test
INSERT INTO Personne (Nom, Prenom, Civilite) VALUES
('Doe', 'John', 'A'),
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
('Sanchez', 'Sofia', 'A'),
('Ramirez', 'Diego', 'M'),
('Torres', 'Isabella', 'A'),
('Flores', 'Miguel', 'A'),
('Rivera', 'Valentina', 'F'),
('Gomez', 'Alejandro', 'M'),
('Reyes', 'Camila', 'F'),
('Morales', 'Gabriel', 'M'),
('Ortiz', 'Lucia', 'F'),
('Vargas', 'Daniel', 'M'),
('Castillo', 'Emma', 'F'),
('Jimenez', 'Adrian', 'A'),
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

INSERT INTO Usager (N_securite_sociale, Adresse, Date_naissance, Lieu_naissance, Id_Personne, Id_Medecin)
VALUES
('1234567890125', '123 Birch St', '1993-04-05', 'City16', 16, 13),
('9876543210989', '456 Cedar St', '1984-09-12', 'City17', 17, 13),
('1111222233336', '789 Elm St', '1994-02-28', 'City18', 38, 1),
('4444555566669', '101 Maple St', '1981-06-15', 'City19', 39, 2),
('7777888899992', '202 Oak St', '1997-10-20', 'City20', 40, NULL),
('1212121212128', '303 Pine St', '1990-12-25', 'City21', 1, 10),
('3434343434341', '404 Spruce St', '1992-08-30', 'City22', 2, 11),
('5656565656564', '505 Walnut St', '1995-03-05', 'City23', 3, 12),
('7878787878787', '606 Ash St', '1989-07-10', 'City24', 4, 13),
('9090909090900', '707 Beech St', '1991-01-15', 'City25', 5, 14),
('2323232323237', '808 Cedar St', '1996-05-20', 'City26', 6, 15),
('4545454545450', '909 Elm St', '1988-11-25', 'City27', 7, 16),
('6767676767673', '1011 Maple St', '1993-04-01', 'City28', 8, 17),
('8989898989896', '1112 Oak St', '1994-09-06', 'City29', 9, 18);

INSERT INTO Rdv (Id_Usager, Id_Medecin, Date_rdv, Heure_debut, Heure_fin)
VALUES
(1, 1, '2024-01-20', '11:30:00', '12:30:00'),
(3, 2, '2024-02-25', '15:00:00', '16:00:00'),
(4, 36, '2024-03-30', '12:30:00', '13:30:00'),
(5, 35, '2024-05-05', '10:45:00', '11:45:00'),
(6, 34, '2024-06-10', '14:15:00', '15:15:00'),
(7, 33, '2024-07-15', '11:30:00', '12:30:00'),
(8, 32, '2024-08-20', '15:00:00', '16:00:00'),
(9, 31, '2024-09-25', '12:30:00', '13:30:00'),
(10, 30, '2024-10-30', '10:45:00', '11:45:00'),
(11, 29, '2024-12-05', '14:15:00', '15:15:00'),
(12, 28, '2025-01-10', '11:30:00', '12:30:00'),
(13, 27, '2025-02-15', '15:00:00', '16:00:00'),
(14, 26, '2025-03-20', '12:30:00', '13:30:00');