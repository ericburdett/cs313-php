CREATE TABLE topics
(
    id SERIAL CONSTRAINT topics_pk PRIMARY KEY,
    name VARCHAR(250) CONSTRAINT topics_nn1 NOT NULL,
    CONSTRAINT topics_un1 UNIQUE (name)
);

INSERT INTO topics VALUES
(
    DEFAULT,
    'Faith'
),

(
    DEFAULT,
    'Sacrifice'
),

(
    DEFAULT,
    'Charity'
);


CREATE TABLE scriptures_topics
(
    id SERIAL CONSTRAINT scriptures_topics_pk PRIMARY KEY,
    scriptures_id INT CONSTRAINT scriptures_topics_nn1 NOT NULL,
    topics_id INT CONSTRAINT scriptures_topics_nn2 NOT NULL,
    CONSTRAINT scriptures_topics_fk1 FOREIGN KEY (scriptures_id) REFERENCES scriptures(id),
    CONSTRAINT scriptures_topics_fk2 FOREIGN KEY (topics_id) REFERENCES topics(id)
);


INSERT INTO scriptures_topics VALUES
(
    DEFAULT,
    ,
    (SELECT id FROM topics WHERE name = 'Faith')
)