-- MySQL dump 9.11
--
-- Host: localhost    Database: potluck
-- ------------------------------------------------------
-- Server version	4.0.27-nt

--
-- Table structure for table `potluckevents`
--

CREATE TABLE potluckevents (
  EventID int(11) NOT NULL auto_increment,
  Title varchar(64) NOT NULL default '',
  Welcome varchar(255) NOT NULL default '',
  PRIMARY KEY  (EventID)
) TYPE=MyISAM;

--
-- Dumping data for table `potluckevents`
--

INSERT INTO potluckevents VALUES (1,'Potluck dish signup','Welcome! Mark will be holding a potluck at his house at 5:00pm on Wednesday, July 4, 2007. Location: 4513 Gregg Rd, Madison, 53705; phone: 608-233-5837.');

--
-- Table structure for table `potluckpersondish`
--

CREATE TABLE potluckpersondish (
  ID int(11) NOT NULL auto_increment,
  EventID int(11) default NULL,
  Person varchar(64) NOT NULL default '',
  Dish varchar(255) NOT NULL default '',
  LastUpdated datetime default NULL,
  PRIMARY KEY  (ID)
) TYPE=MyISAM;

--
-- Dumping data for table `potluckpersondish`
--

INSERT INTO potluckpersondish VALUES (1,NULL,'Mark','Burgers and veggie burgers, condiments, and buns','2007-06-23 19:00:46');

