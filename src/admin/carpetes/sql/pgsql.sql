CREATE TABLE |nomtaula| (
  ID SERIAL,
  ECLASS INT2 NOT NULL default '0',
  SKIN INT2 NOT NULL default '0',
  CATEGORY1 integer NOT NULL default '0',
  CATEGORY2 integer NOT NULL default '0',
  STATUS INT2 NOT NULL default '0',
  VISIBILITY INT2 NOT NULL default '0',
  CREATION TIMESTAMP NOT NULL default '0001-01-01 00:00:00',
  START_TIME TIMESTAMP NOT NULL default '0001-01-01 00:00:00',
  END_TIME TIMESTAMP NOT NULL default '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL default '0001-01-01 00:00:00',
  CALENDAR_START_TIME TIMESTAMP NOT NULL default '0001-01-01 00:00:00',
  CALENDAR_END_TIME TIMESTAMP NOT NULL default '0001-01-01 00:00:00',      
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  TITOL varchar(250) default NULL,
  SUBTITOL varchar(250) default NULL,
  RESUM text,
  DESCRIPCIO text,
  DESCRIPCIO2 text,
  LINK1 varchar(250) default NULL,
  TEXTLINK1 varchar(255) NOT NULL default '',
  FINESTRA1 INT2 NOT NULL default '0',
  LINK2 varchar(255) default NULL,
  TEXTLINK2 varchar(255) NOT NULL default '',
  FINESTRA2 INT2 NOT NULL default '0',
  LINK3 varchar(255) NOT NULL default '',
  TEXTLINK3 varchar(255) NOT NULL default '',
  FINESTRA3 INT2 NOT NULL default '0',
  IMATGE1 varchar(255) default NULL,
  PEU_IMATGE1 varchar(255) NOT NULL default '',
  IMATGE2 varchar(255) default NULL,
  PEU_IMATGE2 varchar(255) NOT NULL default '',
  IMATGE3 varchar(255) default NULL,
  PEU_IMATGE3 varchar(255) NOT NULL default '',
  ADJUNT1 varchar(255) default NULL,
  TEXT_ADJUNT1 varchar(255) NOT NULL default '',
  ADJUNT2 varchar(255) default NULL,
  TEXT_ADJUNT2 varchar(255) NOT NULL default '',
  ADJUNT3 varchar(255) default NULL,
  TEXT_ADJUNT3 varchar(255) NOT NULL default '',  
  DATA varchar(250) default NULL,
  AUTOR text NOT NULL default '',
  ORDRE integer DEFAULT '0' NULL,
  PRIMARY KEY  (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0),
  CHECK (FINESTRA1>=0),
  CHECK (FINESTRA2>=0),
  CHECK (FINESTRA3>=0)
);
create index IDX_ECLASS_|nomtaula| on |nomtaula| (ECLASS);
create index IDX_CATEGORY1_|nomtaula| on |nomtaula| (CATEGORY1);
create index IDX_CATEGORY2_|nomtaula| on |nomtaula| (CATEGORY2);
