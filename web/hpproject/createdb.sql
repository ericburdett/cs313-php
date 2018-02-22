--------------------------------------------------------------
-- CREATEDB.SQL
-- Create all tables and enum types for database for PHP
-- project.
--
-- Eric Burdett
-- CS313
--------------------------------------------------------------

-- hp is the database we should be connected to
-- Uncomment if on local machine...
-- \c hp

-- Drop all enums and tables in case the database has
-- been built previously. This will make it much easier
-- to correct mistakes.
DROP TABLE customer CASCADE;
DROP TABLE location CASCADE;
DROP TABLE customer_location CASCADE;
DROP TABLE customer_contact CASCADE;
DROP TABLE employee CASCADE;
DROP TABLE customer_employee CASCADE;
DROP TABLE printer CASCADE;
DROP TABLE scanner CASCADE;
DROP TABLE customer_printer CASCADE;
DROP TABLE customer_scanner CASCADE;
DROP TABLE solution CASCADE;
DROP TABLE customer_solution CASCADE;

DROP TYPE customerType CASCADE;
DROP TYPE yn CASCADE;
DROP TYPE employeeType CASCADE;
DROP TYPE regions CASCADE;
DROP TYPE deviceClass CASCADE;
DROP TYPE firmwareType CASCADE;
DROP TYPE solutionType CASCADE;

-- Custom enum types
CREATE TYPE customerType AS ENUM ('Direct','Transactional', 'Partner','dMPS','pMPS','cMPS');
CREATE TYPE yn AS ENUM ('Yes', 'No');
CREATE TYPE employeeType AS ENUM ('AM','TC','ISR');
CREATE TYPE regions AS ENUM ('North', 'South', 'East', 'West');
CREATE TYPE deviceClass AS ENUM ('Enterprise','Professional');
CREATE TYPE firmwareType AS ENUM ('Oz', 'Jedi');
CREATE TYPE solutionType AS ENUM ('Security', 'Digital Send Solutions', 'Management','Driver');

CREATE TABLE customer (
    id SERIAL CONSTRAINT customer_pk PRIMARY KEY,
    name VARCHAR(250) CONSTRAINT customer_nn1 NOT NULL,
    phone VARCHAR(50),
    region regions,
    type customerType,
    notes VARCHAR(8000),
    CONSTRAINT customer_un1 UNIQUE(name)
);

CREATE TABLE location (
    id SERIAL CONSTRAINT location_pk PRIMARY KEY,
    address VARCHAR(300),
    city VARCHAR (80),
    state VARCHAR (80),
    zip VARCHAR(80),
    country VARCHAR(250)
);

CREATE TABLE customer_location (
    id SERIAL CONSTRAINT customer_location_pk PRIMARY KEY,
    customer_id INT CONSTRAINT customer_location_nn1 NOT NULL,
    location_id INT CONSTRAINT customer_location_nn2 NOT NULL,
    CONSTRAINT customer_location_fk1 FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT customer_location_fk2 FOREIGN KEY (location_id) REFERENCES location(id),
    CONSTRAINT customer_location_un1 UNIQUE (customer_id,location_id)
);

CREATE TABLE customer_contact (
    id SERIAL CONSTRAINT customer_contact_pk PRIMARY KEY,
    customer_id INT CONSTRAINT customer_contact_nn1 NOT NULL,
    name VARCHAR(250) CONSTRAINT customer_contact_nn2 NOT NULL,
    title VARCHAR(250),
    location_id INT CONSTRAINT customer_contact_fk1 REFERENCES location(id),
    email VARCHAR(250),
    business_phone VARCHAR(50),
    mobile_phone VARCHAR(50),
    main_contact BOOLEAN,
    notes VARCHAR(8000),
    CONSTRAINT customer_contact_fk2 FOREIGN KEY (customer_id) REFERENCES customer(id)
);

CREATE TABLE employee (
    id SERIAL CONSTRAINT employee_pk PRIMARY KEY,
    name VARCHAR(250) CONSTRAINT employee_nn1 NOT NULL,
    email VARCHAR(250) CONSTRAINT employee_nn2 NOT NULL,
    password VARCHAR(250) CONSTRAINT employee_nn3 NOT NULL,
    type employeeType,
    region regions,
    CONSTRAINT employee_un1 UNIQUE(name),
    CONSTRAINT employee_un2 UNIQUE(email)
);

