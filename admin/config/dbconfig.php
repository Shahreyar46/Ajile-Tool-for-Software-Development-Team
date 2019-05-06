<?php 

    //require_once (__DIR__.'/../helper/session.php');
    //require_once (dirname(__FILE__). '/../helper/session.php');
    

	class Database{

	 	private $host   = "localhost";
	 	private $user   = "root";
	 	private $pass   = "";
	 	private $dbname = "project_tools";

	 	private $pdo;

	 	/* this function will call automatically when this class 
	 	is called.Cause contructor function don't wait for calling :D */
		public function __construct(){
			if(!isset($pdo)){
				try{
					$this->connectDB();
				}
				catch(exception $e){
					echo $e->getmessage();
				}
			}
		}

		// database connection creation method
		public function connectDB()
		{
			$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->pass);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if(!$this->pdo){
				$this->error = "Connection failed ".$this->pdo->connect_error;
				echo $this->error;
				return 0;
			}
		}


		// database creation & selection method
		public function dbCreation($dbname)
		{
			$query = "CREATE DATABASE IF NOT EXISTS ".$dbname;
			$prepareQuery = $this->pdo->prepare($query);
			$executeQuery = $prepareQuery->execute();
			if(!$executeQuery){ echo "<br>"."Database not created"; }
			else{ echo "DATABASE CREATED"."<br>"; }
		}


		// table creation method
		public function createTable($tbName)
		{
			$query = "CREATE TABLE IF NOT EXISTS ".$tbName."(
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				task VARCHAR(30) NOT NULL,
				time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			)";
			$prepareQuery = $this->pdo->prepare($query);
			$executeQuery = $prepareQuery->execute();
			if(!$executeQuery){ echo "table not created"."<br>"; }
			else{ echo "table created"."<br>"; }
		}

		//drop database
		public function dropDatabase($dbname)
		{
			$query = "DROP DATABASE IF EXISTS ".$dbname;
			$prepareQuery = $this->pdo->prepare($query);
			$executeQuery = $prepareQuery->execute();
			if(!executeQuery){ echo "database not droped"; }
			else{ echo "database droped"; }
		}


		// drop table method TRUNCATE TABLE `nur`
		public function dropTable($tbName)
		{
			$dropQuery = "DROP TABLE IF EXISTS ".$tbName;
			$tbDroped = $this->pdo->query($dropQuery);
			if($tbDroped){ echo "{$tbName} table dropped "; }
			else { echo "table not created"; }
		}


		// super dynamic insertion method
		public function insertion($tbName,$data)
		{
			if(!empty($data) && is_array($data)){

				$keys = ''; $value = ''; $i = 0;
				$keys = implode(',', array_keys($data));
				$values = ":".implode(', :', array_keys($data));

				$sql = "INSERT INTO $tbName ($keys) VALUES ($values)";
				$prepareQuery = $this->pdo->prepare($sql);

				foreach ($data as $key => $value) {
					$prepareQuery->bindValue(":$key", $value);
				}

				$executeQuery = $prepareQuery->execute();
				return $executeQuery ? true : false;
			}

		}

/*$sql = $this->pdo->prepare(select id, firstname, lastname from tableName where id=:id and email=:email order by id DESC limit 5,2);
$sql->bindValue(':id',$id);$sql->bindValue(':email',$email);
$sql->execute();*/
		// dynamic selection method
		public function selection($tbName,$data=array())
		{
			$sql  = 'SELECT ';
			//for select * or id,name from tablename 
			if(array_key_exists('select', $data)){ $i=0;
				foreach ($data['select'] as $value) { ++$i;
					($i>1) ? $sql .= ",".$value : $sql .= $value;
				}
			}else{
				$sql .= "*";
			}
			$sql .= " FROM ".$tbName." ";
			// for where id=:id and email=:email
			if(array_key_exists('where', $data)){
				$sql .= " where "; $i = 0;
				foreach ($data['where'] as $key => $value) { ++$i;
					$and  = ($i>1) ? ' and ':'';
					$sql .= "$and"."$key=:$key";
				}

			}

			if(array_key_exists('order_by', $data)){
				$sql .= " order by ".$data['order_by'];
			}

			if(array_key_exists('limit', $data)){
				$sql .= " limit "; $i = 0;
				foreach ($data['limit'] as $value) { ++$i;
					$coma = ($i>1) ? "," : '';
					$sql .= "$coma"."$value";
				}
			}

			$prepareQuery = $this->pdo->prepare($sql);

			if(array_key_exists('where', $data)){
				foreach ($data['where'] as $key => $value) {	
					$prepareQuery->bindValue(":$key",$value);
				}
			}

			$executeQuery = $prepareQuery->execute();

			if(array_key_exists('return_type', $data)){
				switch ($data['return_type']) {
					case 'rowCount':
						return $prepareQuery->rowCount();
						break;
					case 'all':
						return $prepareQuery->fetchAll(PDO::FETCH_ASSOC);
						break;
					case 'one':
						return $prepareQuery->fetch(PDO::FETCH_ASSOC);
						break;
					default:
						return false;
						break;
				}
			}
/*			if(!$executeQuery){ return false; }
			else { return $prepareQuery->fetch(PDO::FETCH_ASSOC); };*/
			//else { return $sql; };

			//$sql .= ' ';

			//return $sql;
		}

	

		// UPDATE $tbName SET task=:task,time=:time WHERE id=:id AND task=:task
		// update method
		public function update($tbName,$cond,$data)
		{
			if(!empty($data) && is_array($data)){
				$setkey = '';$wherekey = '';$i=0;
				foreach ($data as $key => $value) { ++$i;
					$coma = ($i>1) ? ',':'';
					$setkey .= "$coma"."$key=:$key";
				}
			}
			if(!empty($cond) && is_array($cond)){
				$wherekey .= " where ";$i=0;
				foreach ($cond as $key => $value) { $i++;
					$and = ($i > 1) ? ' AND ':'';
					$wherekey .= "$and"."$key=:$key";
				}
			}

			$sql = "update $tbName set $setkey $wherekey";
			$prepareQuery = $this->pdo->prepare($sql);

			foreach ($data as $key => $value) {
				$prepareQuery->bindValue(":$key",$value);
			}

			foreach ($cond as $key => $value) {
				$prepareQuery->bindValue(":$key",$value);
			}

			$executeQuery = $prepareQuery->execute();

			return $executeQuery ? true : false;
		}

		// DELETE FROM $tbName WHERE id=:id AND task=:task
		// delete method
		public function delete($tbName,$cond)
		{
			if(!empty($cond) && is_array($cond)){
				$wherekey = 'where '; $i = 0;
				foreach ($cond as $key => $value) { $i++;
					$and = ($i>1) ? " AND ":'';
					$wherekey .= "$and"."$key=:$key";
				}
			}

			$sql = "delete from $tbName $wherekey";
			$prepareQuery = $this->pdo->prepare($sql);

			foreach ($cond as $key => $value) {
				$prepareQuery->bindValue(":$key",$value);
			}

			$executeQuery = $prepareQuery->execute();
			return $executeQuery ? true : false;
			//return $sql;
		}


		// this method for getting single data
		public function singleData($tbName,$id)
		{
			$query = "SELECT * FROM $tbName WHERE id = ?";
			$prepareQuery = $this->pdo->prepare($query);
			$executeQuery = $prepareQuery->execute(array($id));
			$result = $prepareQuery->fetchAll();
			if(!$executeQuery){ return false; }
			else { return $result; };
		}


		// mysqli connection closing method
		public function closeConnection()
		{
			$this->pdo = null;
		}


	}
	
		
?>