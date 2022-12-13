<?php

/* Mysql */
// Base de dados invisível
$schemaBase = "emegygxj_get_point";
$con = mysqli_connect($host, $user, $senha, $schemaBase);

$sql = "SET NAMES 'utf8'";
mysqli_query($con, $sql);

$sql = 'SET character_set_connection=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_client=utf8';
mysqli_query($con, $sql);

$sql = 'SET character_set_results=utf8';
$res = mysqli_query($con, $sql);
