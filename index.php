<?php
include_once "MF_DB.php";
/*This is index*/
$where = array(
	"catetory" => "Cement"
);

//$where = array("memberId" => "PR116JOB0001");
$where = array();
$order = array("id" => "DESC");
$r = $db->read_test("account","id,opening_date,memberId",$where,$order,"opening_date",1);
echo "<pre>";
print_r($r);
echo "<hr/>";
print_r($db->test_red());
echo "<hr/>";
$max = $db->get_max("account","id");
$min = $db->get_min("account","id");
print_r($max);
print_r($min);
echo "<hr/>";
$distinct = $db->get_distinct("account","id");
print_r($distinct);
echo "</pre>";