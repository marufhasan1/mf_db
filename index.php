<?php
include_once "MF_DB.php";

$where = array(
	"catetory" => "Cement"
);

$where = array("id" => 1);
$r = $db->read("select* from stock");
print_r($r);
