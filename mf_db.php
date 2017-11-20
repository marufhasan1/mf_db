<?php

//Database config Start here
function db_add($con,$table,$data){
	$fild_value = array();
	foreach ($data as $field => $value) {
		$fild_value[] = "`".$field."` = '".$value."'";
	}
	$data_string = implode(",", $fild_value);

	$sql = "INSERT INTO `$table` SET ".$data_string;
	
	$query = mysqli_query($con,$sql);
	if($query){
		return true;
	}else{
		return mysqli_error($con);
	}
}

function db_update($con,$table,$data,$where=1){
	$where_string = get_where($where);
	$fild_value = array();
	foreach ($data as $field => $value) {
		$fild_value[] = "`".$field."` = '".$value."'";
	}
	$data_string = implode(",", $fild_value);

	$sql = "UPDATE `$table` SET ".$data_string." WHERE ".$where_string;
	
	$query = mysqli_query($con,$sql);
	if($query){
		return true;
	}else{
		return mysqli_error($con);
	}
}

function db_read($con,$table,$where = 1){
	$where_string = get_where($where);

	$sql = "SELECT * FROM `$table` WHERE ".$where_string;
	
	$query = mysqli_query($con,$sql);
	if($query){
		$datas = array();
		while($data = mysqli_fetch_assoc($query)){
			$datas[] = (object)$data;
		}
		return $datas;
	}else{
		return mysqli_error($con);
	}
}


function db_query($con,$sql){
	$query = mysqli_query($con,$sql);
	if($query){
		$datas = array();
		while($data = mysqli_fetch_assoc($query)){
			$datas[] = (object)$data;
		}
		return $datas;
	}else{
		return mysqli_error($con);
	}
}

/*
Generate Where String
Created to internal use
*/
function get_where($where){
	if(is_array($where)){
		$fild_value = array();
		foreach ($where as $field => $value) {
			if(preg_match("/ >=/i", $field)||preg_match("/ <=/i", $field)||preg_match("/ </i", $field)||preg_match("/ >/i", $field)||preg_match("/ !=/i", $field)){
				$fild_value[] = "`".$field."` '".$value."'";
			}else{
				$fild_value[] = "`".$field."` = '".$value."'";
			}
		}
		return implode(" and ", $fild_value);
	}else{
		return $where;
	}
}


//Database config End here