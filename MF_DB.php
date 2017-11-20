<?php
Class MF_DB{
    function __construct() {
        //parent::__construct();

		$host = "localhost";
		$user = "root";
		$pass = "";
		$db   = "test";
		$this->con = mysqli_connect($host,$user,$pass,$db);
		if(!$this->con){
			die("Error: Unable to connect to MySQL ".mysqli_connect_error());
		}
        
    }


//Database config Start here
	public function add($table,$data){
		$fild_value = array();
		foreach ($data as $field => $value) {
			$fild_value[] = "`".$field."` = '".$value."'";
		}
		$data_string = implode(",", $fild_value);

		$sql = "INSERT INTO `$table` SET ".$data_string;
		
		$query = mysqli_query($this->con,$sql);
		if($query){
			return true;
		}else{
			return mysqli_error($this->con);
		}
	}

	public function update($table,$data,$where=1){
		$where_string = $this->get_where($where);
		$fild_value = array();
		foreach ($data as $field => $value) {
			$fild_value[] = "`".$field."` = '".$value."'";
		}
		$data_string = implode(",", $fild_value);

		$sql = "UPDATE `$table` SET ".$data_string." WHERE ".$where_string;
		
		$query = mysqli_query($this->con,$sql);
		if($query){
			return true;
		}else{
			return mysqli_error($this->con);
		}
	}

	public function read($table,$where = 1){
		$where_string = $this->get_where($where);

		$sql = "SELECT * FROM `$table` WHERE ".$where_string;
		
		$query = mysqli_query($this->con,$sql);
		if($query){
			$datas = array();
			while($data = mysqli_fetch_assoc($query)){
				$datas[] = (object)$data;
			}
			return $datas;
		}else{
			return mysqli_error($this->con);
		}
	}


	public function query($sql){
		$query = mysqli_query($this->con,$sql);
		if($query){
			$datas = array();
			while($data = mysqli_fetch_assoc($query)){
				$datas[] = (object)$data;
			}
			return $datas;
		}else{
			return mysqli_error($this->con);
		}
	}

/*
Generate Where String
Created to internal use
*/
	private function get_where($where){
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
}