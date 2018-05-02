<?php
namespace engine\database;

use \engine\interfaces\database\iDatabase;
use \engine\database\query;

/**
 * db class.
 *
 * PDO lib
 *
 */
class database implements iDatabase{
	/**
	 * motor
	 * mysql - sqlserver - postgres
	 * @var mixed
	 * @access private
	 */
	static private $motor;

	/**
	 * ip
	 * Host de conexion
	 * @var mixed
	 * @access private
	 */
	static private $ip;

	/**
	 * base
	 * base de datos
	 * @var mixed
	 * @access private
	 */
	static private $base;

	/**
	 * usuario
	 *
	 * @var mixed
	 * @access private
	 */
	static private $usuario;

	/**
	 * clave
	 *
	 * @var mixed
	 * @access private
	 */
	static private $clave;

	/**
	 * coneccion
	 * cadena de conexion
	 * @var mixed
	 * @access private
	 */
	static private $conexion;

	/**
	 * link
	 * objeto conexion
	 * @var mixed
	 * @access public
	 */
	static $link;

	/**
	 * stmt
	 * Statement PDO
	 * @var mixed
	 * @access public
	 * @static
	 */
	static $stmt;

	/**
	 * init function.
	 *
	 * @access public
	 * @param mixed $motor
	 * @param mixed $ip
	 * @param mixed $base
	 * @param mixed $usuario
	 * @param mixed $clave
	 * @return void
	 */
	static function turnOn(){
		$config = include __DIR__ . '/../config.php';
		self::$conexion = $config['db']['motor'] . ":host=" . $config['db']['ip'] . ";dbname=" . $config['db']['base'] . ";";
		try{
			self::$link = new \PDO(self::$conexion, $config['db']['usuario'], $config['db']['clave'],array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		}catch(\PDOException $ex){
			echo $ex.message;
			exit('Error de conexion a BD;');
		}
	}

	/**
	 * consulta function.
	 * Ejecuta la consulta sql
	 * @access public
	 * @static
	 * @param mixed $consulta (default: null)
	 * @param bool $consulta (default: false)
	 * @return void
	 */
	static function executeQuery($consulta = null, $fetch = true, $debug = false){
		if(!isset(self::$link)){
			self::init();
		}
		try{
			if(isset($consulta) && !is_null($consulta)){
				self::$stmt = self::$link->prepare($consulta);
				if(!$res = self::$stmt->execute()){
					exit(printf('Consulta: %s <br/> error : %s <br/><br/> [ script detenido ]', $consulta, self::$stmt->errorInfo()[2]));
				}else{
					if($debug){
						printf('Consulta: %s <br/><br/> resultado : ', $consulta);
						var_dump(self::$stmt->fetchAll(\PDO::FETCH_ASSOC));
						exit('[ script detenido ]');
					}
					if($fetch){
						return self::$stmt->fetchAll(\PDO::FETCH_ASSOC);
					}else{
						return self::$stmt;
					}
				}
			}
		}catch(\PDOException $ex){
			var_dump($ex);
		}
	}

	/**
	 * rowCount function.
	 * retorna el numero de registros devueltos por la consulta
	 * @access public
	 * @static
	 * @param object $stmt [stament PDO, en caso de ser NULL utiliza el objeto propio de la clase]
	 * @return void
	 */
	static function rowCount($stmt = NULL){
		return !is_null($stmt) ? $stmt->rowCount() : self::$stmt->rowCount();
	}

	/**
	 * resultsToArray function.
	 * convierte la data del resultado en un array asociativo
	 * @access public
	 * @static
	 * @param mixed $result
	 * @return void
	 */
	static function resultToArray($result){
		return $result->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * resultToJson function.
	 * convierte la data del resultado a formato json
	 * @access public
	 * @static
	 * @param mixed $result
	 * @return void
	 */
	static function resultToJson($result){
		return json_encode($result->fetchAll(\PDO::FETCH_ASSOC));
	}
}

?>
