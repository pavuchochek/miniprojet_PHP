CREATE TABLE Personne(
   Id_Personne INT(11) AUTO_INCREMENT NOT NULL,
   Nom VARCHAR(50),
   Prénom VARCHAR(50),
   Civilité CHAR(1),
   PRIMARY KEY(Id_Personne)
);

CREATE TABLE Médecin(
   Id_Médecin INT(11) AUTO_INCREMENT NOT NULL,
   Id_Personne INT NOT NULL,
   PRIMARY KEY(Id_Médecin),
   FOREIGN KEY(Id_Personne) REFERENCES Personne(Id_Personne)
);

CREATE TABLE Usager(
   Id_Usager INT(11) AUTO_INCREMENT NOT NULL,
   N_sécurité_sociale CHAR(13) NOT NULL,
   Adresse VARCHAR(200),
   Date_naissance DATE,
   Lieu_naissance VARCHAR(50),
   Id_Personne INT NOT NULL,
   Id_Médecin INT,
   PRIMARY KEY(Id_Usager),
   UNIQUE(N_sécurité_sociale),
   FOREIGN KEY(Id_Personne) REFERENCES Personne(Id_Personne),
   FOREIGN KEY(Id_Médecin) REFERENCES Médecin(Id_Médecin)
);

CREATE TABLE Rdv(
   Id_Usager INT NOT NULL,
   Id_Médecin INT NOT NULL,
   Date_rdv DATE,
   Heure_début TIME,
   Heure_fin TIME,
   PRIMARY KEY(Id_Usager, Id_Médecin),
   FOREIGN KEY(Id_Usager) REFERENCES Usager(Id_Usager),
   FOREIGN KEY(Id_Médecin) REFERENCES Médecin(Id_Médecin)
);
