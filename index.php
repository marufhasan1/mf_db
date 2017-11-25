<?php
include_once "MF_DB.php";

$where = array(
	"catetory" => "Cement"
);

$where = array("id" => 1);
$r = $db->read("admission",$where);
print_r($r);
