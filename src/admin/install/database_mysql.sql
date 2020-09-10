
--
-- Estructura de la taula CARPETES
--

CREATE TABLE CARPETES (
  ID int(11) unsigned NOT NULL auto_increment,
  NOMCARPETA varchar(250) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  PARE int(11) unsigned default NULL,

  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  IDIOMA char(2) default NULL,
  TITOL text,
  SUBTITOL varchar(250) default NULL,
  APARTAT varchar(250) default NULL,
  CATEGORIES text,
  INTRODUCCIO  text,

  METATITOL varchar(255) default NULL,
  METADESCRIPCIO text,
  METAKEYS text,

  MENU1 varchar(150) NOT NULL default '',
  MENU2 varchar(150) NOT NULL default '',
  MENU3 varchar(150) NOT NULL default '',

  BANNER1 varchar(150) NOT NULL default '',
  BANNER2 varchar(150) NOT NULL default '',
  BANNER3 varchar(150) NOT NULL default '',

  RSS tinyint(3) unsigned NOT NULL default '0',
  CARPETAINICI tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (ID),
  UNIQUE KEY NOMCARPETA (NOMCARPETA,PARE),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;


-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `CARPETES_IDIOMES`
--

CREATE TABLE CARPETES_IDIOMES (
  ID int(11) NOT NULL,
  IDIOMA char(2) NOT NULL,
  TITOL char(150) NOT NULL default '',
  METAKEYS TEXT NOT NULL default '',
  PRIMARY KEY  (ID, IDIOMA)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula ESTATICA
--

CREATE TABLE ESTATICA (
  ID int(11) unsigned NOT NULL auto_increment,
  NOMPAG varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  PARE int(11) unsigned NOT NULL,

  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  IDIOMA char(2) default NULL,
  REFERENCIA int(11) NOT NULL default '0',
  METATITOL varchar(255) default NULL,
  METADESCRIPCIO text,
  METAKEYS text,
  PLANTILLAID int(11) default null,
  MENU1 varchar(150) NOT NULL default '',
  MENU2 varchar(150) NOT NULL default '',
  MENU3 varchar(150) NOT NULL default '',
  BANNER1 varchar(150) NOT NULL default '',
  BANNER2 varchar(150) NOT NULL default '',
  BANNER3 varchar(150) NOT NULL default '',
  CERCADOR tinyint(2) default '0',
  TEXTC1 varchar(250) default NULL,
  TEXTC2 varchar(250) default NULL,
  TEXTC3 varchar(250) default NULL,
  TEXTC4 varchar(250) default NULL,
  TEXTC5 varchar(250) default NULL,
  TEXTC6 varchar(250) default NULL,
  TEXTC7 varchar(250) default NULL,
  TEXTC8 varchar(250) default NULL,
  TEXTC9 varchar(250) default NULL,
  TEXTC10 varchar(250) default NULL,
  TEXTC11 varchar(250) default NULL,
  TEXTC12 varchar(250) default NULL,
  TEXTC13 varchar(250) default NULL,
  TEXTC14 varchar(250) default NULL,
  TEXTC15 varchar(250) default NULL,
  TEXTC16 varchar(250) default NULL,
  TEXTC17 varchar(250) default NULL,
  TEXTC18 varchar(250) default NULL,
  TEXTC19 varchar(250) default NULL,
  TEXTC20 varchar(250) default NULL,
  TEXTC21 varchar(250) default NULL,
  TEXTC22 varchar(250) default NULL,
  TEXTC23 varchar(250) default NULL,
  TEXTC24 varchar(250) default NULL,
  TEXTC25 varchar(250) default NULL,
  TEXTC26 varchar(250) default NULL,
  TEXTC27 varchar(250) default NULL,
  TEXTC28 varchar(250) default NULL,
  TEXTC29 varchar(250) default NULL,
  TEXTC30 varchar(250) default NULL,
  TEXTC31 varchar(250) default NULL,
  TEXTC32 varchar(250) default NULL,
  TEXTC33 varchar(250) default NULL,
  TEXTC34 varchar(250) default NULL,
  TEXTC35 varchar(250) default NULL,
  TEXTC36 varchar(250) default NULL,
  TEXTC37 varchar(250) default NULL,
  TEXTC38 varchar(250) default NULL,
  TEXTC39 varchar(250) default NULL,
  TEXTC40 varchar(250) default NULL,
  TEXTC41 varchar(250) default NULL,
  TEXTC42 varchar(250) default NULL,
  TEXTC43 varchar(250) default NULL,
  TEXTC44 varchar(250) default NULL,
  TEXTC45 varchar(250) default NULL,
  TEXTL1 text,
  TEXTL2 text,
  TEXTL3 text,
  TEXTL4 text,
  TEXTL5 text,
  TEXTL6 text,
  TEXTL7 text,
  TEXTL8 text,
  TEXTL9 text,
  TEXTL10 text,
  IMATGE1 varchar(100) default NULL,
  IMATGE2 varchar(100) default NULL,
  IMATGE3 varchar(100) default NULL,
  IMATGE4 varchar(100) default NULL,
  IMATGE5 varchar(100) default NULL,
  IMATGE6 varchar(100) default NULL,
  IMATGE7 varchar(100) default NULL,
  IMATGE8 varchar(100) default NULL,
  IMATGE9 varchar(100) default NULL,
  IMATGE10 varchar(100) default NULL,
  IMATGE11 varchar(100) default NULL,
  IMATGE12 varchar(100) default NULL,
  IMATGE13 varchar(100) default NULL,
  IMATGE14 varchar(100) default NULL,
  IMATGE15 varchar(100) default NULL,
  IMATGE16 varchar(100) default NULL,
  IMATGE17 varchar(100) default NULL,
  IMATGE18 varchar(100) default NULL,
  IMATGE19 varchar(100) default NULL,
  IMATGE20 varchar(100) default NULL,
  IMATGE21 varchar(100) default NULL,
  IMATGE22 varchar(100) default NULL,
  IMATGE23 varchar(100) default NULL,
  IMATGE24 varchar(100) default NULL,
  IMATGE25 varchar(100) default NULL,
  ADJUNT1 varchar(100) default NULL,
  ADJUNT2 varchar(100) default NULL,
  ADJUNT3 varchar(100) default NULL,
  ADJUNT4 varchar(100) default NULL,
  ADJUNT5 varchar(100) default NULL,
  ADJUNT6 varchar(100) default NULL,
  ADJUNT7 varchar(100) default NULL,
  ADJUNT8 varchar(100) default NULL,
  ADJUNT9 varchar(100) default NULL,
  ADJUNT10 varchar(100) default NULL,
  ALT1 varchar(255) default NULL,
  ALT2 varchar(255) default NULL,
  ALT3 varchar(255) default NULL,
  ALT4 varchar(255) default NULL,
  ALT5 varchar(255) default NULL,
  ALT6 varchar(255) default NULL,
  ALT7 varchar(255) default NULL,
  ALT8 varchar(255) default NULL,
  ALT9 varchar(255) default NULL,
  ALT10 varchar(255) default NULL,
  OP1 VARCHAR(1) NOT NULL,
  OP2 VARCHAR(1) NOT NULL,
  OP3 VARCHAR(1) NOT NULL,
  OP4 VARCHAR(1) NOT NULL,
  OP5 VARCHAR(1) NOT NULL,
  PRIMARY KEY  (ID),
  UNIQUE KEY NOMPAG (NOMPAG,PARE),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (NOMPAG),
  KEY IDX_CATEGORY2 (DESCRIPCIO)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula DIN_CATEGORIES
--

CREATE TABLE DIN_CATEGORIES (
  ID int(11) unsigned NOT NULL auto_increment,
  NOM varchar(50) NOT NULL default '',
  URL_NOM varchar(50) NOT NULL default '',
  DESCRIPCIO text NOT NULL default '',
  IMATGE varchar(255) NOT NULL default '',
  PARE int(11) default NULL,
  DINAMICA int(11) unsigned NOT NULL,
  ORDRE int(11) default NULL,
  PRIMARY KEY  (ID),
  UNIQUE KEY NOMPAG (DINAMICA,PARE,NOM)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula FORMULARIS
--

CREATE TABLE FORMULARIS (
  ID int(11) unsigned NOT NULL auto_increment,
  NOMFORMULARI varchar(50) NOT NULL default '',
  DESCRIPCIO text default NULL,
  PARE int(11) unsigned NOT NULL,

  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  IDIOMA char(2) NOT NULL default '',
  METATITOL varchar(255) default NULL,
  METADESCRIPCIO text,
  METAKEYS text,
  TITOLFORMULARI varchar(250) NOT NULL default '',
  PLANTILLA varchar(250) NOT NULL default '',
  MENU1 varchar(150) NOT NULL default '',
  MENU2 varchar(150) NOT NULL default '',
  MENU3 varchar(150) NOT NULL default '',
  BANNER1 varchar(150) NOT NULL default '',
  BANNER2 varchar(150) NOT NULL default '',
  BANNER3 varchar(150) NOT NULL default '',
  ACTION varchar(250) NOT NULL default '',
  RECIPIENT varchar(250) NOT NULL default '',
  REDIRECT varchar(250) NOT NULL default '',
  PRIMARY KEY  (ID),
  UNIQUE KEY NOMFORMULARI (NOMFORMULARI,PARE),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula FORMULARISITEMS
--

CREATE TABLE FORMULARISITEMS (
  ID int(11) unsigned NOT NULL auto_increment,
  TEXT varchar(100) NOT NULL default '',
  NOM varchar(100) NOT NULL default '',
  VALOR varchar(250) NOT NULL default '',
  TIPO tinyint(2) NOT NULL default '0',
  TAMANY tinyint(5) NOT NULL default '0',
  ORDRE tinyint(5) NOT NULL default '0',
  OBLIGATORI tinyint(2) NOT NULL default '0',
  FORMULARI int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula MENUS
--

CREATE TABLE MENUS (
  ID int(11) unsigned NOT NULL auto_increment,
  NOM varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  PARE int(11) unsigned NOT NULL,

  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  ACCESSUBCARP tinyint(2) NOT NULL default '1',


  IDIOMA char(2) NOT NULL default '',
  PLANTILLA varchar(100) NOT NULL default '',
  TIPO tinyint(2) NOT NULL default '0',
  DESPLEGABLE varchar(100) not null default '',
  ESTIL varchar(100) NOT NULL default '',

  PRIMARY KEY  (ID),
  UNIQUE KEY NOM (NOM),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula MENUITEMS
--

CREATE TABLE MENUITEMS (
  ID int(11) unsigned NOT NULL auto_increment,
  TEXT varchar(100) NOT NULL default '',
  LINKPAGE varchar(100) NOT NULL default '',
  FINESTRA tinyint(1) not null default 0,
  IMATGE varchar(255) default NULL,
  CSSCLASS varchar(255) default NULL,
  DIRECTORI int(11) default -1,
  EDITORA int(11) default -1,
  `SEPARATOR` tinyint(1) not null default 0,
  ORDRE tinyint(5) NOT NULL default '0',
  MENU int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula MENUITEMSSUB
--

CREATE TABLE MENUITEMSSUB (
  ID int(11) unsigned NOT NULL auto_increment,
  TEXT varchar(100) NOT NULL default '',
  LINKPAGE varchar(100) NOT NULL default '',
  FINESTRA tinyint(1) not null default 0,
  IMATGE varchar(255) default NULL,
  CSSCLASS varchar(255) default NULL,
  `SEPARATOR` tinyint(1) not null default 0,
  ORDRE tinyint(5) NOT NULL default '0',
  MENUITEM int(11) NOT NULL default '0',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula PLANTILLA
--

CREATE TABLE PLANTILLA (
  ID int(11) unsigned NOT NULL auto_increment,
  NOM varchar(255) default NULL,
  DESCRIPCIO varchar(255) default NULL,
  PARE int(11) unsigned NOT NULL,

  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  TEXTCURT smallint(5) NOT NULL default '0',
  TEXTLLARG smallint(5) NOT NULL default '0',
  IMATGES smallint(5) NOT NULL default '0',
  ADJUNTS smallint(5) NOT NULL default '0',
  OP SMALLINT( 5 ) NOT NULL DEFAULT '0',
  IDIOMA char(2) NOT NULL default '',
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula PLANTILLA_DESC
--

CREATE TABLE PLANTILLA_DESC (
  ID int(11) unsigned NOT NULL auto_increment,
  PLANTILLA int(11) NOT NULL default '0',
  TEXTC1 varchar(100) default '|TEXTC1|',
  TEXTC2 varchar(100) default '|TEXTC2|',
  TEXTC3 varchar(100) default '|TEXTC3|',
  TEXTC4 varchar(100) default '|TEXTC4|',
  TEXTC5 varchar(100) default '|TEXTC5|',
  TEXTC6 varchar(100) default '|TEXTC6|',
  TEXTC7 varchar(100) default '|TEXTC7|',
  TEXTC8 varchar(100) default '|TEXTC8|',
  TEXTC9 varchar(100) default '|TEXTC9|',
  TEXTC10 varchar(100) default '|TEXTC10|',
  TEXTC11 varchar(100) default '|TEXTC11|',
  TEXTC12 varchar(100) default '|TEXTC12|',
  TEXTC13 varchar(100) default '|TEXTC13|',
  TEXTC14 varchar(100) default '|TEXTC14|',
  TEXTC15 varchar(100) default '|TEXTC15|',
  TEXTC16 varchar(100) default '|TEXTC16|',
  TEXTC17 varchar(100) default '|TEXTC17|',
  TEXTC18 varchar(100) default '|TEXTC18|',
  TEXTC19 varchar(100) default '|TEXTC19|',
  TEXTC20 varchar(100) default '|TEXTC20|',
  TEXTC21 varchar(100) default '|TEXTC21|',
  TEXTC22 varchar(100) default '|TEXTC22|',
  TEXTC23 varchar(100) default '|TEXTC23|',
  TEXTC24 varchar(100) default '|TEXTC24|',
  TEXTC25 varchar(100) default '|TEXTC25|',
  TEXTC26 varchar(100) default '|TEXTC26|',
  TEXTC27 varchar(100) default '|TEXTC27|',
  TEXTC28 varchar(100) default '|TEXTC28|',
  TEXTC29 varchar(100) default '|TEXTC29|',
  TEXTC30 varchar(100) default '|TEXTC30|',
  TEXTC31 varchar(100) default '|TEXTC31|',
  TEXTC32 varchar(100) default '|TEXTC32|',
  TEXTC33 varchar(100) default '|TEXTC33|',
  TEXTC34 varchar(100) default '|TEXTC34|',
  TEXTC35 varchar(100) default '|TEXTC35|',
  TEXTC36 varchar(100) default '|TEXTC36|',
  TEXTC37 varchar(100) default '|TEXTC37|',
  TEXTC38 varchar(100) default '|TEXTC38|',
  TEXTC39 varchar(100) default '|TEXTC39|',
  TEXTC40 varchar(100) default '|TEXTC40|',
  TEXTC41 varchar(100) default '|TEXTC41|',
  TEXTC42 varchar(100) default '|TEXTC42|',
  TEXTC43 varchar(100) default '|TEXTC43|',
  TEXTC44 varchar(100) default '|TEXTC44|',
  TEXTC45 varchar(100) default '|TEXTC45|',
  TEXTL1 varchar(100) default '|TEXTL1|',
  TEXTL2 varchar(100) default '|TEXTL2|',
  TEXTL3 varchar(100) default '|TEXTL3|',
  TEXTL4 varchar(100) default '|TEXTL4|',
  TEXTL5 varchar(100) default '|TEXTL5|',
  TEXTL6 varchar(100) default '|TEXTL6|',
  TEXTL7 varchar(100) default '|TEXTL7|',
  TEXTL8 varchar(100) default '|TEXTL8|',
  TEXTL9 varchar(100) default '|TEXTL9|',
  TEXTL10 varchar(100) default '|TEXTL10|',
  IMATGE1 varchar(100) default '|IMATGE1|',
  IMATGE2 varchar(100) default '|IMATGE2|',
  IMATGE3 varchar(100) default '|IMATGE3|',
  IMATGE4 varchar(100) default '|IMATGE4|',
  IMATGE5 varchar(100) default '|IMATGE5|',
  IMATGE6 varchar(100) default '|IMATGE6|',
  IMATGE7 varchar(100) default '|IMATGE7|',
  IMATGE8 varchar(100) default '|IMATGE8|',
  IMATGE9 varchar(100) default '|IMATGE9|',
  IMATGE10 varchar(100) default '|IMATGE10|',
  IMATGE11 varchar(100) default '|IMATGE11|',
  IMATGE12 varchar(100) default '|IMATGE12|',
  IMATGE13 varchar(100) default '|IMATGE13|',
  IMATGE14 varchar(100) default '|IMATGE14|',
  IMATGE15 varchar(100) default '|IMATGE15|',
  IMATGE16 varchar(100) default '|IMATGE16|',
  IMATGE17 varchar(100) default '|IMATGE17|',
  IMATGE18 varchar(100) default '|IMATGE18|',
  IMATGE19 varchar(100) default '|IMATGE19|',
  IMATGE20 varchar(100) default '|IMATGE20|',
  IMATGE21 varchar(100) default '|IMATGE21|',
  IMATGE22 varchar(100) default '|IMATGE22|',
  IMATGE23 varchar(100) default '|IMATGE23|',
  IMATGE24 varchar(100) default '|IMATGE24|',
  IMATGE25 varchar(100) default '|IMATGE25|',
  ADJUNT1 varchar(100) default '|ADJUNT1|',
  ADJUNT2 varchar(100) default '|ADJUNT2|',
  ADJUNT3 varchar(100) default '|ADJUNT3|',
  ADJUNT4 varchar(100) default '|ADJUNT4|',
  ADJUNT5 varchar(100) default '|ADJUNT5|',
  ADJUNT6 varchar(100) default '|ADJUNT6|',
  ADJUNT7 varchar(100) default '|ADJUNT7|',
  ADJUNT8 varchar(100) default '|ADJUNT8|',
  ADJUNT9 varchar(100) default '|ADJUNT9|',
  ADJUNT10 varchar(100) default '|ADJUNT10|',
  ALT1 varchar(255) default '|ALT1|',
  ALT2 varchar(255) default '|ALT2|',
  ALT3 varchar(255) default '|ALT3|',
  ALT4 varchar(255) default '|ALT4|',
  ALT5 varchar(255) default '|ALT5|',
  ALT6 varchar(255) default '|ALT6|',
  ALT7 varchar(255) default '|ALT7|',
  ALT8 varchar(255) default '|ALT8|',
  ALT9 varchar(255) default '|ALT9|',
  ALT10 varchar(255) default '|ALT10|',
  OP1 VARCHAR( 100 ) NOT NULL DEFAULT '|OP1|',
  OP2 VARCHAR( 100 ) NOT NULL DEFAULT '|OP2|',
  OP3 VARCHAR( 100 ) NOT NULL DEFAULT '|OP3|',
  OP4 VARCHAR( 100 ) NOT NULL DEFAULT '|OP4|',
  OP5 VARCHAR( 100 ) NOT NULL DEFAULT '|OP5|',
  PRIMARY KEY  (ID),
  UNIQUE KEY PLANTILLA (PLANTILLA)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula REGISTRE
--

CREATE TABLE REGISTRE (
  DATA datetime NOT NULL,
  LOGIN char(25) NOT NULL,
  IP char(255) NOT NULL default '',
  ACTION varchar(150) NOT NULL default '',
  DESCRIPTION text NOT NULL default '',
  KEY IDX_USER (LOGIN),
  KEY IDX_DATA (DATA)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula USERS
--

CREATE TABLE USERS (
  LOGIN varchar(15) NOT NULL,
  PASSWD varchar(64) NOT NULL,
  USERLEVEL tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  EXPIRATION datetime NOT NULL default '0000-00-00 00:00:00',
  EMAIL varchar(100) default NULL,
  REALNAME varchar(250) default NULL,
  TELEPHONE varchar(15) default NULL,
  COMMENTS text,
  PRIMARY KEY  (LOGIN),
  KEY IDX_USERLEVEL (USERLEVEL)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula BANNERS
--

CREATE TABLE BANNERS (
  ID int(11) unsigned NOT NULL auto_increment,
  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  NOM varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  TIPO tinyint(2) NOT NULL default '0',
  TEXT text,
  CAIXETES int(11) NOT NULL default '4',
  PRIMARY KEY  (ID),
  UNIQUE KEY NOM (NOM),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula CAIXETES
--

CREATE TABLE CAIXETES (
  ID int(11) unsigned NOT NULL auto_increment,
  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  NOM varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  TIPO tinyint(2) NOT NULL default '0',
  TITOL varchar(255) default NULL,
  TEXT text,
  LINKC varchar(255) default NULL,
  FINESTRA tinyint(2) NOT NULL default '0',
  IMATGE varchar(250) default NULL,
  IMATGE_ALTERNATIVA varchar(250) NOT NULL default '',
  WIDTH int(10) unsigned NOT NULL default '0',
  HEIGHT int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (ID),
  UNIQUE KEY NOM (NOM),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula VIEWRSS
--

CREATE TABLE VIEWRSS (
  ID int(11) unsigned NOT NULL auto_increment,
  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  NOM varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  LINKRSS varchar(255) default NULL,
  MAXRSS tinyint(2) NOT NULL default '0',
  PLANTILLA varchar(255) default NULL,
  PRIMARY KEY  (ID),
  UNIQUE KEY NOM (NOM),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula ENQUESTA
--

CREATE TABLE ENQUESTA (
  ID smallint(5) unsigned NOT NULL auto_increment,
  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME  datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME  datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  NOM varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  PLANTILLA varchar(255) default NULL,
  TITOL varchar(250) default NULL,
  PRIMARY KEY  (ID),
  UNIQUE KEY NOM (NOM),
  KEY IDX_CLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula ENQUESTA_PREG
--

CREATE TABLE ENQUESTA_PREG (
  ID smallint(5) unsigned NOT NULL auto_increment,
  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME  datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME  datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  USUARICREAR varchar(255) NOT NULL default '',
  USUARIMODI varchar(255) NOT NULL default '',
  DESCRIPCIO varchar(255) default NULL,
  VOTS smallint(5) NOT NULL default '0',
  ENQUESTA smallint(5) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY IDX_ENQUESTA (ENQUESTA),
  KEY IDX_CLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula GRUPS_UPLOAD
--

CREATE TABLE GRUPS_UPLOAD (
  ID int(11) unsigned NOT NULL auto_increment,
  ECLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  END_TIME datetime NOT NULL default '0000-00-00 00:00:00',
  MODIFICAT datetime NOT NULL default '0000-00-00 00:00:00',
  NOM_GRUP varchar(255) NOT NULL default '',
  NOM_CARPETA varchar(255) NOT NULL default '',
  PERMISOS int(4) NOT NULL default '0',
  ORDRE int(11) NOT NULL default '0',
  PRIMARY KEY  (ID),
  KEY IDX_ECLASS (ECLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula USERS_GRUPS_UPLOAD
--

CREATE TABLE USERS_GRUPS_UPLOAD (
  USERLOGIN varchar(255) NOT NULL default '',
  ID_GRUP varchar(255) NOT NULL default '0',
  PRIMARY KEY  (USERLOGIN)
) TYPE=MyISAM;


-- --------------------------------------------------------
-- Newsletter
-- --------------------------------------------------------

CREATE TABLE BANNERS_NEWSLETTER (
  ID smallint(5) unsigned NOT NULL auto_increment,
  CLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START datetime NOT NULL default '0000-00-00 00:00:00',
  END datetime NOT NULL default '0000-00-00 00:00:00',
  TITOL varchar(250) default NULL,
  IMATGE varchar(255) default NULL,
  LINK varchar(250) default NULL,
  USUARI_HOUDINI varchar(255) default NULL,
  PRIMARY KEY  (ID),
  KEY IDX_CLASS (CLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) ENGINE=MyISAM;

CREATE TABLE CATEGORIES_NOTICIES (
  ID smallint(5) unsigned NOT NULL auto_increment,
  CLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START datetime NOT NULL default '0000-00-00 00:00:00',
  END datetime NOT NULL default '0000-00-00 00:00:00',
  TITOL varchar(250) default NULL,
  ORDRECAT int(11) NOT NULL default '0',
  COLOR varchar(50) default NULL,
  USUARI_HOUDINI varchar(255) default NULL,
  PRIMARY KEY  (ID),
  KEY IDX_CLASS (CLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) ENGINE=MyISAM;

INSERT INTO CATEGORIES_NOTICIES (ID, CLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START, END, TITOL, ORDRECAT, COLOR, USUARI_HOUDINI) VALUES
(1, 1, 0, 0, 0, 1, 1, '2007-06-20 15:52:19', '0000-00-00 00:00:00', '2008-06-20 23:59:59', '-------------', 1, '#F7F0E4', NULL);

CREATE TABLE NEWSLETTERS (
  ID smallint(5) unsigned NOT NULL auto_increment,
  CLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START datetime NOT NULL default '0000-00-00 00:00:00',
  END datetime NOT NULL default '0000-00-00 00:00:00',
  TITOL varchar(250) default NULL,
  IDNL int(11) default NULL,
  COD char(1) NOT NULL default 'C',
  DESCRIPCIO text,
  TITOL_DESCRIP varchar(250) default NULL,
  STAFF text,
  CONTACTE text,
  USUARI_HOUDINI varchar(255) default NULL,
  IdCam int(11) default NULL,
  PRIMARY KEY  (ID),
  KEY IDX_CLASS (CLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2),
  KEY IdCam (IdCam)
) ENGINE=MyISAM;

CREATE TABLE NOTICIES_NEWSLETTER (
  ID smallint(5) unsigned NOT NULL auto_increment,
  CLASS tinyint(2) unsigned NOT NULL default '0',
  SKIN tinyint(2) unsigned NOT NULL default '0',
  CATEGORY1 tinyint(2) unsigned NOT NULL default '0',
  CATEGORY2 tinyint(2) unsigned NOT NULL default '0',
  STATUS tinyint(2) unsigned NOT NULL default '0',
  VISIBILITY tinyint(2) unsigned NOT NULL default '0',
  CREATION datetime NOT NULL default '0000-00-00 00:00:00',
  START datetime NOT NULL default '0000-00-00 00:00:00',
  END datetime NOT NULL default '0000-00-00 00:00:00',
  TITOL varchar(250) default NULL,
  RESUM text,
  DESCRIPCIO text,
  NOMAD1 varchar(255) default NULL,
  NOMAD2 varchar(255) default NULL,
  NOMAD3 varchar(255) default NULL,
  NOMAD4 varchar(255) default NULL,
  NOMAD5 varchar(255) default NULL,
  ADJUNT1 varchar(255) default NULL,
  ADJUNT2 varchar(255) default NULL,
  ADJUNT3 varchar(255) default NULL,
  ADJUNT4 varchar(255) default NULL,
  ADJUNT5 varchar(255) default NULL,
  IMATGE1 varchar(255) default NULL,
  IMATGE2 varchar(255) default NULL,
  IMATGE3 varchar(255) default NULL,
  MESINFO int(11) NOT NULL default '0',
  LINK1 varchar(250) default NULL,
  LINK2 varchar(250) default NULL,
  NOM varchar(250) default NULL,
  CARREC varchar(250) default NULL,
  METATAGS text,
  LLOC varchar(255) default NULL,
  DATA_LLOC varchar(255) default NULL,
  SUBTITOL varchar(255) default NULL,
  MODEL int(11) NOT NULL default '0',
  USUARI_HOUDINI varchar(255) default NULL,
  PRIMARY KEY  (ID),
  KEY IDX_CLASS (CLASS),
  KEY IDX_CATEGORY1 (CATEGORY1),
  KEY IDX_CATEGORY2 (CATEGORY2)
) ENGINE=MyISAM;

CREATE TABLE TE_BAN_NL (
  ID_BAN smallint(5) unsigned NOT NULL default '0',
  ID_NL smallint(5) unsigned NOT NULL default '0',
  ORDRE int(11) default NULL,
  KEY IDX_ID_BAN (ID_BAN),
  KEY IDX_ID_NL (ID_NL)
) ENGINE=MyISAM;

CREATE TABLE TE_NNL_NL (
  ID_NNL smallint(5) unsigned NOT NULL default '0',
  ID_NL smallint(5) unsigned NOT NULL default '0',
  ORDRE int(11) default NULL,
  SECCIO int(11) default NULL,
  COF char(1) default NULL,
  KEY IDX_ID_NNL (ID_NNL),
  KEY IDX_ID_NL (ID_NL)
) ENGINE=MyISAM;


CREATE TABLE news_CAMPANYES (
  IdCam int(11) NOT NULL auto_increment,
  IdUsu varchar(20) NOT NULL default '',
  estat tinyint(3) unsigned NOT NULL default '0',
  tipus tinyint(4) unsigned NOT NULL default '0',
  dh_alta datetime NOT NULL default '0000-00-00 00:00:00',
  dh_modif datetime NOT NULL default '0000-00-00 00:00:00',
  titol varchar(150) NOT NULL default '',
  subject varchar(150) NOT NULL default '',
  from_name varchar(100) NOT NULL default '',
  from_email varchar(100) NOT NULL default '',
  reply_to varchar(100) NOT NULL default '',
  format tinyint(3) NOT NULL default '0',
  msg_text text NOT NULL,
  msg_html text NOT NULL,
  desti_llista varchar(150) NOT NULL default '',
  desti_manual text NOT NULL,
  afegir_link tinyint(3) unsigned NOT NULL default '0',
  email_notify varchar(100) NOT NULL default '',
  dh_inici datetime default NULL,
  dh_final datetime default NULL,
  notes text NOT NULL,
  PRIMARY KEY  (IdCam),
  KEY IdUsu (IdUsu),
  KEY estat (estat)
) ENGINE=MyISAM;

CREATE TABLE news_DESTINATARIS (
  IdCam int(11) NOT NULL default '0',
  email varchar(100) NOT NULL default '',
  IdUsu varchar(20) NOT NULL default '',
  IdLli int(11) NOT NULL default '0',
  estat tinyint(3) unsigned NOT NULL default '0',
  tipus tinyint(3) unsigned NOT NULL default '0',
  dh_enviament datetime default NULL,
  dh_recepcio datetime default NULL,
  nom varchar(150) NOT NULL default '',
  PRIMARY KEY  (IdCam,email),
  KEY IdUsu (IdUsu)
) ENGINE=MyISAM;

CREATE TABLE news_LLISTES (
  IdLli int(11) NOT NULL auto_increment,
  IdUsu varchar(20) NOT NULL default '',
  estat tinyint(3) unsigned NOT NULL default '0',
  tipus tinyint(3) unsigned NOT NULL default '0',
  dh_alta datetime NOT NULL default '0000-00-00 00:00:00',
  dh_modif datetime NOT NULL default '0000-00-00 00:00:00',
  titol varchar(150) NOT NULL default '',
  notes text NOT NULL,
  PRIMARY KEY  (IdLli),
  KEY IdUsu (IdUsu),
  KEY estat (estat)
) ENGINE=MyISAM;

CREATE TABLE news_SUBSCRIPTORS (
  IdSub int(11) NOT NULL auto_increment,
  IdUsu varchar(20) NOT NULL default '',
  IdLli int(11) NOT NULL default '0',
  estat tinyint(3) unsigned NOT NULL default '0',
  tipus tinyint(3) unsigned NOT NULL default '0',
  dh_alta datetime NOT NULL default '0000-00-00 00:00:00',
  dh_baixa datetime default NULL,
  email varchar(100) NOT NULL default '',
  nom varchar(150) NOT NULL default '',
  web varchar(150) NOT NULL default '',
  telefon1 varchar(20) NOT NULL default '',
  telefon2 varchar(20) NOT NULL default '',
  codipostal varchar(10) NOT NULL default '',
  adreca varchar(250) NOT NULL default '',
  poblacio varchar(150) NOT NULL default '',
  pais varchar(80) NOT NULL default '',
  notes varchar(250) NOT NULL default '',
  PRIMARY KEY  (IdSub),
  KEY IdUsu (IdUsu),
  KEY IdLli (IdLli),
  KEY email (email),
  KEY estat (estat)
) ENGINE=MyISAM;

-- --------------------------------------------------------
-- fi Newsletter
-- --------------------------------------------------------


--
-- Estructura de la taula VARIABLE
--

CREATE TABLE VARIABLE (
  NAME varchar(48) NOT NULL default '',
  VALUE longtext NOT NULL,
  PRIMARY KEY (NAME)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Estructura de la taula sessions
--

CREATE TABLE sessions (
  sid varchar(32) NOT NULL default '',
  hostname varchar(128) NOT NULL default '',
  timestamp int(11) NOT NULL default '0',
  session longtext,
  PRIMARY KEY (sid),
  KEY timestamp (timestamp)
) TYPE=MyISAM;

-- --------------------------------------------------------


INSERT INTO USERS (LOGIN, PASSWD, USERLEVEL, EXPIRATION, COMMENTS)
VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 5, '2015-10-10 00:00:00', '1');

INSERT INTO CARPETES (NOMCARPETA, DESCRIPCIO, CARPETAINICI)
VALUES ('home', 'Home', 1);

-- crear pàgina 404
INSERT INTO PLANTILLA (ID, NOM, DESCRIPCIO, PARE, ECLASS, SKIN, STATUS, VISIBILITY, CREATION, TEXTCURT, TEXTLLARG) VALUES
(1, 'plantilla_basica.html', 'Plantilla bàsica', 1, 1, 1, 1, 1, now(), 1, 1);
INSERT INTO PLANTILLA_DESC (PLANTILLA, TEXTC1, TEXTL1) VALUES (1, '|Titol|', '|Text|');

INSERT INTO ESTATICA (ID, NOMPAG, DESCRIPCIO, PARE, ECLASS, CREATION, USUARICREAR, USUARIMODI, IDIOMA, REFERENCIA, METATITOL, TEXTC1, TEXTL1, PLANTILLAID) VALUES
(1, '404.html', '404', 1, 1, now(), 'admin', 'admin', 'ca', 0, '404', 'Plana no trobada (Error 404)', '<p>Per alguna raó la pàgina que cerqueu no es troba al nostre servidor.</p>\r\n<ul>\r\n    <li>Si heu escrit l''adreça directament comproveu que sigui correcta.</li>\r\n    <li>Si proveniu d''algun motor de cerca, potser l''enllaç és massa antic i ja no existeix.</li>\r\n    <li>Potser senzillament l''arxiu ha estat esborrat.</li>\r\n</ul>', 1),
(2, 'es_404.html', '404', 1, 1, now(), 'admin', 'admin', 'es', 1, '404', '404', '', 1),
(3, 'en_404.html', '404', 1, 1, now(), 'admin', 'admin', 'en', 1, '404', '404', '', 1);
