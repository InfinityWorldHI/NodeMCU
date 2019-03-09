<?php
	//Connect to database
    $servername = "localhost";
    $username = "root";		//put your phpmyadmin username.(default is "root")
    $password = "";			//if your phpmyadmin has a password put it here.(default is "root")
    $dbname = "";
    
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Create database
	$sql = "CREATE DATABASE nodemculog";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	}

	echo "<br>";

	$dbname = "nodemculog";
    
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Sr No, Station, Status(OK, NM, WM, ACK) Date, Time
	//1         A          NM                 12-5-18    12:15:00 am
	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS `logs` (
  		`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  		`CardNumber` double DEFAULT NULL,
  		`Name` varchar(30) DEFAULT NULL,
  		`SerialNumber` double NOT NULL,
  		`DateLog` date DEFAULT NULL,
  		`TimeIn` time DEFAULT NULL,
  		`TimeOut` time DEFAULT NULL,
  		`UserStat` varchar(100) NOT NULL,
  		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=264";

	if ($conn->query($sql) === TRUE) {
	    echo "Table logs created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$sql = "CREATE TABLE IF NOT EXISTS `users` (
 		`id` int(11) NOT NULL AUTO_INCREMENT,
 		`username` varchar(100) NOT NULL,
 		`SerialNumber` double NOT NULL,
 		`gender` varchar(100) NOT NULL,
 		`CardID` double NOT NULL,
 		`CardID_select` tinyint(1) NOT NULL,
 		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58";

	if ($conn->query($sql) === TRUE) {
	    echo "Table users created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}
		
	$conn->close();
?>