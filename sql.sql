drop database if exists coffee;
create database if not exists coffee CHARACTER SET utf8 COLLATE utf8_general_ci;
use coffee;

CREATE TABLE address (addressID BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, street VARCHAR(80) NOT NULL,
		street2 VARCHAR(80) NOT NULL, city VARCHAR(80) NOT NULL, state varchar(80) NOT NULL, country VARCHAR(80) NOT NULL,
        zipcode INT UNSIGNED NOT NULL);
        
CREATE TABLE users (userID BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, userName VARCHAR(20) UNIQUE NOT NULL,
		userPassword CHAR(60) NOT NULL, emailAddress VARCHAR(65) NOT NULL UNIQUE, billingAddressID BIGINT UNSIGNED,
        FOREIGN KEY (billingAddressID) REFERENCES address(addressID));

CREATE TABLE pictures (pictureID BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, userID BIGINT UNSIGNED NOT NULL, picture LONGBLOB,
		pictureType varchar(60), FOREIGN KEY (userID) REFERENCES users(userID));

CREATE TABLE coffeeBlends (blendID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, blendName VARCHAR(80) NOT NULL, visible BIT NOT NULL DEFAULT 1,
		picture BLOB, color BIT, caffeination BIT NOT NULL, price DOUBLE (5,2) NOT NULL, active BIT NOT NULL DEFAULT 1, coffeeDescription varchar(255)); 

CREATE TABLE cart(userID BIGINT UNSIGNED NOT NULL, blendID INT UNSIGNED NOT NULL, 
		quantity INT NOT NULL, PRIMARY KEY(userID, blendID), FOREIGN KEY (userID) REFERENCES users(userID),
        FOREIGN KEY (blendID) REFERENCES coffeeBlends(blendID));

SELECT * FROM cart;

INSERT INTO coffeeBlends (blendName, price, caffeination, coffeeDescription, visible) VALUES ("Cowboy Coffee", 20, 0, 'Great', 1);