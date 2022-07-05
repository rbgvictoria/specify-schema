SET @db='melisr';
USE melisr;

DROP TABLE IF EXISTS spschema_table;
CREATE TABLE spschema_table (
  TableID integer unsigned auto_increment not null,
  TableName varchar(64),
  primary key (TableID),
  index (TableName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS spschema_field;
CREATE TABLE  spschema_field (
  FieldID int(10) unsigned AUTO_INCREMENT NOT NULL,
  TableName varchar(64) DEFAULT NULL,
  TableID int(11) DEFAULT NULL,
  FieldName varchar(64) DEFAULT NULL,
  FieldType varchar(32) DEFAULT NULL,
  IsNullable varchar(4) DEFAULT NULL,
  FieldKey varchar(16) DEFAULT NULL,
  Extra varchar(64) DEFAULT NULL,
  PRIMARY KEY (FieldID),
  INDEX (TableName),
  INDEX (FieldName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS spschema_index;
CREATE TABLE  spschema_index (
  IndexID int(10) unsigned AUTO_INCREMENT NOT NULL,
  TableName varchar(64) DEFAULT NULL,
  TableID int(10) unsigned NOT NULL,
  Non_unique tinyint(1) DEFAULT NULL,
  Key_name varchar(64) DEFAULT NULL,
  Seq_in_index int(1) DEFAULT NULL,
  ColumnName varchar(64) DEFAULT NULL,
  ColumnID int(10) unsigned DEFAULT NULL,
  `Collation` char(1) DEFAULT NULL,
  Cardinality int(11) DEFAULT NULL,
  IsNullable varchar(4) DEFAULT NULL,
  Index_type varchar(10) DEFAULT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (IndexID),
  KEY TableID (TableID),
  KEY ColumnName (ColumnName),
  KEY ColumnID (ColumnID),
  KEY Key_name (Key_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS spschema_relationship;
CREATE TABLE  spschema_relationship (
  RelationshipID int(10) unsigned AUTO_INCREMENT NOT NULL,
  RelationshipName varchar(64) DEFAULT NULL,
  FromTableName varchar(64) DEFAULT NULL,
  FromTableID int(10) unsigned NOT NULL,
  FromColumnName varchar(64) DEFAULT NULL,
  FromColumnID int(10) unsigned DEFAULT NULL,
  ToTableName varchar(64) DEFAULT NULL,
  ToTableID int(10) unsigned DEFAULT NULL,
  ToColumnName varchar(64) DEFAULT NULL,
  ToColumnID int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (RelationshipID),
  KEY FromTableName (FromTableName),
  KEY FromTableID (FromTableID),
  KEY ToTableName (ToTableName),
  KEY ToTableID (ToTableID),
  KEY FromColumnName (FromColumnName),
  KEY FromColumnID (FromColumnID),
  KEY ToColumnName (ToColumnName),
  KEY ToColumnID (ToColumnID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO spschema_table (TableName)
SELECT TABLE_NAME
FROM information_schema.`TABLES`
WHERE TABLE_SCHEMA=@db;

INSERT INTO spschema_field (TableID, TableName, FieldName, isNullable, FieldType, FieldKey)
SELECT t.TableID, c.TABLE_NAME, c.COLUMN_NAME, c.IS_NULLABLE, c.COLUMN_TYPE, c.COLUMN_KEY
FROM information_schema.`COLUMNS` c
JOIN spschema_table t ON c.TABLE_NAME=t.TableName
WHERE TABLE_SCHEMA=@db;

INSERT INTO spschema_index (TableID, TableName, Key_name, Non_unique, Seq_in_index, ColumnID, ColumnName, Index_type, Cardinality, IsNullable)
SELECT f.TableID, s.TABLE_NAME, s.INDEX_NAME, s.NON_UNIQUE, s.SEQ_IN_INDEX, f.FieldID, s.COLUMN_NAME, s.INDEX_TYPE, s.CARDINALITY, s.NULLABLE
FROM information_schema.STATISTICS s
JOIN spschema_field f ON s.TABLE_NAME=f.TableName AND s.COLUMN_NAME=f.FieldName
WHERE s.TABLE_SCHEMA=@db;

INSERT INTO spschema_relationship (RelationshipName, FromTableName, FromTableID, FromColumnName, FromColumnID,
  ToTableName, ToTableID, ToColumnName, ToColumnID)
SELECT k.CONSTRAINT_NAME, k.TABLE_NAME, ff.TableID, k.COLUMN_NAME, ff.FieldID,
  k.REFERENCED_TABLE_NAME, ft.TableID, k.REFERENCED_COLUMN_NAME, ft.FieldID
FROM information_schema.KEY_COLUMN_USAGE k
JOIN spschema_field ff ON k.TABLE_NAME=ff.TableName AND k.COLUMN_NAME=ff.FieldName
JOIN spschema_field ft ON k.REFERENCED_TABLE_NAME=ft.TableName AND k.REFERENCED_COLUMN_NAME=ft.FieldName
WHERE k.TABLE_SCHEMA=@db;