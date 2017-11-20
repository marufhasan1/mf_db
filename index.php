<?php
include_once "MF_DB.php";

$where = array(
	"catetory" => "Cement"
);

$mfdb = new MF_DB();
print_r($mfdb->read("stock"));