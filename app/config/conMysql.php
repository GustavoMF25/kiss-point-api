<?php

/* Mysql */
$schemaBase = "emegygxj_get_point";
$con = mysqli_connect("15.235.9.101", "emegygxj_user_admin", "admin@123qwe**", $schemaBase);

$sql = "SET NAMES 'utf8'";
mysqli_query($con, $sql);

$sql = 'SET character_set_connection=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_client=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_results=utf8';
$res = mysqli_query($con, $sql);
