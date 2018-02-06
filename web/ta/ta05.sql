\c ta05

CREATE TABLE scriptures (
    id SERIAL CONSTRAINT scriptures_pk PRIMARY KEY,
    book VARCHAR(150),
    chapter VARCHAR(150),
    verse VARCHAR(50),
    content VARCHAR(8000)
);

INSERT INTO scriptures VALUES
(
    DEFAULT,
    'John',
    '1',
    '5',
    'And the light shineth in darkness; and the darkness comprehended it not.'
);

INSERT INTO scriptures VALUES
(
    DEFAULT,
    'Doctrine & Covenants',
    '88',
    '49',
    'The light shineth in darkness, and the darkness comprehendeth it not; nevertheless, the day shall come when you shall comprehend even God, being quickened in him and by him.'
);

INSERT INTO scriptures VALUES
(
    DEFAULT,
    'Doctrine & Covenants',
    '93',
    '28',
    'He that keepeth his commandments receiveth truth and light, until he is glorified in truth and knoweth all things.'
);

INSERT INTO scriptures VALUES
(
    DEFAULT,
    'Mosiah',
    '16',
    '9',
    'He is the light and the life of the world; yea, a light that is endless, that can never be darkened; yea, and also a life which is endless, that there can be no more death.'
);
