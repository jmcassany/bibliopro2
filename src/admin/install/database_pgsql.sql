
BEGIN;

--
-- Estructura de la taula CARPETES
--

CREATE TABLE CARPETES (
  ID SERIAL,
  NOMCARPETA varchar(250) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  PARE integer NULL  DEFAULT NULL,

  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  IDIOMA char(2) default NULL,
  TITOL text,
  SUBTITOL varchar(250) DEFAULT NULL,
  APARTAT varchar(250) DEFAULT NULL,
  CATEGORIES text,
  INTRODUCCIO text,
  MENU1 varchar(150) NOT NULL DEFAULT '',
  MENU2 varchar(150) NOT NULL DEFAULT '',
  MENU3 varchar(150) NOT NULL DEFAULT '',
  BANNER1 varchar(150) NOT NULL DEFAULT '',
  BANNER2 varchar(150) NOT NULL DEFAULT '',
  BANNER3 varchar(150) NOT NULL DEFAULT '',
  RSS INT2  NOT NULL DEFAULT '0',
  CARPETAINICI INT2  NOT NULL DEFAULT '0',
  PRIMARY KEY (ID),
  CHECK (PARE>=0),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0),
  CHECK (RSS>=0)
);
--
-- Indexes for table CARPETES
--
CREATE UNIQUE INDEX NOMCARPETA_CARPETES_index ON CARPETES (NOMCARPETA,PARE);
CREATE INDEX IDX_ECLASS_CARPETES_index ON CARPETES (ECLASS);
CREATE INDEX IDX_CATEGORY1_CARPETES_index ON CARPETES (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_CARPETES_index ON CARPETES (CATEGORY2);




-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `CARPETES_IDIOMES`
--

CREATE TABLE CARPETES_IDIOMES (
  ID integer NOT NULL,
  IDIOMA char(2) NOT NULL,
  TITOL char(150) NOT NULL default '',
);
CREATE UNIQUE INDEX CARPETA_IDIOMA_index ON CARPETES_IDIOMES (ID,IDIOMA);

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estructura de la taula ESTATICA
--

CREATE TABLE ESTATICA (
  ID SERIAL,
  NOMPAG varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  PARE integer NOT NULL,

  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  IDIOMA char(2) default NULL,
  REFERENCIA integer NOT NULL default '0',
  METATITOL varchar(255) DEFAULT NULL,
  METADESCRIPCIO text,
  METAKEYS text,
  PLANTILLA varchar(100) NOT NULL DEFAULT '',
  MENU1 varchar(150) NOT NULL DEFAULT '',
  MENU2 varchar(150) NOT NULL DEFAULT '',
  MENU3 varchar(150) NOT NULL DEFAULT '',
  BANNER1 varchar(150) NOT NULL DEFAULT '',
  BANNER2 varchar(150) NOT NULL DEFAULT '',
  BANNER3 varchar(150) NOT NULL DEFAULT '',
  CERCADOR INT2 DEFAULT '0',
  TEXTC1 varchar(250) DEFAULT NULL,
  TEXTC2 varchar(250) DEFAULT NULL,
  TEXTC3 varchar(250) DEFAULT NULL,
  TEXTC4 varchar(250) DEFAULT NULL,
  TEXTC5 varchar(250) DEFAULT NULL,
  TEXTC6 varchar(250) DEFAULT NULL,
  TEXTC7 varchar(250) DEFAULT NULL,
  TEXTC8 varchar(250) DEFAULT NULL,
  TEXTC9 varchar(250) DEFAULT NULL,
  TEXTC10 varchar(250) DEFAULT NULL,
  TEXTC11 varchar(250) DEFAULT NULL,
  TEXTC12 varchar(250) DEFAULT NULL,
  TEXTC13 varchar(250) DEFAULT NULL,
  TEXTC14 varchar(250) DEFAULT NULL,
  TEXTC15 varchar(250) DEFAULT NULL,
  TEXTC16 varchar(250) DEFAULT NULL,
  TEXTC17 varchar(250) DEFAULT NULL,
  TEXTC18 varchar(250) DEFAULT NULL,
  TEXTC19 varchar(250) DEFAULT NULL,
  TEXTC20 varchar(250) DEFAULT NULL,
  TEXTC21 varchar(250) DEFAULT NULL,
  TEXTC22 varchar(250) DEFAULT NULL,
  TEXTC23 varchar(250) DEFAULT NULL,
  TEXTC24 varchar(250) DEFAULT NULL,
  TEXTC25 varchar(250) DEFAULT NULL,
  TEXTC26 varchar(250) DEFAULT NULL,
  TEXTC27 varchar(250) DEFAULT NULL,
  TEXTC28 varchar(250) DEFAULT NULL,
  TEXTC29 varchar(250) DEFAULT NULL,
  TEXTC30 varchar(250) DEFAULT NULL,
  TEXTC31 varchar(250) DEFAULT NULL,
  TEXTC32 varchar(250) DEFAULT NULL,
  TEXTC33 varchar(250) DEFAULT NULL,
  TEXTC34 varchar(250) DEFAULT NULL,
  TEXTC35 varchar(250) DEFAULT NULL,
  TEXTC36 varchar(250) DEFAULT NULL,
  TEXTC37 varchar(250) DEFAULT NULL,
  TEXTC38 varchar(250) DEFAULT NULL,
  TEXTC39 varchar(250) DEFAULT NULL,
  TEXTC40 varchar(250) DEFAULT NULL,
  TEXTC41 varchar(250) DEFAULT NULL,
  TEXTC42 varchar(250) DEFAULT NULL,
  TEXTC43 varchar(250) DEFAULT NULL,
  TEXTC44 varchar(250) DEFAULT NULL,
  TEXTC45 varchar(250) DEFAULT NULL,
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
  IMATGE1 varchar(100) DEFAULT NULL,
  IMATGE2 varchar(100) DEFAULT NULL,
  IMATGE3 varchar(100) DEFAULT NULL,
  IMATGE4 varchar(100) DEFAULT NULL,
  IMATGE5 varchar(100) DEFAULT NULL,
  IMATGE6 varchar(100) DEFAULT NULL,
  IMATGE7 varchar(100) DEFAULT NULL,
  IMATGE8 varchar(100) DEFAULT NULL,
  IMATGE9 varchar(100) DEFAULT NULL,
  IMATGE10 varchar(100) DEFAULT NULL,
  IMATGE11 varchar(100) DEFAULT NULL,
  IMATGE12 varchar(100) DEFAULT NULL,
  IMATGE13 varchar(100) DEFAULT NULL,
  IMATGE14 varchar(100) DEFAULT NULL,
  IMATGE15 varchar(100) DEFAULT NULL,
  IMATGE16 varchar(100) DEFAULT NULL,
  IMATGE17 varchar(100) DEFAULT NULL,
  IMATGE18 varchar(100) DEFAULT NULL,
  IMATGE19 varchar(100) DEFAULT NULL,
  IMATGE20 varchar(100) DEFAULT NULL,
  IMATGE21 varchar(100) DEFAULT NULL,
  IMATGE22 varchar(100) DEFAULT NULL,
  IMATGE23 varchar(100) DEFAULT NULL,
  IMATGE24 varchar(100) DEFAULT NULL,
  IMATGE25 varchar(100) DEFAULT NULL,
  ADJUNT1 varchar(100) DEFAULT NULL,
  ADJUNT2 varchar(100) DEFAULT NULL,
  ADJUNT3 varchar(100) DEFAULT NULL,
  ADJUNT4 varchar(100) DEFAULT NULL,
  ADJUNT5 varchar(100) DEFAULT NULL,
  ADJUNT6 varchar(100) DEFAULT NULL,
  ADJUNT7 varchar(100) DEFAULT NULL,
  ADJUNT8 varchar(100) DEFAULT NULL,
  ADJUNT9 varchar(100) DEFAULT NULL,
  ADJUNT10 varchar(100) DEFAULT NULL,
  ALT1 varchar(255) DEFAULT NULL,
  ALT2 varchar(255) DEFAULT NULL,
  ALT3 varchar(255) DEFAULT NULL,
  ALT4 varchar(255) DEFAULT NULL,
  ALT5 varchar(255) DEFAULT NULL,
  ALT6 varchar(255) DEFAULT NULL,
  ALT7 varchar(255) DEFAULT NULL,
  ALT8 varchar(255) DEFAULT NULL,
  ALT9 varchar(255) DEFAULT NULL,
  ALT10 varchar(255) DEFAULT NULL,
  PRIMARY KEY (ID),
  CHECK (PARE>=0),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
--
-- Indexes for table ESTATICA
--

CREATE UNIQUE INDEX NOMPAG_ESTATICA_index ON ESTATICA (NOMPAG,PARE);
CREATE INDEX IDX_ECLASS_ESTATICA_index ON ESTATICA (ECLASS);
CREATE INDEX IDX_CATEGORY1_ESTATICA_index ON ESTATICA (NOMPAG);
CREATE INDEX IDX_CATEGORY2_ESTATICA_index ON ESTATICA (DESCRIPCIO);

-- --------------------------------------------------------

--
-- Estructura de la taula DIN_CATEGORIES
--

CREATE TABLE DIN_CATEGORIES (
  ID SERIAL,
  NOM varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO TEXT NOT NULL DEFAULT '',
  IMATGE varchar(255) NOT NULL default '',
  PARE integer DEFAULT NULL,
  DINAMICA integer NOT NULL,
  ORDRE integer DEFAULT NULL,
  PRIMARY KEY (ID),
  CHECK (PARE>=0),
  CHECK (DINAMICA>=0)
);
CREATE UNIQUE INDEX NOM_DIN_CATEGORIES_index ON DIN_CATEGORIES (DINAMICA,PARE,NOM);

-- --------------------------------------------------------

--
-- Estructura de la taula FORMULARIS
--

CREATE TABLE FORMULARIS (
  ID SERIAL,
  NOMFORMULARI varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  PARE integer NOT NULL,

  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  IDIOMA char(2) NOT NULL DEFAULT '',
  METATITOL varchar(255) DEFAULT NULL,
  METADESCRIPCIO text,
  METAKEYS text,
  TITOLFORMULARI varchar(250) NOT NULL DEFAULT '',
  PLANTILLA varchar(250) NOT NULL DEFAULT '',
  MENU1 varchar(150) NOT NULL DEFAULT '',
  MENU2 varchar(150) NOT NULL DEFAULT '',
  MENU3 varchar(150) NOT NULL DEFAULT '',
  BANNER1 varchar(150) NOT NULL DEFAULT '',
  BANNER2 varchar(150) NOT NULL DEFAULT '',
  BANNER3 varchar(150) NOT NULL DEFAULT '',
  ACTION varchar(250) NOT NULL DEFAULT '',
  RECIPIENT varchar(250) NOT NULL DEFAULT '',
  REDIRECT varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (ID),
  CHECK (PARE>=0),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
--
-- Indexes for table FORMULARIS
--

CREATE UNIQUE INDEX NOMFORMULARI_FORMULARIS_index ON FORMULARIS (NOMFORMULARI,PARE);
CREATE INDEX IDX_ECLASS_FORMULARIS_index ON FORMULARIS (ECLASS);
CREATE INDEX IDX_CATEGORY1_FORMULARIS_index ON FORMULARIS (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_FORMULARIS_index ON FORMULARIS (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula FORMULARISITEMS
--

CREATE TABLE FORMULARISITEMS (
  ID SERIAL,
  TEXT varchar(100) NOT NULL DEFAULT '',
  NOM varchar(100) NOT NULL DEFAULT '',
  VALOR varchar(250) NOT NULL DEFAULT '',
  TIPO INT2 NOT NULL DEFAULT '0',
  TAMANY INT2 NOT NULL DEFAULT '0',
  ORDRE INT2 NOT NULL DEFAULT '0',
  OBLIGATORI INT2 NOT NULL DEFAULT '0',
  FORMULARI INT4 NOT NULL DEFAULT '0',
  PRIMARY KEY (ID)

);

-- --------------------------------------------------------

--
-- Estructura de la taula MENUS
--

CREATE TABLE MENUS (
  ID SERIAL,
  NOM varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  PARE integer NOT NULL,

  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  IDIOMA char(2) NOT NULL DEFAULT '',
  PLANTILLA varchar(100) NOT NULL DEFAULT '',
  TIPO INT2 NOT NULL DEFAULT '0',
  DESPLEGABLE INT2 NOT NULL DEFAULT '0',
  ESTIL varchar(100) NOT NULL DEFAULT '',
  ACCESSUBCARP INT2 NOT NULL DEFAULT '1',
  PRIMARY KEY (ID),
  CHECK (PARE>=0),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
--
-- Indexes for table MENUS
--

CREATE UNIQUE INDEX NOM_MENUS_index ON MENUS (NOM);
CREATE INDEX IDX_ECLASS_MENUS_index ON MENUS (ECLASS);
CREATE INDEX IDX_CATEGORY1_MENUS_index ON MENUS (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_MENUS_index ON MENUS (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula MENUITEMS
--

CREATE TABLE MENUITEMS (
  ID SERIAL,
  TEXT varchar(100) NOT NULL DEFAULT '',
  LINKPAGE varchar(100) NOT NULL DEFAULT '',
  FINESTRA varchar(250) NOT NULL DEFAULT '',
  IMATGE varchar(255) DEFAULT NULL,
  ORDRE INT2 NOT NULL DEFAULT '0',
  MENU INT4 NOT NULL DEFAULT '0',
  PRIMARY KEY (ID)

);

-- --------------------------------------------------------

--
-- Estructura de la taula MENUITEMSSUB
--

CREATE TABLE MENUITEMSSUB (
  ID SERIAL,
  TEXT1 varchar(250) NOT NULL DEFAULT '',
  LINKPAGE1 varchar(250) NOT NULL DEFAULT '',
  FINESTRA1 varchar(50) NOT NULL DEFAULT '',
  ORDRE INT2 NOT NULL DEFAULT '0',
  MENUITEM INT4 NOT NULL DEFAULT '0',
  PRIMARY KEY (ID)

);

-- --------------------------------------------------------

--
-- Estructura de la taula PLANTILLA
--

CREATE TABLE PLANTILLA (
  ID SERIAL,
  NOM varchar(255) DEFAULT NULL,
  DESCRIPCIO varchar(255) DEFAULT NULL,
  PARE integer NOT NULL,

  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  TEXTCURT INT2 NOT NULL DEFAULT '0',
  TEXTLLARG INT2 NOT NULL DEFAULT '0',
  IMATGES INT2 NOT NULL DEFAULT '0',
  ADJUNTS INT2 NOT NULL DEFAULT '0',
  IDIOMA char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (ID),
  CHECK (PARE>=0),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)

);

-- --------------------------------------------------------

--
-- Estructura de la taula PLANTILLA_DESC
--

CREATE TABLE PLANTILLA_DESC (
  ID SERIAL,
  PLANTILLA INT4 NOT NULL DEFAULT '0',
  TEXTC1 varchar(100) DEFAULT '|TEXTC1|',
  TEXTC2 varchar(100) DEFAULT '|TEXTC2|',
  TEXTC3 varchar(100) DEFAULT '|TEXTC3|',
  TEXTC4 varchar(100) DEFAULT '|TEXTC4|',
  TEXTC5 varchar(100) DEFAULT '|TEXTC5|',
  TEXTC6 varchar(100) DEFAULT '|TEXTC6|',
  TEXTC7 varchar(100) DEFAULT '|TEXTC7|',
  TEXTC8 varchar(100) DEFAULT '|TEXTC8|',
  TEXTC9 varchar(100) DEFAULT '|TEXTC9|',
  TEXTC10 varchar(100) DEFAULT '|TEXTC10|',
  TEXTC11 varchar(100) DEFAULT '|TEXTC11|',
  TEXTC12 varchar(100) DEFAULT '|TEXTC12|',
  TEXTC13 varchar(100) DEFAULT '|TEXTC13|',
  TEXTC14 varchar(100) DEFAULT '|TEXTC14|',
  TEXTC15 varchar(100) DEFAULT '|TEXTC15|',
  TEXTC16 varchar(100) DEFAULT '|TEXTC16|',
  TEXTC17 varchar(100) DEFAULT '|TEXTC17|',
  TEXTC18 varchar(100) DEFAULT '|TEXTC18|',
  TEXTC19 varchar(100) DEFAULT '|TEXTC19|',
  TEXTC20 varchar(100) DEFAULT '|TEXTC20|',
  TEXTC21 varchar(100) DEFAULT '|TEXTC21|',
  TEXTC22 varchar(100) DEFAULT '|TEXTC22|',
  TEXTC23 varchar(100) DEFAULT '|TEXTC23|',
  TEXTC24 varchar(100) DEFAULT '|TEXTC24|',
  TEXTC25 varchar(100) DEFAULT '|TEXTC25|',
  TEXTC26 varchar(100) DEFAULT '|TEXTC26|',
  TEXTC27 varchar(100) DEFAULT '|TEXTC27|',
  TEXTC28 varchar(100) DEFAULT '|TEXTC28|',
  TEXTC29 varchar(100) DEFAULT '|TEXTC29|',
  TEXTC30 varchar(100) DEFAULT '|TEXTC30|',
  TEXTC31 varchar(100) DEFAULT '|TEXTC31|',
  TEXTC32 varchar(100) DEFAULT '|TEXTC32|',
  TEXTC33 varchar(100) DEFAULT '|TEXTC33|',
  TEXTC34 varchar(100) DEFAULT '|TEXTC34|',
  TEXTC35 varchar(100) DEFAULT '|TEXTC35|',
  TEXTC36 varchar(100) DEFAULT '|TEXTC36|',
  TEXTC37 varchar(100) DEFAULT '|TEXTC37|',
  TEXTC38 varchar(100) DEFAULT '|TEXTC38|',
  TEXTC39 varchar(100) DEFAULT '|TEXTC39|',
  TEXTC40 varchar(100) DEFAULT '|TEXTC40|',
  TEXTC41 varchar(100) DEFAULT '|TEXTC41|',
  TEXTC42 varchar(100) DEFAULT '|TEXTC42|',
  TEXTC43 varchar(100) DEFAULT '|TEXTC43|',
  TEXTC44 varchar(100) DEFAULT '|TEXTC44|',
  TEXTC45 varchar(100) DEFAULT '|TEXTC45|',
  TEXTL1 varchar(100) DEFAULT '|TEXTL1|',
  TEXTL2 varchar(100) DEFAULT '|TEXTL2|',
  TEXTL3 varchar(100) DEFAULT '|TEXTL3|',
  TEXTL4 varchar(100) DEFAULT '|TEXTL4|',
  TEXTL5 varchar(100) DEFAULT '|TEXTL5|',
  TEXTL6 varchar(100) DEFAULT '|TEXTL6|',
  TEXTL7 varchar(100) DEFAULT '|TEXTL7|',
  TEXTL8 varchar(100) DEFAULT '|TEXTL8|',
  TEXTL9 varchar(100) DEFAULT '|TEXTL9|',
  TEXTL10 varchar(100) DEFAULT '|TEXTL10|',
  IMATGE1 varchar(100) DEFAULT '|IMATGE1|',
  IMATGE2 varchar(100) DEFAULT '|IMATGE2|',
  IMATGE3 varchar(100) DEFAULT '|IMATGE3|',
  IMATGE4 varchar(100) DEFAULT '|IMATGE4|',
  IMATGE5 varchar(100) DEFAULT '|IMATGE5|',
  IMATGE6 varchar(100) DEFAULT '|IMATGE6|',
  IMATGE7 varchar(100) DEFAULT '|IMATGE7|',
  IMATGE8 varchar(100) DEFAULT '|IMATGE8|',
  IMATGE9 varchar(100) DEFAULT '|IMATGE9|',
  IMATGE10 varchar(100) DEFAULT '|IMATGE10|',
  IMATGE11 varchar(100) DEFAULT '|IMATGE11|',
  IMATGE12 varchar(100) DEFAULT '|IMATGE12|',
  IMATGE13 varchar(100) DEFAULT '|IMATGE13|',
  IMATGE14 varchar(100) DEFAULT '|IMATGE14|',
  IMATGE15 varchar(100) DEFAULT '|IMATGE15|',
  IMATGE16 varchar(100) DEFAULT '|IMATGE16|',
  IMATGE17 varchar(100) DEFAULT '|IMATGE17|',
  IMATGE18 varchar(100) DEFAULT '|IMATGE18|',
  IMATGE19 varchar(100) DEFAULT '|IMATGE19|',
  IMATGE20 varchar(100) DEFAULT '|IMATGE20|',
  IMATGE21 varchar(100) DEFAULT '|IMATGE21|',
  IMATGE22 varchar(100) DEFAULT '|IMATGE22|',
  IMATGE23 varchar(100) DEFAULT '|IMATGE23|',
  IMATGE24 varchar(100) DEFAULT '|IMATGE24|',
  IMATGE25 varchar(100) DEFAULT '|IMATGE25|',
  ADJUNT1 varchar(100) DEFAULT '|ADJUNT1|',
  ADJUNT2 varchar(100) DEFAULT '|ADJUNT2|',
  ADJUNT3 varchar(100) DEFAULT '|ADJUNT3|',
  ADJUNT4 varchar(100) DEFAULT '|ADJUNT4|',
  ADJUNT5 varchar(100) DEFAULT '|ADJUNT5|',
  ADJUNT6 varchar(100) DEFAULT '|ADJUNT6|',
  ADJUNT7 varchar(100) DEFAULT '|ADJUNT7|',
  ADJUNT8 varchar(100) DEFAULT '|ADJUNT8|',
  ADJUNT9 varchar(100) DEFAULT '|ADJUNT9|',
  ADJUNT10 varchar(100) DEFAULT '|ADJUNT10|',
  ALT1 varchar(255) DEFAULT '|ALT1|',
  ALT2 varchar(255) DEFAULT '|ALT2|',
  ALT3 varchar(255) DEFAULT '|ALT3|',
  ALT4 varchar(255) DEFAULT '|ALT4|',
  ALT5 varchar(255) DEFAULT '|ALT5|',
  ALT6 varchar(255) DEFAULT '|ALT6|',
  ALT7 varchar(255) DEFAULT '|ALT7|',
  ALT8 varchar(255) DEFAULT '|ALT8|',
  ALT9 varchar(255) DEFAULT '|ALT9|',
  ALT10 varchar(255) DEFAULT '|ALT10|',
  PRIMARY KEY (ID)
);
--
-- Indexes for table PLANTILLA_DESC
--

CREATE UNIQUE INDEX PLANTILLA_PLANTILLA_DESC_index ON PLANTILLA_DESC (PLANTILLA);

-- --------------------------------------------------------

--
-- Estructura de la taula REGISTRE
--

CREATE TABLE REGISTRE (
  DATA TIMESTAMP NOT NULL,
  LOGIN char(25) NOT NULL DEFAULT '',
  IP char(20) NOT NULL DEFAULT '',
  ACTION varchar(150) NOT NULL DEFAULT '',
  DESCRIPTION text NOT NULL DEFAULT ''
);

--
-- Indexes for table REGISTRE
--

CREATE INDEX IDX_LOGIN_REGISTRE_index ON REGISTRE (LOGIN);
CREATE INDEX IDX_DATA_REGISTRE_index ON REGISTRE (DATA);

-- --------------------------------------------------------

--
-- Estructura de la taula USERS
--

CREATE TABLE USERS (
  LOGIN varchar(15) NOT NULL,
  PASSWD varchar(64) NOT NULL,
  USERLEVEL INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  EXPIRATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  EMAIL varchar(100) DEFAULT NULL,
  REALNAME varchar(250) default NULL,
  TELEPHONE varchar(15) DEFAULT NULL,
  COMMENTS text,
  PRIMARY KEY (LOGIN),
  CHECK (USERLEVEL>=0),
  CHECK (STATUS>=0)
);
--
-- Indexes for table USERS
--

CREATE UNIQUE INDEX IDX_LOGIN_USERS_index ON USERS (LOGIN);
CREATE INDEX IDX_USERLEVEL_USERS_index ON USERS (USERLEVEL);

-- --------------------------------------------------------

--
-- Estructura de la taula BANNERS
--

CREATE TABLE BANNERS (
  ID SERIAL,
  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  NOM varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  TIPO INT2 NOT NULL DEFAULT '0',
  TEXT text,
  CAIXETES INT4 NOT NULL DEFAULT '4',
  PRIMARY KEY (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
--
-- Indexes for table BANNERS
--

CREATE UNIQUE INDEX NOM_BANNERS_index ON BANNERS (NOM);
CREATE INDEX IDX_ECLASS_BANNERS_index ON BANNERS (ECLASS);
CREATE INDEX IDX_CATEGORY1_BANNERS_index ON BANNERS (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_BANNERS_index ON BANNERS (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula CAIXETES
--

CREATE TABLE CAIXETES (
  ID SERIAL,
  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  NOM varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  TIPO INT2 NOT NULL DEFAULT '0',
  TITOL varchar(255) DEFAULT NULL,
  TEXT text,
  LINKC varchar(255) DEFAULT NULL,
  FINESTRA INT2 NOT NULL DEFAULT '0',
  IMATGE varchar(250) DEFAULT NULL,
  IMATGE_ALTERNATIVA varchar(250) NOT NULL DEFAULT '',
  WIDTH INT4  NOT NULL DEFAULT '0',
  HEIGHT INT4  NOT NULL DEFAULT '0',
  PRIMARY KEY (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0),
  CHECK (WIDTH>=0),
  CHECK (HEIGHT>=0)
);
--
-- Indexes for table CAIXETES
--

CREATE UNIQUE INDEX NOM_CAIXETES_index ON CAIXETES (NOM);
CREATE INDEX IDX_ECLASS_CAIXETES_index ON CAIXETES (ECLASS);
CREATE INDEX IDX_CATEGORY1_CAIXETES_index ON CAIXETES (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_CAIXETES_index ON CAIXETES (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula VIEWRSS
--

CREATE TABLE VIEWRSS (
  ID SERIAL,
  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  start_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  end_time TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  NOM varchar(50) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  LINKRSS varchar(255) DEFAULT NULL,
  MAXRSS INT2 NOT NULL DEFAULT '0',
  PLANTILLA varchar(255) DEFAULT NULL,
  PRIMARY KEY (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
--
-- Indexes for table VIEWRSS
--

CREATE UNIQUE INDEX NOM_VIEWRSS_index ON VIEWRSS (NOM);
CREATE INDEX IDX_ECLASS_VIEWRSS_index ON VIEWRSS (ECLASS);
CREATE INDEX IDX_CATEGORY1_VIEWRSS_index ON VIEWRSS (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_VIEWRSS_index ON VIEWRSS (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula ENQUESTA
--

CREATE TABLE ENQUESTA (
  ID SERIAL,
  ECLASS INT2 NOT NULL default '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  START_TIME TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  END_TIME TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  NOM varchar(50) NOT NULL default '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  PLANTILLA varchar(255) default NULL,
  TITOL varchar(250) default NULL,
  PRIMARY KEY  (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
CREATE UNIQUE INDEX NOM_ENQUESTA_index ON ENQUESTA (NOM);
CREATE INDEX IDX_ECLASS_ENQUESTA_index ON ENQUESTA (ECLASS);
CREATE INDEX IDX_CATEGORY1_ENQUESTA_index ON ENQUESTA (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_ENQUESTA_index ON ENQUESTA (CATEGORY2);


-- --------------------------------------------------------

--
-- Estructura de la taula ENQUESTA_PREG
--

CREATE TABLE ENQUESTA_PREG (
  ID SERIAL,
  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  START_TIME TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  END_TIME TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  USUARICREAR varchar(255) NOT NULL DEFAULT '',
  USUARIMODI varchar(255) NOT NULL DEFAULT '',
  DESCRIPCIO varchar(255) DEFAULT NULL,
  VOTS INT2 NOT NULL default '0',
  ENQUESTA INT2 NOT NULL default '0',
  PRIMARY KEY  (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
CREATE INDEX IDX_ECLASS_ENQUESTA_PREG_index ON ENQUESTA_PREG (ECLASS);
CREATE INDEX IDX_ENQUESTA_ENQUESTA_PREG_index ON ENQUESTA_PREG (ENQUESTA);
CREATE INDEX IDX_CATEGORY1_ENQUESTA_PREG_index ON ENQUESTA_PREG (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_ENQUESTA_PREG_index ON ENQUESTA_PREG (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula GRUPS_UPLOAD
--

CREATE TABLE GRUPS_UPLOAD (
  ID SERIAL,
  ECLASS INT2  NOT NULL DEFAULT '0',
  SKIN INT2  NOT NULL DEFAULT '0',
  CATEGORY1 INT2  NOT NULL DEFAULT '0',
  CATEGORY2 INT2  NOT NULL DEFAULT '0',
  STATUS INT2  NOT NULL DEFAULT '0',
  VISIBILITY INT2  NOT NULL DEFAULT '0',
  CREATION TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  START_TIME TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  END_TIME TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',
  MODIFICAT TIMESTAMP NOT NULL DEFAULT '0001-01-01 00:00:00',

  NOM_GRUP varchar(255) NOT NULL DEFAULT '',
  NOM_CARPETA varchar(255) NOT NULL DEFAULT '',

  PERMISOS INT2 NOT NULL default '0',
  ORDRE INT2 NOT NULL default '0',
  PRIMARY KEY  (ID),
  CHECK (ECLASS>=0),
  CHECK (SKIN>=0),
  CHECK (CATEGORY1>=0),
  CHECK (CATEGORY2>=0),
  CHECK (STATUS>=0),
  CHECK (VISIBILITY>=0)
);
CREATE INDEX IDX_ECLASS_GRUPS_UPLOAD_index ON GRUPS_UPLOAD (ECLASS);
CREATE INDEX IDX_ENQUESTA_GRUPS_UPLOAD_index ON GRUPS_UPLOAD (ENQUESTA);
CREATE INDEX IDX_CATEGORY1_GRUPS_UPLOAD_index ON GRUPS_UPLOAD (CATEGORY1);
CREATE INDEX IDX_CATEGORY2_GRUPS_UPLOAD_index ON GRUPS_UPLOAD (CATEGORY2);

-- --------------------------------------------------------

--
-- Estructura de la taula USERS_GRUPS_UPLOAD
--

CREATE TABLE USERS_GRUPS_UPLOAD (
  USERLOGIN varchar(255) NOT NULL default '',
  ID_GRUP varchar(255) NOT NULL default '',
  PRIMARY KEY  (USERLOGIN)
);


-- --------------------------------------------------------

--
-- Estructura de la taula VARIABLE
--

CREATE TABLE VARIABLE (
  NAME varchar(48) NOT NULL default '',
  VALUE text NOT NULL default '',
  PRIMARY KEY  (name)
);

-- --------------------------------------------------------

--
-- Estructura de la taula sessions
--

CREATE TABLE sessions (
  sid varchar(32) NOT NULL default '',
  hostname varchar(128) NOT NULL default '',
  timestamp integer NOT NULL default '0',
  session text,
  PRIMARY KEY (sid)
);

-- --------------------------------------------------------


INSERT INTO USERS (LOGIN, PASSWD, USERLEVEL, EXPIRATION, COMMENTS)
VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 5, '2015-10-10 00:00:00', '1');

INSERT INTO CARPETES (NOMCARPETA, DESCRIPCIO, CARPETAINICI)
VALUES ('home', 'Home', 1);


COMMIT;
