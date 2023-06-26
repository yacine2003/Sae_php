<?php
	class Db_element{
 		
		protected static $db_conn;

		public $id;

		public static function define_db_conn($db_connection){
			self::$db_conn = $db_connection;
		}

		public static function select_by_id($id){
			$sql = "SELECT * FROM ".static::$table_name." WHERE id='".self::$db_conn->real_escape_string($id)."';";
			$result = self::$db_conn->query($sql);
			$record_object = self::instantiate($result->fetch_assoc());
			return $record_object;

		}
		public static function select_all(){
			$sql = "SELECT * FROM ".static::$table_name.";";
			$result =  self::$db_conn->query($sql);
			$objects_array = [];
			while ($record = $result->fetch_assoc()) {
				$objects_array[] = static::instantiate($record);
			}
			return $objects_array;
		}
		protected static function instantiate($record){
			$object = new static;
			foreach ($record as $property => $value) {
				if (property_exists($object, $property)) {
					$object->$property = $value;
				}
			}
			return $object;
		}
		protected function sanitize_inputs(){
			$sanitized_inputs = [];
			foreach (static::$columns as $property ) {
				if ($property=="id") {
					continue;
				}
				$sanitized_inputs[$property] = self::$db_conn->real_escape_string($this->$property);
			}
			return $sanitized_inputs;
		}
		public function create(){
			$sanitized_inputs = $this->sanitize_inputs();
			$sql = "INSERT INTO ". static::$table_name. "(".join(",",array_keys($sanitized_inputs)).") VALUES ('".join("','",array_values($sanitized_inputs))."');";
			$result = self::$db_conn->query($sql);
			if (!$result) {
				echo self::$db_conn->error;
			}
		}
		public function update(){
			$sanitized_inputs =  $this->sanitize_inputs();
			$key_value_pairs = [];
			foreach ($sanitized_inputs as $key => $value) {
				$key_value_pairs[] = $key."='".$value."'";
			}
			$sql = "UPDATE ".static::$table_name. " SET ".join(",",$key_value_pairs)." WHERE id='".self::$db_conn->real_escape_string($this->id)."';";
			$result = self::$db_conn->query($sql);
			if (!$result) {
				echo self::$db_conn->error;
			}
		}
		public function delete(){
			$sql = "DELETE FROM ".static::$table_name." WHERE id='".self::$db_conn->real_escape_string($this->id)."';";
			$result = self::$db_conn->query($sql);
			if (!$result) {
				echo self::$db_conn->error;
			}
		}
	}

	class User extends Db_element{
		protected static $table_name = 'users';
		protected static $columns = ['id','first_name','last_name','username','password','user_type'];

		public $first_name;
		public $last_name;
		public $username;
		public $password;
		public $user_type;

		public function __construct($args=[]){
			$this->first_name = $args['first_name'] ?? "";
			$this->last_name = $args['last_name'] ?? "";
			$this->username = $args['username'] ?? "";
			$this->password = $args['password'] ?? "";
			$this->user_type = $args['user_type'] ?? "";
		}

		public static function check_user_exists($args=[]){
			$sql = "SELECT * FROM ".self::$table_name." WHERE username='".static::$db_conn->real_escape_string($args['username'])."';";
			$result = static::$db_conn->query($sql);
			if ($result->num_rows>0) {
				return true;
			}else if($result->num_rows==0){
				return false;
			}
		}

		public static function check_user_password($args=[]){
			$sql = "SELECT * FROM ".self::$table_name." WHERE username='".static::$db_conn->real_escape_string($args['username'])."';";
			$result = static::$db_conn->query($sql);
			$user = $result->fetch_assoc();
			if (password_verify($args['password'], $user['password'])) {
				return true;
			}else{
				return false;
			}
		}

		public static function select_by_username($args=[]){
			$sql = "SELECT * FROM ".self::$table_name." WHERE username='".static::$db_conn->real_escape_string($args['username'])."';";
			$result = static::$db_conn->query($sql);
			$user = $result->fetch_assoc();
			return static::instantiate($user);
		}
	}

	class Quiz extends Db_element{

		protected static $table_name = "quizes";
		protected static $columns = ['id','title','questions'];

		public $title;
		public $questions;

		public function __construct($args=[]){
			$this->title = $args['title'] ?? "";
			$this->questions = $args['questions'] ?? "";
		}
	}