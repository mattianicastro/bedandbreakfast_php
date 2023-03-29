-- Consegna

CREATE TABLE clienti (
    codice VARCHAR(6),
    cognome VARCHAR(20) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    indirizzo VARCHAR(60),
    telefono VARCHAR(15),
    email VARCHAR(30),
    PRIMARY KEY (codice)
);

CREATE TABLE camere(
    numero INTEGER,
    descrizione VARCHAR(100),
    posti INTEGER NOT NULL,
    PRIMARY KEY(numero)
);

CREATE TABLE prenotazioni(
    id INTEGER,
    cliente VARCHAR(6),
    camera INTEGER,
    dataArrivo DATE,
    dataPartenza DATE,
    disdetta BIT DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente) REFERENCES clienti(codice),
    FOREIGN KEY(camera) REFERENCES camere(numero)
);

CREATE TABLE soggiorni(
    prenotazione INTEGER,
    cliente VARCHAR(6),
    documento VARCHAR(60),
    PRIMARY KEY(prenotazione, cliente),
    FOREIGN KEY(cliente) REFERENCES clienti(codice),
    FOREIGN KEY(prenotazione) REFERENCES prenotazioni(id)
)

---

CREATE TABLE utenti(
    username VARCHAR(20),
    password VARCHAR(60),
    tipo_utente ENUM('admin', 'user'),
    id_cliente VARCHAR(6),
    FOREIGN KEY(id_cliente) REFERENCES clienti(codice),
    PRIMARY KEY(username)
);