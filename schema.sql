-- Consegna

CREATE TABLE IF NOT EXISTS clienti (
    codice INTEGER AUTO_INCREMENT,
    cognome VARCHAR(20) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    indirizzo VARCHAR(60) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    email VARCHAR(30),
    PRIMARY KEY (codice)
);

CREATE TABLE IF NOT EXISTS camere(
    numero INTEGER,
    descrizione VARCHAR(100) NOT NULL,
    posti INTEGER NOT NULL,
    foto TEXT,
    PRIMARY KEY(numero)
);

CREATE TABLE IF NOT EXISTS prenotazioni(
    id INTEGER AUTO_INCREMENT,
    cliente INTEGER NOT NULL,
    camera INTEGER NOT NULL,
    dataArrivo DATE NOT NULL,
    dataPartenza DATE NOT NULL,
    disdetta BIT DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente) REFERENCES clienti(codice) ON DELETE CASCADE,
    FOREIGN KEY(camera) REFERENCES camere(numero) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS soggiorni(
    prenotazione INTEGER,
    cliente INTEGER NOT NULL,
    documento VARCHAR(60),
    PRIMARY KEY(prenotazione, cliente),
    FOREIGN KEY(cliente) REFERENCES clienti(codice) ON DELETE CASCADE,
    FOREIGN KEY(prenotazione) REFERENCES prenotazioni(id) ON DELETE CASCADE
);

-- -

CREATE TABLE IF NOT EXISTS utenti(
    username VARCHAR(20) NOT NULL,
    password VARCHAR(60) NOT NULL,
    tipo_utente ENUM('admin', 'user') NOT NULL,
    id_cliente INTEGER,
    FOREIGN KEY(id_cliente) REFERENCES clienti(codice) ON DELETE CASCADE, 
    PRIMARY KEY(username) 
);