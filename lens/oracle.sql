
  create table sessions (
       SESSKEY char(32) primary key not null,
       EXPIRY int  not null,
       DATA CLOB not null
  );
  
  create table phplens (
  	ID char(12) primary key not null,
	LASTMOD date not null,
	DATA CLOB
  );

  create table lensusers (
  	USERID char(16) primary key not null,
	PASSWORD char(16) not null,
  	FIRSTNAME char(24) ,
	LASTNAME char(24) not null,
	EMAIL char(48) not null,
	ADDRESS1 char(48) not null,
	ADDRESS2 char(48) ,
	POSTCODE char(12) ,
	CITY char(24) ,
	STATE char(24) ,
	COUNTRY char(24) not null,
	AGE integer,
	CREATED date not null,
	LASTMOD date not null
  );
  
    create table photos (
  	ID integer primary key,
	NAME char(24),
	DATA blob
  );
  
  commit;
  