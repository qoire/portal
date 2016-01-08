  create table phplens (
  	ID char(12) not null,
	LASTMOD datetime not null,
	DATA text not null,
	primary key (id)
  );

  create table sessions (
       SESSKEY char(32) not null,
       EXPIRY int  not null,
       DATA text not null,
      primary key (sesskey)
  );
  
  
