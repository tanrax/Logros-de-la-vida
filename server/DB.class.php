<?php

/**
 * Clase para utilizar la base de datos
 * 1.2v
 */
class DB {
	//Variables
	public static $DB_HOST = 'localhost';//host database
	public static $DB_USER = 'user database';
	public static $DB_PASS = 'pass database';
	public static $DB_TYPE = 'mysql';//type database: sqlite, PostgreSQL...
	public static $DB_NOM = 'nom database';
	private $sQuery;
	private $aRows = array();
	private $conn;
	private $iLastId = 0;

	/**
	 * Constructor
	 */
	public function __construct() {
	}
	/**
	 * Método que conecta con la base de datos
	 */
	private function abrirConexion() {
		$this->conn = new PDO(self::$DB_TYPE . ':host=' . self::$DB_HOST 
			. ';dbname=' . self::$DB_NOM . ';charset=utf8;', self::$DB_USER, self::$DB_PASS);
	}
	/**
	 * Método que desconecta de la base de datos
	 */
	private function cerrarConexion() {
		$this->conn = null;
	}
	/**
	 * Método que ejecutar un query simple del tipo INSERT, DELETE, UPDATE
	 * @param  String $insSQL Sentencia SQL
	 */
	public function ejecutarQuery($insSQL) {
		$this->sQuery = $insSQL;
		$this->abrirConexion();
		$this->conn->query($this->sQuery);
		$this->iLastId = $this->conn->lastInsertId();
		$this->cerrarConexion();
	}
	/**
	 * Método que traer resultados de una consulta en un Array
	 * @param  String $insSQL Sentencia SQL
	 * @return Array         array con los valores de la BBDD que cumplen la query
	 */
	public function obtenerResultado($insSQL){
		$this->sQuery = $insSQL;
		$this->abrirConexion();
		$result = array();

		foreach ($this->conn->query($this->sQuery) as $row) {
			 array_push($result, $row);
		}
		return $result;
	}

	/**
	 * Método que cuenta los resultados de una consulta Select
	 * @param  String $insSQL Sentencia SQL
	 * @return int         número de consultas que cumplen la query
	 */
	public function contarResultadosQuery($insSQL){
		$result = count($this->obtenerResultado($insSQL));
		return $result;
	}

	/**
	 * Método que devuelve el último id al realizar un insert
	 */
	public function getLastId() {
		return $this->iLastId;
	}
}

?>
