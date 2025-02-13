<?php

  $servername = "mysql61.mydevil.net";
  $username = "m1352_ken";
  $password = "C052lR5wNlIbXtYn1@;y-P6yef9N@J";
  $dbname = "m1352_ken";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed.". $conn->connect_error);
  }
  
  // Set UTF-8 character set
  $conn->set_charset("utf8");
?>