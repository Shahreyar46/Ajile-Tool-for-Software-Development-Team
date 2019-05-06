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
		    //new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->pass);
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

        public function is_assoc($arr)
        {
            return array_keys($arr) !== range(0, count($arr) - 1);
        }

        public function backcotted_around(array $data){
            $len = count($data); $i = 1; $backCottedString = "";
            $is_assoc = $this->is_assoc($data);
            //var_dump($is_assoc);exit();
            if($is_assoc){
                foreach($data as $key=>$value){
                    $backCottedString .= "`$key`";
                    if($i<$len){
                        $backCottedString .= ",";
                    }
                    $i++;
                }
            }else{
                foreach($data as $key=>$value){
                    $backCottedString .= "`$value`";
                    if($i<$len){
                        $backCottedString .= ",";
                    }
                    $i++;
                }
            }

            return $backCottedString;
        }




		// super dynamic insertion method
		public function insertion($tbName,$data)
		{
			if(!empty($data) && is_array($data)){

				$keys = ''; $value = ''; $i = 0;
				$keys =  $this->backcotted_around($data);
				$values = ":".implode(', :', array_keys($data));

				$sql = "INSERT INTO `$tbName` ($keys) VALUES ($values)";

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
            //return $this->backcotted_around($data['select']);

			$sql  = 'SELECT ';
			//for select * or id,name from tablename 
			if(array_key_exists('select', $data)){
//			    $i=0;
//				foreach ($data['select'] as $value) {
//				    ++$i;
//					($i>1) ? $sql .= ",".$value : $sql .= $value;
//				}
                $sql .= $this->backcotted_around($data['select']);
			}else{
				$sql .= "*";
			}
			$sql .= " FROM `$tbName` ";

			// for where id=:id and email=:email
			if(array_key_exists('where', $data)){
				$sql .= " where "; $i = 0;
				foreach ($data['where'] as $key => $value) { ++$i;
					$and  = ($i>1) ? ' and ':'';
					$sql .= "$and"."`$key`=:$key";
				}
			}
			// for where id=:id and email=:email
			if(array_key_exists('orWhere', $data)){
				$sql .= " where "; $i = 0;
				foreach ($data['where'] as $key => $value) { ++$i;
					$and  = ($i>1) ? ' or ':'';
					$sql .= "$and"."`$key`=:$key";
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

            //return $sql;die();

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

//    select * from msgs
//    where (`from` = 1 and `to` = 2) or (`from` = 2 and `to` = 1)
//where (`from` = ? and `to` = ?) or (`from` = ? and `to` = ?)
        public function fetchuserlist($tbname)
        {
            //var_dump($_SESSION['userinfo']['id']); die();
            $query = "select * from $tbname 
                      where id != ?";
            $prepareQuery = $this->pdo->prepare($query);
            $executeQuery = $prepareQuery->execute(array($_SESSION['userinfo']['id']));
            $result = $prepareQuery->fetchAll();
            if($result){ return $result; }
            else { return false; }
		}

//    select * from msgs
//    where (`from` = 1 and `to` = 2) or (`from` = 2 and `to` = 1)
//where (`from` = ? and `to` = ?) or (`from` = ? and `to` = ?)
        public function fetchmsgs($tbname,$from,$to)
        {
            $query = "select * from $tbname 
                      where `from` = ? and `to` = ? or (`from` = ? and `to` = ?)                   
                      ";
            $prepareQuery = $this->pdo->prepare($query);
            $executeQuery = $prepareQuery->execute(array($from,$to,$to,$from));
            $result = $prepareQuery->fetchAll();
            if($result){ return $result; }
            else { return false; }
		}


		// this method for getting single data
		public function fetchProjectPeople($id)
		{
			$query = "SELECT username,email,role
						FROM users
						LEFT JOIN projectpeoples ON users.id=projectpeoples.user_id
						WHERE project_id=?";

			$prepareQuery = $this->pdo->prepare($query);
			$executeQuery = $prepareQuery->execute(array($id));
			$result = $prepareQuery->fetchAll();

			if(!$executeQuery){ return false; }
			else { return $result; };

		}


		// this method for getting single data
		public function fetchTaskPeople($id)
		{
			$query = "SELECT users.id,users.username,users.email,users.role,tasktopeople.user_id,tasktopeople.task_id,tasktopeople.project_id
						FROM users
						LEFT JOIN tasktopeople ON users.id = tasktopeople.user_id
						WHERE task_id = ?";

			$prepareQuery = $this->pdo->prepare($query);
			$executeQuery = $prepareQuery->execute(array($id));
			$result = $prepareQuery->fetchAll();

			if(!$executeQuery){ return false; }
			else { return $result; };

		}
// SELECT tasks.id,tasks.project_id,tasks.taskName,tasks.requirement,tasks.progress,tasks.priority,tasks.deadline,tasktopeople.user_id
// FROM tasks
// LEFT JOIN tasktopeople ON tasks.id = tasktopeople.task_id
// WHERE tasktopeople.user_id = 3
		// this method for getting single data
		public function fetchPeopleTask($id)
		{
			$query = "SELECT tasks.id,tasks.project_id,tasks.taskName,tasks.requirement,tasks.progress,tasks.priority,tasks.deadline,tasktopeople.user_id
						FROM tasks
						LEFT JOIN tasktopeople ON tasks.id = tasktopeople.task_id
						WHERE tasktopeople.user_id = ?";

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