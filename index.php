<?php
include_once "MF_DB.php";
/*This is index*/
$where = array(
	"catetory" => "Cement"
);

$where = array("id" => 1);
$r = $db->read_test();
print_r($r);
echo "<hr/>";
print_r($db->test_red());

