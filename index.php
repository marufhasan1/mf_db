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
print_r($db->get_max("accountt","id"));

echo "</pre>";

