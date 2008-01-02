CREATE TABLE IF NOT EXISTS reports (
  id INT( 10 ) NOT NULL AUTO_INCREMENT,
  title TEXT NOT NULL,
  report TEXT NOT NULL,
  PRIMARY KEY (id)
) TYPE = MYISAM ;

CREATE TABLE IF NOT EXISTS hackers (
  pid INT( 10 ) NOT NULL,
  gamespy_name TEXT NOT NULL,
  PRIMARY KEY (pid)
) TYPE = MYISAM ;

CREATE TABLE IF NOT EXISTS hacked_names (
  id INT( 10 ) NOT NULL AUTO_INCREMENT,
  pid INT( 10 ) NOT NULL,
  hacked_name TEXT NOT NULL,
  server_name TEXT NOT NULL,
  server_addr VARCHAR( 22 ) NOT NULL,
  date_time VARCHAR ( 256 ) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (pid) REFERENCES hackers (pid)
) TYPE = MYISAM ;
