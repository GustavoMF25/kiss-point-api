<?php

/* Mysql */
$schemaBase = "heroku_926533faaab0bcc";
$con = mysqli_connect("us-cdbr-east-05.cleardb.net", "b4608a9a4b133c", "f521d32a", $schemaBase);

$sql = "SET NAMES 'utf8'";
mysqli_query($con, $sql);

$sql = 'SET character_set_connection=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_client=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_results=utf8';
$res = mysqli_query($con, $sql);
