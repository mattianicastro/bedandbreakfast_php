-- Consegna

INSERT INTO `clienti`(`Codice`, `Cognome`, `Nome`, `Indirizzo`, `Telefono`, `Email`) VALUES ("1", "Bottari", "Barbara", "Via Moretto 13", "123123123", "barbara@bottari.it");

INSERT INTO `clienti`(`Codice`, `Cognome`, `Nome`, `Indirizzo`, `Telefono`, `Email`) VALUES ("2", "Tobia", "Donato", "Via del Risorgimento 12", "111222333", "tobia@donato.it");

INSERT INTO `clienti`(`Codice`, `Cognome`, `Nome`, `Indirizzo`, `Telefono`, `Email`) VALUES ("3", "Baudo", "Giuseppe", "Via del Mare 77", "6767676767", "pippo@baudo.it");

INSERT INTO `camere`(`Numero`, `Descrizione`, `Posti`) VALUES (1, "Ciclamini", 3), (2, "Rose", 2), (3, "Girasoli", 4), (4, "Peonie", 2);

INSERT INTO `prenotazioni`(`id`, `Cliente`, `Camera`, `DataArrivo`, `DataPartenza`, `Disdetta`) VALUES (1, "1", 1, "2021-07-15", "2021-07-31",0), (2, "2", 2, "2021-07-01","2021-07-31",0), (3, "3", 3, "2021-06-25", "2021-07-25",0), (4, "1", 1, "2021-12-01", "2021-12-31",0);

INSERT INTO `soggiorni`(`Prenotazione`, `Cliente`, `Documento`) VALUES (1, 1, "CI"), (2,2, "Patente"), (3, 1, "CI"), (4, 3, "Passaporto");

INSERT INTO utenti VALUES ('giuseppebaudo', '$2y$10$8mgTpcmkgpyxt1YUWoxQgubhSGm7fTPI829nstRJJ7wzzZvpEG7Ty', 'user', '3');

INSERT INTO `utenti`(`username`, `password`, `tipo_utente`) VALUES ('admin', '$2y$10$6ONxCbNjpLG4GR8pLvDzAuUmPJwjloL2enFSAZdVczjNeXrqQHzV2', 'admin');