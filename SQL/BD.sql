
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
('1111222233336', '789 Elm St', '1904-02-28', 'City18', 38, 1),
('4444555566669', '101 Maple St', '2020-06-15', 'City19', 39, 2),
('7777888899992', '202 Oak St', '1997-10-20', 'City20', 40, NULL),
('1212121212148', '303 Pine St', '1990-12-25', 'City21', 1, 10),
('3434343434321', '404 Spruce St', '1992-08-30', 'City22', 2, 1),
('5656565656544', '505 Walnut St', '1995-03-05', 'City23', 3, 1),
('7878787878187', '606 Ash St', '1989-07-10', 'City24', 4, 1),
('9090909090100', '707 Beech St', '1991-01-15', 'City25', 5, 1),
('2323232323137', '808 Cedar St', '1996-05-20', 'City26', 6, 1),
('4545454545150', '909 Elm St', '1988-11-25', 'City27', 7, 1),
('6767676717673', '1011 Maple St', '1993-04-01', 'City28', 8, 1),
('8989818989896', '1112 Oak St', '1962-09-06', 'City29', 9, 1),
('0101010111011', '1213 Pine St', '1985-02-15', 'City30', 10, 11),
('1212121212138', '1314 Spruce St', '1977-07-20', 'City31', 11, 12),
('2323232321237', '1415 Walnut St', '1980-12-25', 'City32', 12, 13),
('3434343434331', '1516 Ash St', '1969-09-30', 'City33', 13, 14),
('4545454545450', '1617 Beech St', '1975-03-05', 'City34', 14, 15),
('5656565656534', '1718 Cedar St', '1982-08-10', 'City35', 15, 16),
('6767676767673', '1819 Elm St', '1970-01-15', 'City36', 16, 17),
('7878387878787', '1920 Maple St', '1988-05-20', 'City37', 17, 18),
('8989898989896', '2021 Oak St', '1965-11-25', 'City38', 18, 19),
('0101010101011', '2122 Pine St', '1972-04-01', 'City39', 19, 20),
('1212121212128', '2223 Spruce St', '1960-09-06', 'City40', 20, 21),
('2323232323237', '2324 Walnut St', '1967-02-15', 'City16', 21, 22),
('3434343434341', '2425 Ash St', '1983-07-20', 'City17', 22, 23),
('5656565656564', '2526 Beech St', '1979-12-25', 'City18', 23, 24),
('7878787878787', '2627 Cedar St', '1987-09-30', 'City19', 24, 25),
('9090909090900', '2728 Elm St', '1974-03-05', 'City20', 25, 26);

UPDATE Personne
SET Civilite = 'A'
WHERE Id_Personne = 3;

INSERT INTO Rdv (Id_Usager, Id_Medecin, Date_rdv, Heure_debut, Heure_fin)
VALUES
(1, 1, '2024-01-20', '11:30', '12:30'),
(2, 1, '2024-02-25', '15:00', '16:00'),
(3, 1, '2024-03-30', '12:30', '13:30'),
(3, 1, '2024-02-25', '16:00', '17:00'),
(5, 1, '2024-05-05', '10:45', '11:45'),
(6, 34, '2024-06-10', '14:15', '15:15'),
(7, 33, '2024-07-15', '11:30', '12:30'),
(8, 32, '2024-08-20', '15:00', '16:00'),
(9, 31, '2024-09-25', '12:30', '13:00'),
(10, 30, '2024-10-30', '10:45', '11:45'),
(11, 29, '2024-12-05', '14:15', '15:15'),
(12, 28, '2025-01-10', '11:30', '12:30'),
(13, 27, '2025-02-15', '15:00', '16:00'),
(14, 26, '2025-03-20', '12:30', '13:30'),
(2, 1,'2023-01-20', '11:30', '12:30'),
(2, 1,'2023-02-25', '15:00', '16:00'),
(2, 1,'2023-03-30', '12:30', '13:30'),
(2, 1,'2023-04-25', '16:00', '16:00'),
(2, 1,'2023-05-05', '10:45', '11:45'),
(2, 1,'2023-06-10', '14:15', '15:15'),
(3, 2,'2023-07-15', '11:30', '12:30'),
(2, 3,'2023-08-20', '15:00', '16:00'),
(2, 4,'2023-09-25', '12:30', '13:00'),
(2, 5,'2023-10-30', '10:45', '11:45'),
(2, 5,'2023-12-05', '14:15', '15:15'),
(2, 4,'2022-01-10', '11:30', '12:30'),
(3, 1,'2022-02-15', '15:00', '16:00'),
(5, 1,'2022-03-20', '12:30', '13:30'),
(6, 6,'2022-04-25', '16:00', '16:00'),
(2, 6,'2022-05-05', '10:45', '11:45'),
(2, 6,'2022-06-10', '14:15', '15:15'),
(2, 6,'2022-07-15', '11:30', '12:30'),
(2, 6,'2022-08-20', '15:00', '22:00'),
(2, 1,'2022-09-25', '12:30', '13:00'),
(2, 1,'2022-10-30', '10:45', '11:45'),
(2, 1,'2022-12-05', '14:15', '15:15'),
(14, 2, '2024-01-20', '11:30', '12:30'),
(14, 2, '2024-02-25', '15:00', '16:00'),
(14, 2, '2024-03-30', '12:30', '13:30'),
(14, 2, '2024-04-25', '16:00', '16:00'),
(14, 2, '2024-05-05', '10:45', '11:45'),
(14, 2, '2024-06-10', '14:15', '15:15'),
(14, 2, '2024-07-15', '11:30', '12:30'),
(14, 2, '2024-08-20', '15:00', '16:00'),
(14, 2, '2024-09-25', '12:30', '13:00'),
(14, 2, '2024-10-30', '10:45', '11:45'),
(14, 2, '2024-12-05', '14:15', '15:15'),
(14, 2, '2025-01-10', '11:30', '12:30'),
(14, 2, '2025-02-15', '15:00', '16:00'),
(14, 2, '2025-03-20', '12:30', '13:30'),
(14, 2, '2025-04-25', '16:00', '16:00'),
(14, 2, '2025-05-05', '10:45', '11:45'),
(14, 2, '2025-06-10', '14:15', '15:15'),
(14, 2, '2025-07-15', '11:30', '12:30'),
(14, 2, '2025-08-20', '15:00', '16:00'),
(14, 2, '2025-09-25', '12:30', '13:00'),
(14, 2, '2025-10-30', '10:45', '11:45');

-- Début de la transaction
START TRANSACTION;

-- Mise à jour des dates des rendez-vous
UPDATE Rdv
SET Date_rdv = CASE
    WHEN DAYOFWEEK(Date_rdv) = 1 THEN DATE_ADD(Date_rdv, INTERVAL 1 DAY) -- Si c'est un dimanche, décaler vers le lundi
    WHEN DAYOFWEEK(Date_rdv) = 7 THEN DATE_ADD(Date_rdv, INTERVAL 2 DAY) -- Si c'est un samedi, décaler vers le lundi
    ELSE Date_rdv
END;

-- Validation de la transaction
COMMIT;