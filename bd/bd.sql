DROP TABLE IF EXISTS Acteur, Categorie, Film, Role, Format, Video, Utilisateur, Telecharge, Serie, Episode;

CREATE TABLE Acteur(
  id Serial NOT NULL, 
  nom Varchar(40) NOT NULL,
  prenom Varchar(40) NOT NULL,
  date_naissance Date NOT NULL,
  CONSTRAINT pk_acteur PRIMARY KEY(id)
);

CREATE TABLE Categorie(
  id Serial NOT NULL, 
  libelle Varchar(20) NOT NULL,
  description Text,
  CONSTRAINT pk_categorie PRIMARY KEY(id)
);

CREATE TABLE Film(
  id Serial NOT NULL, 
  titre Varchar(40) NOT NULL,
  resume Text,
  date_sortie Date,
  duree Integer,
  categorie Integer NOT NULL,
  CONSTRAINT pk_film PRIMARY KEY(id),
  CONSTRAINT fk_categorie FOREIGN KEY(categorie) REFERENCES Categorie(id)
);

CREATE TABLE Role(
  acteur Integer NOT NULL,
  film Integer NOT NULL,
  libelle Varchar(80) NOT NULL,
  CONSTRAINT pk_role PRIMARY KEY(acteur, film, libelle),
  CONSTRAINT fk_acteur FOREIGN KEY(acteur) REFERENCES Acteur(id) ON DELETE CASCADE,
  CONSTRAINT fk_film FOREIGN KEY(film) REFERENCES Film(id) ON DELETE CASCADE
);

CREATE TABLE Format(
  id Serial NOT NULL, 
  libelle Varchar(10) NOT NULL,
  CONSTRAINT pk_format PRIMARY KEY(id)
);

CREATE TABLE Video(
  id Serial NOT NULL, 
  url Text NOT NULL,
  type Varchar(15) NOT NULL,
  film Integer NOT NULL,
  format Integer NOT NULL,
  CONSTRAINT pk_video PRIMARY KEY(id),
  CONSTRAINT fk_format FOREIGN KEY(format) REFERENCES Format(id) ON DELETE CASCADE,
  CONSTRAINT fk_film FOREIGN KEY(film) REFERENCES Film(id) ON DELETE CASCADE
);

CREATE TABLE Utilisateur(
  id Serial NOT NULL, 
  nom Varchar(40) NOT NULL,
  prenom Varchar(40) NOT NULL,
  mail Text NOT NULL,
  login Varchar(40) NOT NULL,
  mdp Varchar(20) NOT NULL,
  role Varchar(10) NOT NULL,
  abonne Varchar(3) NOT NULL,
  CONSTRAINT pk_utilisateur PRIMARY KEY(id)
);

CREATE TABLE Telecharge(
  utilisateur Integer NOT NULL,
  video Integer NOT NULL,
  date Timestamp NOT NULL,
  CONSTRAINT pk_telecharge PRIMARY KEY(utilisateur, video, date),
  CONSTRAINT fk_utilisateur FOREIGN KEY(utilisateur) REFERENCES Utilisateur(id) ON DELETE CASCADE,
  CONSTRAINT fk_video FOREIGN KEY(video) REFERENCES Video(id) ON DELETE CASCADE
);

CREATE TABLE Serie(
  id Serial NOT NULL, 
  titre Varchar(40) NOT NULL,
  resume Text,
  date_sortie Date,
  nb_episodes Integer,
  CONSTRAINT pk_serie PRIMARY KEY(id)
);

CREATE TABLE Episode(
  serie Integer NOT NULL,
  film Integer NOT NULL,
  numero Integer NOT NULL,
  CONSTRAINT pk_episode PRIMARY KEY(serie, film),
  CONSTRAINT fk_serie FOREIGN KEY(serie) REFERENCES Serie(id) ON DELETE CASCADE,
  CONSTRAINT fk_film FOREIGN KEY(film) REFERENCES Film(id) ON DELETE CASCADE
);

INSERT INTO Utilisateur VALUES(DEFAULT, 'Bruggeman', 'Marie', 'marie.bruggeman@email.com', 'mbruggeman', 'ProjetBD2020', 'moderateur', 'oui');
INSERT INTO Utilisateur VALUES(DEFAULT, 'User', 'Username', 'user.username@email.com', 'user', 'ProjetBD2020', 'moderateur', 'oui');

INSERT INTO Format VALUES(DEFAULT, 'DivX');
INSERT INTO Format VALUES(DEFAULT, 'Xvid');
INSERT INTO Format VALUES(DEFAULT, 'mp4');
INSERT INTO Format VALUES(DEFAULT, 'avi');

INSERT INTO Acteur VALUES(DEFAULT, 'DiCaprio', 'Leonardo', '1974-11-11');
INSERT INTO Acteur VALUES(DEFAULT, 'Clarke', 'Emilia', '1986-10-23');

INSERT INTO Categorie VALUES(DEFAULT, 'Romance', 'Film portant sur une histoire d''amour ou d''aventure amoureuse, mettant en avant la passion, les ??motions et l''engagement affectif des personnages principaux.');
INSERT INTO Categorie VALUES(DEFAULT, 'Fantasy', 'Genre litt??raire pr??sentant un ou plusieurs ??l??ments surnaturels qui rel??vent souvent du mythe et qui sont souvent incarn??s par l''irruption ou l''utilisation de la magie.');

INSERT INTO Film VALUES(DEFAULT, 'Titanic', 'Titanic est un film catastrophe ??pique am??ricain ??crit, produit et r??alis?? par James Cameron, sorti en 1997. Int??grant ?? la fois des aspects historiques et fictionnels, le film est bas?? sur le r??cit du naufrage du RMS Titanic et met en vedette Leonardo DiCaprio et Kate Winslet.', '1998-01-07', 188, 1);
INSERT INTO Film VALUES(DEFAULT, 'L''hiver vient', 'Sur le continent de Westeros, une unit?? de la Garde de Nuit, charg??e de veiller sur le Mur, est presque enti??rement massacr??e lors d''une patrouille au nord du Mur. Un jeune patrouilleur r??ussit ?? s''enfuir, mais il est arr??t?? et condamn?? ?? mort pour d??sertion par Eddard Stark, seigneur de Winterfell et gouverneur du Nord.', '2011-04-17', 52, 2);

INSERT INTO Serie VALUES(DEFAULT, 'Game of Thrones', 'Game of Thrones, ??galement appel??e Le Tr??ne de fer selon le titre fran??ais de l''oeuvre romanesque dont elle est adapt??e, est une s??rie t??l??vis??e am??ricaine de Fantasy cr????e par David Benioff et D. B. Weiss, diffus??e entre le 17 avril 2011 et le 19 mai 2019 sur HBO aux ??tats-Unis en simultan?? sur HBO Canada au Canada.', '2011-04-17', 73);

INSERT INTO Episode VALUES(1, 2, 1);

INSERT INTO Role VALUES(1, 1, 'Jack Dawson');
INSERT INTO Role VALUES(2, 2, 'Daenerys Targaryen');

INSERT INTO Video VALUES(DEFAULT, 'https://www.titanic.com/mp4', 'film', 1, 3);
INSERT INTO Video VALUES(DEFAULT, 'https://www.got.com/avi', 'film', 2, 4);

INSERT INTO Telecharge VALUES(1, 2, CURRENT_TIMESTAMP(2));