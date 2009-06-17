truncate entries;
truncate tags

CREATE TABLE entries (id INT UNSIGNED AUTO_INCREMENT, 
title VARCHAR (255) NOT NULL, 
url VARCHAR (255), 
content TEXT, 
image mediumLOB, 
addtime DATETIME NOT NULL, 
private TINYINT (1) UNSIGNED DEFAULT '0' NOT NULL, 
type enum ('link','note',
'pic') BINARY NOT NULL,
tag_ids SET ('1','2','3','4','5','6','7','8','9','10') NOT NULL, 
PRIMARY KEY(id)) 

CREATE TABLE tags (id INT UNSIGNED AUTO_INCREMENT, name VARCHAR (64) NOT NULL, count_link SMALLINT (3) UNSIGNED DEFAULT '0' NOT NULL, count_note SMALLINT (3) UNSIGNED DEFAULT '0' NOT NULL, count_pic SMALLINT (3) UNSIGNED DEFAULT '0' NOT NULL, usetime DATETIME NOT NULL, PRIMARY KEY(id)) 
