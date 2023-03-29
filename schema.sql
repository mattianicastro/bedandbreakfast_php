-- Consegna

CREATE TABLE IF NOT EXISTS clienti (
    codice INTEGER AUTO_INCREMENT,
    cognome VARCHAR(20) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    indirizzo VARCHAR(60),
    telefono VARCHAR(15),
    email VARCHAR(30),
    PRIMARY KEY (codice)
);

CREATE TABLE IF NOT EXISTS camere(
    numero INTEGER,
    descrizione VARCHAR(100),
    posti INTEGER NOT NULL,
    PRIMARY KEY(numero)
);

CREATE TABLE IF NOT EXISTS prenotazioni(
    id INTEGER AUTO_INCREMENT,
    cliente INTEGER,
    camera INTEGER,
    dataArrivo DATE,
    dataPartenza DATE,
    disdetta BIT DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente) REFERENCES clienti(codice) ON DELETE CASCADE,
    FOREIGN KEY(camera) REFERENCES camere(numero) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS soggiorni(
    prenotazione INTEGER,
    cliente INTEGER,
    documento VARCHAR(60),
    PRIMARY KEY(prenotazione, cliente),
    FOREIGN KEY(cliente) REFERENCES clienti(codice) ON DELETE CASCADE,
    FOREIGN KEY(prenotazione) REFERENCES prenotazioni(id) ON DELETE CASCADE
);

-- -

CREATE TABLE IF NOT EXISTS utenti(
    username VARCHAR(20),
    password VARCHAR(60),
    tipo_utente ENUM('admin', 'user'),
    id_cliente INTEGER,
    FOREIGN KEY(id_cliente) REFERENCES clienti(codice) ON DELETE CASCADE, 
    PRIMARY KEY(username) 
);