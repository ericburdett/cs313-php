DROP TABLE conferences;
DROP TABLE speakers;
DROP TABLE notes;
DROP TABLE users;


CREATE TABLE conferences (
    id INT CONSTRAINT conferences_pk PRIMARY KEY,
    year INT CONSTRAINT conferences_nn1 NOT NULL,
    a_sa BOOLEAN CONSTRAINT conferences_nn2 NOT NULL
);

CREATE TABLE speakers (
    id INT CONSTRAINT speakers_pk PRIMARY KEY,
    name VARCHAR(250) CONSTRAINT speakers_nn1 NOT NULL
);

CREATE TABLE users (
    id INT CONSTRAINT users_pk PRIMARY KEY,
    name VARCHAR(250) CONSTRAINT users_nn1 NOT NULL
);

CREATE TABLE sessions (
    id INT CONSTRAINT sessions_pk PRIMARY KEY,
    conference_id INT CONSTRAINT sessions_fk1 REFERENCES conferences(id),
    type VARCHAR(50) CONSTRAINT sessions_nn1 NOT NULL
);

CREATE TABLE notes (
    id INT CONSTRAINT notes_pk PRIMARY KEY,
    session_id INT    CONSTRAINT notes_fk1 REFERENCES sessions(id),
    speaker_id INT    CONSTRAINT notes_fk2 REFERENCES speakers(id),
    user_id INT CONSTRAINT notes_fk3 REFERENCES users(id),
    note TEXT CONSTRAINT notes_nn1 NOT NULL
);

