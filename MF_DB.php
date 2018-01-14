<?php
Class MF_DB{

	private $con;
	//SQL Property Start
	private $select = "*";
    private $where = null;
    private $sql = "";
    private $query = null;
    private $order_by = null;
    private $group_by = null;
    private $limit = null;
    private $offset = null;
	//SQL Property End

    function __construct() {
        //parent::__construct();
    	//Database Connection Start here
		$host = "localhost";
		$user = "root";
		$pass = "";
		$db   = "test";
		$this->con = mysqli_connect($host,$user,$pass,$db);

		if(!$this->con){
			die("Error: Unable to connect to MySQL " . mysqli_connect_error());
		}
    	//Database Connection End here
    }
    
    function reset_sql_prop(){
		$this->select = "*";
    	$this->where = null;
    	$this->sql = "";
    	$this->query = null;
    	$this->order_by = null;
    	$this->group_by = null;
    	$this->limit = null;
    	$this->offset = null;
    }

//Database config Start here
    /*
	public function add($table,$data){
		$data_string = $this->get_data($data);
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
		$data_string = $this->get_data($data);
		$sql = "UPDATE `$table` SET ".$data_string." WHERE ".$where_string;
		
		$query = mysqli_query($this->con,$sql);
		if($query){
			return true;
		}else{
			return mysqli_error($this->con);
		}
	}
	*/
/*
	public function read($table,$where = null,$order_by = null,$order_type = null){
		$where_string = $this->get_where($where);

		$sql = "SELECT * FROM `$table`";
		if($where!=null){
			$sql.= " WHERE ".$where_string;
		}
		if($order_by!=null){
			$sql.= " ORDER BY `".$order_by."` ".$order_type;
		}
		//echo $sql;
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
*/
	public function read_test($table,$select,$where = array(),$order_by,$group_by,$limit=null,$offset=null){
		$this->select($select);
		$this->group_by($group_by);
		$this->where($where);
		$this->order_by($order_by);
		$this->limit($limit,$offset);

		return $this->get($table)->result();
	}

	public function test_red(){
		return $this->get("account")->result();
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

/*
	private function get_data($data){
		$fild_value = array();
		foreach ($data as $field => $value) {
			$fild_value[] = "`".$field."` = '".$value."'";
		}
		return implode(",", $fild_value);
	}
*/

	//The Query will build in get function
	private function get($table){
		$this->sql = "SELECT " . $this->select . " FROM "; //Initialize the SQL
		$this->sql.=" `".$table."`"; // concatenate the table name

		if($this->where != null){// concatenate the where string name
			$this->sql.=" WHERE ".$this->where;
		}

		if($this->group_by != null){// concatenate the order by string name
			$this->sql.=" GROUP BY ".$this->group_by;
		}

		if($this->order_by != null){// concatenate the order by string name
			$this->sql.=" ORDER BY ".$this->order_by;
		}

		if($this->limit != null){// concatenate the LIMIT number
			$this->sql.=" LIMIT ".$this->limit;
		}

		if($this->limit != null && $this->offset != null){// concatenate the offset number
			$this->sql.=" OFFSET ".$this->offset;
		}

		$this->query = mysqli_query($this->con,$this->sql);
		return $this;
	}

	private function result(){
		if($this->query){
			$datas = array();
			while($data = mysqli_fetch_assoc($this->query)){
				$datas[] = (object)$data;
			}
			$this->reset_sql_prop();
			return $datas;
		}else{
			$this->reset_sql_prop();
			return mysqli_error($this->con);
		}
	}

//Set Query condition Start here [Step: Set Query condition Start here]
	private function select($c_name){ //column name can be single column name or multiple with comma seperator
		$this->select = $c_name;
	}

	private function where($where){ //$where as array or complete where string
		$this->where = $this->gen_where($where);
	}

	private function group_by($column){
		$this->group_by = $column;
	}

	private function order_by($order){//$order as array key = column Name and value = order Type
		$o_array = array();
		if(count($order)>0){
			foreach ($order as $column => $type) {
				$o_array[] = "`".$column."` ".$type;
			}
		}
		$o_string = implode(", ", $o_array);
		$this->order_by = $o_string;
	}

	private function limit($limit,$offset = null){
		$this->limit = $limit;
		if($offset!=null){
			$this->offset = $offset;
		}
	}



//Set Query condition End here


//Core tools Start here
/*
This functions are created to use in "Set Query Condition Step"
*/
	private function gen_where($where){
		if(is_array($where) && count($where)>0){
			$fild_value = array();
			foreach ($where as $field => $value) {
				$field = explode(" ", $field);
				if(count($field)>1){
					$fild_value[] = "`".$field[0]."` ".$field[1]." '".$value."'";
				}else{
					$fild_value[] = "`".$field[0]."` = '".$value."'";
				}
			}
			return implode(" and ", $fild_value);
		}else{
			return $where;
		}
	}
//Core tools End here
}

$db = new MF_DB();