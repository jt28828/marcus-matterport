##MySQL setup##

Create a MySQL database and run the following script.
Make sure to change the database credentials in /php/db.php

~~~sql
CREATE DATABASE matterport;

CREATE TABLE users
(
	id int AUTO_INCREMENT,
	firstname varchar(250),
	lastname varchar(250),
	email varchar(250),
	password varchar(250),
	PRIMARY KEY(id)
);

CREATE TABLE properties
(
	id int AUTO_INCREMENT,
	address varchar(250),
	agent_id int,
	matterport_link varchar(250),
	realestate_link varchar(250),
	googlemaps_link varchar(250),
	PRIMARY KEY(id),
	FOREIGN KEY (agent_id) REFERENCES agents(id)
);

CREATE TABLE agents
(
	id int AUTO_INCREMENT,
	name varchar(250),
	position varchar(250),
	contact varchar(250),
	website varchar(250),
	company_logo varchar(250),
	agent_photo varchar(250),
	PRIMARY KEY(id)
);

INSERT INTO users (firstname, lastname, email, password)
	VALUES ('John', 'Doe', 'email@email.com', 'password');
~~~