CREATE TABLE customer_employee (
    id SERIAL CONSTRAINT customer_employee_pk PRIMARY KEY,
    customer_id INT CONSTRAINT customer_employee_nn1 NOT NULL,
    employee_id INT CONSTRAINT customer_employee_nn2 NOT NULL, 
    CONSTRAINT customer_employee_fk1 FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT customer_employee_fk2 FOREIGN KEY (employee_id) REFERENCES employee(id),
    CONSTRAINT customer_employee_un1 UNIQUE (customer_id, employee_id)
);

CREATE TABLE scanner (
    id SERIAL CONSTRAINT scanner_pk PRIMARY KEY,
    model_name VARCHAR(250) CONSTRAINT scanner_nn1 NOT NULL,
    device_class deviceClass,
    firmware_type firmwareType,
    flatbed boolean,
    adf boolean,
    sheet_feed boolean,
    CONSTRAINT scanner_un1 UNIQUE(model_name)
);

CREATE TABLE printer (
    id SERIAL CONSTRAINT printer_pk PRIMARY KEY,
    model_name VARCHAR(250) CONSTRAINT printer_nn1 NOT NULL,
    device_class deviceClass,
    firmware_type firmwareType,
    mfp boolean,
    color boolean,
    duplex boolean,
    supports_sm boolean,
    sm_inst_on_cap boolean,
    sure_start boolean,
    whitelisting boolean,
    run_time_int_det boolean,
    connection_inspector boolean,
    is_a4 boolean,
    CONSTRAINT printer_un1 UNIQUE(model_name)
);

CREATE TABLE customer_scanner (
    id SERIAL CONSTRAINT customer_scanner_pk PRIMARY KEY,
    customer_id INT CONSTRAINT customer_scanner_nn1 NOT NULL,
    scanner_id INT CONSTRAINT customer_scanner_nn2 NOT NULL,
    qty_in_fleet INT CONSTRAINT customer_scanner_nn3 NOT NULL,
    fs4 boolean,
    notes VARCHAR(8000),
    CONSTRAINT customer_scanner_fk1 FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT customer_scanner_fk2 FOREIGN KEY (scanner_id) REFERENCES scanner(id)
);

CREATE TABLE customer_printer (
    id SERIAL CONSTRAINT customer_printer_pk PRIMARY KEY,
    customer_id INT CONSTRAINT customer_printer_nn1 NOT NULL,
    printer_id INT CONSTRAINT customer_printer_nn2 NOT NULL,
    qty_in_fleet INT CONSTRAINT customer_printer_nn3 NOT NULL,
    fs4 boolean,
    notes VARCHAR(8000),
    CONSTRAINT customer_printer_fk1 FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT customer_printer_fk2 FOREIGN KEY (printer_id) REFERENCES printer(id)
);

CREATE TABLE solution (
    id SERIAL CONSTRAINT solution_pk PRIMARY KEY,
    name VARCHAR(250) CONSTRAINT solution_nn1 NOT NULL,
    type solutionType,
    CONSTRAINT solution_un1 UNIQUE(name)
);

CREATE TABLE customer_solution (
    id SERIAL CONSTRAINT customer_solution_pk PRIMARY KEY,
    customer_id INT CONSTRAINT customer_solution_nn1 NOT NULL,
    solution_id INT CONSTRAINT customer_solution_nn2 NOT NULL,
    version VARCHAR(250),
    qty_licenses INT,
    notes VARCHAR(8000),
    CONSTRAINT customer_solution_fk1 FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT customer_solution_fk2 FOREIGN KEY (solution_id) REFERENCES solution(id)
);


-- Insert some test data into our database.
INSERT INTO customer VALUES
(
    DEFAULT,
    'BYU-Idaho',
    'XXX-XXX-XXXX',
    'West',
    'Direct',
    'A pretty cool university...'
);

INSERT INTO customer VALUES
(
    DEFAULT,
    'LDS Church',
    'XXX-XXX-XXXX',
    'West',
    'Transactional',
    'A pretty cool church... Actually the true one!'
);

INSERT INTO customer VALUES
(
    DEFAULT,
    'Adidas',
    'XXX-XXX-XXXX',
    'East',
    'dMPS',
    'Sports Sports Sports.'
);

