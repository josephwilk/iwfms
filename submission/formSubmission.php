<?php
include('../includes/config/database.php');
include_once('../includes/library/library_db_mysql.php');
include_once('../includes/library/library_arrays.php');

$table= 'text1';
$field='text1';
$key= 'text1id';

$updatearray['workflowId']= 1;
$updatearray[$field]= $$field;

dbs::irrecord($table,$updatearray,false);
dbs::updaterecord($table,$updatearray,$key,$keyvalue);

header("Location: ../mockup/index.php");

?>