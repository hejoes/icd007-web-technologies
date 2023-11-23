CREATE TABLE developer (id INTEGER PRIMARY KEY, name VARCHAR(255));
CREATE TABLE ticket (id INTEGER PRIMARY KEY, developer_id INTEGER, text VARCHAR(255));

INSERT INTO developer VALUES (1, 'Alice');
INSERT INTO ticket VALUES (1, 1, 'Ticket 1');
INSERT INTO ticket VALUES (3, 1, 'Ticket 3');
INSERT INTO ticket VALUES (4, 1, 'Ticket 4');

INSERT INTO developer VALUES (2, 'Bob');
INSERT INTO ticket VALUES (2, 2, 'Ticket 2');

INSERT INTO developer VALUES (3, 'Carol');

INSERT INTO developer VALUES (4, 'David');
INSERT INTO ticket VALUES (5, 4, 'Ticket 5');
