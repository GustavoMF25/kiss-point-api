-- Data: 05/04/2022
-- Por: Herrison Trugilho

CREATE TABLE rules (
idrules int(11) PRIMARY KEY,
idgroup int(11),
description text,
points int(11)
)

CREATE TABLE usergroup (
idusergroup int(11) PRIMARY KEY,
iduser int(11),
idgroup int(11),
admin enum('y','n')
)

CREATE TABLE punctuation (
idpunctuation int(11) PRIMARY KEY,
idusergroup int(11),
point int(11),
FOREIGN KEY(idusergroup) REFERENCES usergroup (idusergroup)
)

CREATE TABLE color (
idcolor int(11) PRIMARY KEY,
iduser int(11),
background varchar(255),
text varchar(255)
)

CREATE TABLE configgroup (
idconfiggroup int(11) PRIMARY KEY,
idgroup int(11),
fixed enum('y','n'),
sound enum('y','n'),
private enum('y','n')
)

CREATE TABLE group (
idgroup int(11) PRIMARY KEY,
name varchar(255),
description text,
capmax int(11),
active enum('y','n')
)

CREATE TABLE user (
iduser int(11) PRIMARY KEY,
login varchar(255),
password varchar(255),
name varchar(255),
email varchar(255),
photo varchar(255),
phone Número(4),
active enum('y','n'),
datebirth date,
country varchar(255),
state varchar(2),
city varchar(255),
emailVerified varchar(6)
)

CREATE TABLE notification (
idnotification int(11) PRIMARY KEY,
iduser int(11),
title varchar(255),
text text,
dategen date,
hourgen time,
read enum('y','n'),
dateread date,
hourread time,
FOREIGN KEY(iduser) REFERENCES user (iduser)
)

CREATE TABLE tokenemail (
idtokenemail int(11) PRIMARY KEY,
iduser int(11),
code varchar(6),
dategen date,
hourgen time,
FOREIGN KEY(iduser) REFERENCES user (iduser)
)

ALTER TABLE rules ADD FOREIGN KEY(idgroup) REFERENCES group (idgroup)
ALTER TABLE usergroup ADD FOREIGN KEY(iduser) REFERENCES user (iduser)
ALTER TABLE usergroup ADD FOREIGN KEY(idgroup) REFERENCES group (idgroup)
ALTER TABLE color ADD FOREIGN KEY(iduser) REFERENCES user (iduser)
ALTER TABLE configgroup ADD FOREIGN KEY(idgroup) REFERENCES group (idgroup)
