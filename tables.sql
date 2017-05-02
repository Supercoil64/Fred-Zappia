CREATE TABLE Artist (
	aid int NOT NULL AUTO_INCREMENT,
	image varchar(512) NOT NULL,
	phone varchar(20) NOT NULL,
	email varchar(100) NOT NULL,
	introduction text NOT NULL,
	street varchar(100) NOT NULL,
	zip int NOT NULL,
	name varchar(20) NOT NULL,
	PRIMARY KEY(aid)
);

CREATE TABLE Address(
	zip int NOT NULL AUTO_INCREMENT,
	city varchar(50) NOT NULL,
	state varchar(50) NOT NULL,
	PRIMARY KEY (zip)
);

CREATE TABLE User_info (
	username varchar(50) NOT NULL,
	hash_password varchar(50) NOT NULL,
	PRIMARY KEY (username)
);

CREATE TABLE Exhibitions (
	eid int NOT NULL AUTO_INCREMENT,
	content varchar(512) NOT NULL,
	start_time date NOT NULL,
	end_time date NOT NULL,
	street varchar(50) NOT NULL,
	zip int NOT NULL,
	PRIMARY KEY (eid)
);


CREATE TABLE Ablums (
	album_id int NOT NULL,
	date_created timestamp DEFAULT CURRENT_TIMESTAMP,
	date_modified timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	title varchar(50) NOT NULL,
	description varchar(512) NOT NULL,
	PRIMARY KEY (album_id)
);

CREATE TABLE Images (
	image_id int NOT NULL,
	title varchar(50) NOT NULL,
	caption varchar(50) NOT NULL,
	price int NOT NULL,
	dimensions varchar(50) NOT NULL,
	file_path varchar(512) NOT NULL,
	date_created timestamp NOT NULL,
	PRIMARY KEY (image_id)
);

CREATE TABLE Display (
	image_id int NOT NULL,
	album_id int NOT NULL,
	display_id int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (display_id),
	FOREIGN KEY (image_id) REFERENCES Images(image_id),
	FOREIGN KEY (album_id) REFERENCES Ablums (album_id)
)