INSERT INTO customer VALUES
(
    DEFAULT,
    'Southerners United',
    'XXX-XXX-XXXX',
    'South',
    'cMPS',
    'Y''all, fixin'', reckon, farsees'
);

INSERT INTO customer VALUES
(
    DEFAULT,
    'Utah Jazz',
    'XXX-XXX-XXXX',
    'West',
    'Direct',
    'Heaven help us!'
);

INSERT INTO location VALUES
(
    DEFAULT,
    '1234 N Viking Drive',
    'Rexburg',
    'Idaho',
    '83440',
    'USA'
);

INSERT INTO location VALUES
(
    DEFAULT,
    '1234 S Temple',
    'Salt Lake City',
    'Utah',
    '84044',
    'USA'
);

INSERT INTO location VALUES
(
    DEFAULT,
    '1234 Germ',
    'Herzogenaurach',
    NULL,
    NULL,
    'Germany'
);

INSERT INTO location VALUES
(
    DEFAULT,
    '1234 Farsee Lane',
    'Denton',
    'Texas',
    '75065',
    'USA'
);

INSERT INTO location VALUES
(
    DEFAULT,
    '1234 John Stockton Drive',
    'Salt Lake City',
    'Utah',
    '84044',
    'USA'
);

INSERT INTO location VALUES
(
    DEFAULT,
    '1234 Broadway',
    'New York City',
    'New York',
    '10001',
    'USA'
);

---------------------------------------
-- Customer_Contact inserts
---------------------------------------
INSERT INTO customer_contact VALUES
(
    DEFAULT,
    1,
    'Henry J Eyring',
    'President',
    1,
    'hjeyring@byui.edu',
    'XXX-XXX-XXXX',
    NULL,
    true,
    'Son of an apostle.'
);

INSERT INTO customer_contact VALUES
(
    DEFAULT,
    2,
    'Russell M Nelson',
    'President',
    2,
    'nelsonrm@ldschurch.org',
    'XXX-XXX-XXXX',
    'XXX-XXX-XXXX',
    false
);

INSERT INTO customer_contact VALUES
(
    DEFAULT,
    2,
    'Jeffery R Holland',
    'Apostle',
    2,
    'hollandjr@ldschurch.org',
    'XXX-XXX-XXXX',
    'XXX-XXX-XXXX',
    true
);

INSERT INTO customer_contact VALUES
(
    DEFAULT,
    3,
    'Kasper Rorsted',
    'Chief Executive Officer',
    3,
    'kasper@adidas.com',
    'XXX-XXX-XXX-XXXX',
    NULL,
    true
);

INSERT INTO customer_contact VALUES
(
    DEFAULT,
    4,
    'Buck "Daddy" Rodgers',
    'Guy in charge',
    4,
    'daddybucky@rulethesouth.org',
    'XXX-XXX-XXXX',
    'XXX-XXX-XXXX',
    true
);

INSERT INTO customer_contact VALUES
(
    DEFAULT,
    5,
    'Quin Snyder',
    'Head Coach',
    5,
    'coachq@utahjazz.com',
    'XXX.XXX.XXXX',
    'XXX.XXX.XXXX',
    true
);

------------------------------------------
-- Employee inserts
------------------------------------------
INSERT INTO employee VALUES
(
    DEFAULT,
    'Troy Burdett',
    'troy.burdett@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'TC',
    'West'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Iron Man',
    'ironman@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'AM',
    'West'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Lil'' Sebastian',
    'minihorse@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'AM',
    'East'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Dwight Schrute',
    'bearsbeatsbattlestargalactica@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'TC',
    'East'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Michael Scott',
    'MichaelScott@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'AM',
    'South'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Jim Halpert',
    'jimbo@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'AM',
    'West'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Kevin Malone',
    'ihearthotdogs@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'TC',
    'West'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Creed Bratton',
    'mungseeds@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'TC',
    'South'
);

INSERT INTO employee VALUES
(
    DEFAULT,
    'Pam Beesley',
    'pam@hp.com',
    '$2y$10$LVxa/8zga2RtVbITpcsDdOcMR2uFfkfpldKCTmsL4xwwsfMdkr3yq',
    'ISR',
    'South'
);

