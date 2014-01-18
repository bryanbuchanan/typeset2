<?

class DB {

	public $handle;
	private $statement;

	// Initial connection
	public function __construct($db_info) {
		try {
			$this->handle = new PDO(
				"mysql:host=$db_info->host;dbname=$db_info->database;charset=utf8",
				$db_info->user,
				$db_info->password,
				array(
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_EMULATE_PREPARES => false,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
				)
			);
		} catch (PDOException $e) {
			echo "Database connection failed";
			$this->error($e);
			exit;
		}			
	}
	
	// Error Reporting
	public function error($e) {
		// echo "Error " . $e->getCode();
		print_r($e);
		// notify("PDO Error: " . $e->getCode(), $e->getMessage() . "\n\n---\n\n" . print_r($e, true));
		return false;
	}

	// Query Request
	public function run($query, $parameters=null) {
									
		try {

			// Prepare
			$this->statement = $this->handle->prepare($query);
		
			// Prep parameters array
			if (!isset($parameters)):
				$parameters = array();
			endif;
			
			if (!is_array($parameters)):
				// Turn single parameter into array
				$parameters = array($parameters);
				// Change to 1-based array, instead of 0-based
				array_unshift($parameters, "phoney");
				unset($parameters[0]);
			endif;
			
			// Bind Parameters
			foreach ($parameters as $key => $value):
				if (empty($value)):
					$type = PDO::PARAM_NULL;
					$value = null;
				elseif (is_numeric($value)):
					$type = PDO::PARAM_INT;
					$value = intval($value);
				elseif (is_bool($value)):
					$type = PDO::PARAM_BOOL;
				else:
					$type = PDO::PARAM_STR;
				endif;
				$this->statement->bindValue($key, $value, $type);
			endforeach;

			// Execute
			$this->statement->execute();
			
			// Return
			return $this->statement;
			
		} catch (PDOException $e) {
			$this->error($e);
		}
		
	}
	
	// Get all results
	public function getAll($query, $parameters=array()) {
		return $this->run($query, $parameters)->fetchAll();
	}
	
	// Get one result
	public function getOne($query, $parameters=array()) {
		return $this->run($query, $parameters)->fetch();
	}
	
	// Delete
	public function delete($query, $parameters=array()) {
		return $this->run($query, $parameters)->rowCount();
	}
	
	// Update
	public function update($query, $parameters=array()) {
		return $this->run($query, $parameters)->rowCount();
	}
	
	// Get Number
	public function getNumber($query, $parameters=array()) {
		return $this->run($query, $parameters)->rowCount();
	}

}
	
?>