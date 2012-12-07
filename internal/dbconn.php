<?php

/*
	- DBConn
	Class for general database connections, extending PHP's PDO
*/
	
	Class DBConn extends PDO {
		
		private $dbtype;
		
		public function __construct($dbtype, $dbargs) {
			switch($dbtype) {
				case "sqlite":
				$this->dbtype = $dbtype;
				try {
					parent::__construct($dbtype.':'.$dbargs);
				} catch (PDOException $e) {
					echo "Connection error: " . $e->getMessage();
				}
					break;
				default:
					echo "ERROR: Unknown dbtype: ". $dbtype;
			}
		}
		
	}


?>