-------------------------------------------
-- Printer Inserts
-------------------------------------------
INSERT INTO printer VALUES
(
    DEFAULT,
    'M3264',
    'Enterprise',
    'Jedi',
    true,
    true,
    false,
    true,
    true,
    false,
    false,
    true,
    true,
    true
);

INSERT INTO printer VALUES
(
    DEFAULT,
    'A5000',
    'Enterprise',
    'Jedi',
    true,
    true,
    true,
    true,
    true,
    true,
    true,
    true,
    false,
    false
);

INSERT INTO printer VALUES
(
    DEFAULT,
    'M23104',
    'Professional',
    'Oz',
    false,
    false,
    false,
    false,
    true,
    false,
    false,
    true,
    true,
    true
);

INSERT INTO printer VALUES
(
    DEFAULT,
    'X83d4',
    'Enterprise',
    'Jedi',
    true,
    true,
    false,
    true,
    true,
    false,
    false,
    false,
    false,
    false
);

INSERT INTO printer VALUES
(
    DEFAULT,
    'A898',
    'Enterprise',
    'Oz',
    false,
    false,
    false,
    true,
    true,
    false,
    true,
    true,
    true,
    true
);

INSERT INTO printer VALUES
(
    DEFAULT,
    'T34251',
    'Professional',
    'Jedi',
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false
);

INSERT INTO printer VALUES
(
    DEFAULT,
    'M4414',
    'Enterprise',
    'Jedi',
    true,
    true,
    false,
    true,
    true,
    false,
    false,
    false,
    false,
    false
);

-------------------------------------
-- Scanner Inserts
-------------------------------------
INSERT INTO scanner VALUES
(
    DEFAULT,
    'S9890',
    'Enterprise',
    'Oz',
    true,
    true,
    true
);

INSERT INTO scanner VALUES
(
    DEFAULT,
    'S1928',
    'Professional',
    'Oz',
    false,
    false,
    false
);

INSERT INTO scanner VALUES
(
    DEFAULT,
    'S3887',
    'Enterprise',
    'Jedi',
    true,
    false,
    false
);

--------------------------------------
-- Solution Inserts
--------------------------------------
INSERT INTO solution VALUES
(
    DEFAULT,
    'Pharos',
    'Management'
);

INSERT INTO solution VALUES
(
    DEFAULT,
    'EZ-Driver',
    'Driver'
);

INSERT INTO solution VALUES
(
    DEFAULT,
    'MySolution',
    'Management'
);

----------------------------------------
-- Customer_Employee inserts
----------------------------------------
INSERT INTO customer_employee VALUES
(
    DEFAULT,
    1,
    1
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    1,
    2
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    2,
    1
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    3,
    3
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    3,
    4
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    4,
    5
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    4,
    8
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    4,
    9
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    5,
    6
);

INSERT INTO customer_employee VALUES
(
    DEFAULT,
    4,
    7
);

-------------------------------------------
-- Customer_Location inserts
-------------------------------------------
INSERT INTO customer_location VALUES
(
    DEFAULT,
    1,
    1
);

INSERT INTO customer_location VALUES
(
    DEFAULT,
    2,
    2
);

INSERT INTO customer_location VALUES
(
    DEFAULT,
    3,
    3
);
INSERT INTO customer_location VALUES
(
    DEFAULT,
    3,
    6
);

INSERT INTO customer_location VALUES
(
    DEFAULT,
    4,
    4
);

INSERT INTO customer_location VALUES
(
    DEFAULT,
    5,
    5
);

--------------------------------------------
-- Customer_Printer inserts
--------------------------------------------
INSERT INTO customer_printer VALUES
(
    DEFAULT,
    1,
    1,
    10,
    true,
    NULL
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    1,
    4,
    6,
    false,
    'Random Note'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    2,
    7,
    95,
    true,
    'Printers in Church Office Building'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    2,
    3,
    15,
    true,
    'Printers in JSMB'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    3,
    4,
    500,
    false,
    'Adidas'' go-to printer in most US offices.'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    4,
    6,
    3,
    true,
    'They only have 3 printers... Can''t afford much more.'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    5,
    3,
    3,
    true,
    'Printers in practice facility'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    5,
    7,
    45,
    true,
    'Printers in Vivint SmartHome Arena'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    5,
    6,
    15,
    true,
    'Printers in Arena box office.'
);

