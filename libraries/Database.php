<?php 

/**
	 * 
	 */
	class Database 
	{
		public $link;
		public function __construct()
		{
			$this->link =  mysqli_connect("localhost" ,"root","","thoitrang") or die();
			mysqli_set_charset($this->link,"utf8");
		}

		public function insert($table , array $data)
		{
			$sql="INSERT INTO {$table}";
			$columns = implode(',', array_keys($data));
			$values= "";
			$sql .= '(' . $columns . ')';
			foreach ($data as $field => $value) 
			{
				if(is_string($value)) 
				{
					$values .= "'" . mysqli_real_escape_string($this->link,$value) ."',";
				}
				else
				{
					$values .= mysqli_real_escape_string($this->link,$value) . ',';
				}
			}
			$values = substr($values, 0 , -1);
			$sql .= "VALUES (" .$values. ')';
			//debug $sql die
			mysqli_query($this-> link,$sql) or die ("Lỗi query insert ! " . mysqli_error($this->link));
			return mysqli_insert_id($this->link);
		}
		
		public function update($table ,array $data , array $conditions)
		{
			$sql = "UPDATE {$table}";
			$set =" SET " ;
			$where = " WHERE ";
			foreach ($data as $field => $value)
		 	{
				if(is_string($value)) {
					$set .= $field . '=' .'\''. mysqli_real_escape_string($this->link , $value) .'\',';
				}
				else
				{
					$set .= $field . '=' . mysqli_real_escape_string($this->link , $value) .',';
				}
			}
			$set = substr($set, 0, -1);

			foreach ($conditions as $field => $value) 
			{
				if(is_string($value)) 
				{
					$where .= $field . '=' .'\''. mysqli_real_escape_string($this->link , $value) .'\' AND ';
				}
				else
				{
					$where .= $field . '=' . mysqli_real_escape_string($this->link , $value) .' AND ';
				}
			}
			$where = substr($where, 0 , -5);
			$sql.= $set . $where ;

			//debug $sql die

			mysqli_query($this-> link,$sql) or die ("Lỗi truy vấn update !" . mysqli_error($this->link));
			return mysqli_affected_rows($this->link);
		}
		public function updateview($sql)
		{
				$result = mysqli_query($this->link ,$sql) or die ("Lỗi update view !" .mysqli_error($this->link));
				return mysqli_affected_rows($this->link);
		}

		public function delete ($table ,$id)
		{
			$sql ="DELETE FROM {$table} WHERE id = 	$id";
			mysqli_query($this-> link,$sql) or die ("Lỗi truy vấn dalete !" . mysqli_error($this->link));
			return mysqli_affected_rows($this->link);
		}
		public function delete_size ($table ,$id)
		{
			$sql ="DELETE FROM {$table} WHERE id_SanPham = $id";
			mysqli_query($this-> link,$sql) or die ("Lỗi truy vấn dalete !" . mysqli_error($this->link));
			return mysqli_affected_rows($this->link);
		}
		public function countTable($table)
		{
			$sql=" SELECT id FROM {$table} ";
			$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn countTable" . mysqli_error($this->link));
			$num =mysqli_num_rows($result);
			return $num;
		}

		public function fetchAll($table) 
		{
			$sql= "SELECT * FROM {$table} WHERE 1";
			$result = mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetAll " . mysqli_error($this->link));
			$data =[];
			if($result)
			{
				while ($num = mysqli_fetch_assoc($result)) 
				{
					$data[]= $num;
				}
			}
			return $data;
		}
		public function fetchID($table,$id) 
		{
			$sql= "SELECT * FROM {$table} WHERE id= $id ";
			$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchID " .mysqli_error($this->link));
			return mysqli_fetch_assoc($result);
		}
		public function fetchIDSize($table,$id) 
		{
			$sql= "SELECT * FROM {$table} WHERE id_SanPham = $id";
			$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchFKID " .mysqli_error($this->link));
			return mysqli_fetch_assoc($result);
		}

		public function fetchOne($table,$query)
		{
			$sql= "SELECT * FROM {$table} WHERE ";
			$sql .= $query;
			$sql .= " LIMIT 1";
			$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchOne ".mysqli_error($this->link));
			return mysqli_fetch_assoc($result);
		}
		public function fetchsql($sql)
		{
			$result= mysqli_query($this->link,$sql) or die("Lỗi truy vấn fetchsql" . mysqli_error($this->link));
			$data=[];
			if($result)
			{
				while ($num = mysqli_fetch_assoc($result)) 
				{
					$data []= $num;
				}
			}
			return $data;
		}

		public function fetchJone($table ,$sql,$page=0,$row,$papi =false) 
		{
			$data =[];
			if($papi == true){
				$total= $this -> countTable($table);
				$sotrang= ceil($total/$row);
				$start = ($page -1) * $row;
				$sql .= " LIMIT $start, $row";
				$data = ["page" =>  $sotrang];

				$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchJone " . mysqli_error($this-> link));
			}
			else 
			{
				$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchJone " . mysqli_error($this-> link));
			}

			if($result) 
			{
				while ($num = mysqli_fetch_assoc($result)) 
				{
					$data[]= $num;
				}
			}
			return $data;
		}

		public function fetchJones($table,$sql,$total = 1,$page,$row,$papi =true) 
		{
			$data =[];
			if($papi == true)
			{
				$sotrang= ceil($total / $row);
				$start = ($page - 1 ) * $row;
				$sql .= " LIMIT $start, $row ";
				$data = [ "page" =>  $sotrang ];

				$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchJones " . mysqli_error($this-> link));
			}
			else 
			{
				$result =mysqli_query($this->link,$sql) or die ("Lỗi truy vấn fetchJones " . mysqli_error($this-> link));
			}

			if($result) 
			{
				while ($num = mysqli_fetch_assoc($result)) 
				{
					$data[]= $num;
				}
			}
			return $data;
		}
	
	}	


?>