INSERT INTO customer_printer VALUES
(
    DEFAULT,
    3,
    2,
    100,
    true,
    NULL
);


-------------------------------------------------
-- Customer_Scanner Inserts
-------------------------------------------------
INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    1,
    1,
    10,
    true,
    NULL
);

INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    1,
    3,
    2,
    false,
    NULL
);

INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    2,
    1,
    35,
    true,
    'My Note...'
);

INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    3,
    2,
    200,
    true,
    'I''m running out of creativity.'
);

INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    5,
    3,
    10,
    true,
    'Vivint SmartHome Arena scanners'
);

INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    5,
    2,
    10,
    true,
    'Arena box office scanners'
);

INSERT INTO customer_scanner VALUES
(
    DEFAULT,
    5,
    1,
    1,
    true,
    'Scanner in practice facility'
);

----------------------------------------
-- Customer_Solution inserts
----------------------------------------
INSERT INTO customer_solution VALUES
(
    DEFAULT,
    1,
    1,
    '3.4.1',
    10,
    NULL
);

INSERT INTO customer_solution VALUES
(
    DEFAULT,
    1,
    2,
    '1.8',
    4,
    NULL
);

INSERT INTO customer_solution VALUES
(
    DEFAULT,
    2,
    3,
    '9.4.x',
    40,
    NULL
);

INSERT INTO customer_solution VALUES
(
    DEFAULT,
    5,
    2,
    '1.1.6',
    5,
    NULL
);

-- Show the assigned employees to each company
SELECT c.name AS "Customer", e.name AS "Employee Name", e.type AS "Employee Type"
FROM customer "c" INNER JOIN customer_employee "ce"
ON c.id = ce.customer_id INNER JOIN employee "e"
ON e.id = ce.employee_id;

-- Show the printers each company has
SELECT c.name AS "Customer", p.model_name "Printer Name", cp.qty_in_fleet AS "Quantity In Fleet"
FROM customer "c" INNER JOIN customer_printer "cp"
ON c.id = cp.customer_id INNER JOIN printer "p"
ON p.id = cp.printer_id
ORDER BY c.name;

-- Show only BYU-Idaho printers
SELECT c.name AS "Customer", p.model_name "Printer Name", cp.qty_in_fleet AS "Quantity In Fleet"
FROM customer "c" INNER JOIN customer_printer "cp"
ON c.id = cp.customer_id INNER JOIN printer "p"
ON p.id = cp.printer_id
WHERE c.name = 'BYU-Idaho';

SELECT e.name AS "name", e.email AS "email", e.type AS "type"
FROM customer c INNER JOIN customer_employee ce
ON c.id = ce.customer_id INNER JOIN employee e
ON ce.employee_id = e.id
WHERE c.id = 1;

SELECT p.model_name AS "name", cp.qty_in_fleet AS "qty", cp.fs4 AS "fs4", cp.notes as "notes"
FROM customer c INNER JOIN customer_printer cp
ON c.id = cp.customer_id INNER JOIN printer p
ON p.id = cp.printer_id
WHERE c.id = 1;

SELECT s.model_name AS "name", cs.qty_in_fleet AS "qty", cs.fs4 AS "fs4", cs.notes AS "notes"
FROM customer c INNER JOIN customer_scanner cs
ON c.id = cs.customer_id INNER JOIN scanner s
ON s.id = cs.scanner_id
WHERE c.id = 1;

SELECT s.name AS "name", cs.version AS "version", cs.qty_licenses AS "qty", cs.notes AS "notes"
FROM customer c INNER JOIN customer_solution cs
ON c.id = cs.customer_id INNER JOIN solution s
ON s.id = cs.solution_id
WHERE c.id = 1;

SELECT ce.name AS "name", ce.title AS "title", ce.email AS "email", ce.business_phone AS "business", ce.mobile_phone AS "mobile", ce.main_contact AS "main", ce.notes AS "notes"
FROM customer c INNER JOIN customer_contact ce
ON c.id = ce.customer_id
WHERE c.id = 1;

SELECT l.address AS "address", l.city AS "city", l.state AS "state", l.zip AS "zip", l.country AS "country"
FROM customer c INNER JOIN customer_location cl
ON c.id = cl.customer_id INNER JOIN location l
ON l.id = cl.location_id 
WHERE c.id = 1;