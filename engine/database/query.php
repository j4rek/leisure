<?php
namespace engine\database;

/**
 * query class.
 *
 */
class query{

	/**
	 * sql_
	 * Query
	 * @var String
	 * @access private
	 */
	private $sql_;

	/**
	 * where_
	 * Contiene la Sentencia WHERE
	 * @var String
	 * @access private
	 */
	private $where_;

	/**
	 * where_bool
	 * Si la Query requiere de condicion, esta variable se transforma en TRUE
	 * @var Boolean
	 * @access private
	 */
	private $where_bool;


	/**
	 * group_
	 * Contiene la Sentencia GROUP BY
	 * @var String
	 * @access private
	 */
	private $group_;

	/**
	 * order_
	 * Contiene la Sentencia ORDER BY
	 * @var String
	 * @access private
	 */
	private $order_;

	/**
	 * limit_
	 * Contiene la Sentencia Limit
	 * @var mixed
	 * @access private
	 */
	private $limit_;

	/**
	 * eval_field_
	 * Determina si el campo-filtro debe ser evaluado [isset, not null, not empty] antes de insertarlo en la sentencia WHERE
	 * @var Boolean
	 * @access private
	 */
	private $eval_field_;

	/**
	 * field_
	 * nombre del Campo-filtro utilizado en Sentencia WHERE
	 * @var String
	 * @access private
	 */
	private $field_;

	/**
	 * operator
	 * Contiene las Clausulas AND, OR, NOT
	 * @var mixed
	 * @access private
	 */
	private $operator;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @param string $query (default: '')
	 * @return void
	 */
	function __construct($query = ''){
		$this->sql_	= $query;
	}

	/**
	 * field function.
	 * Establece el nombre del Campo-filtro utilizado para Clausula WHERE
	 * @access public
	 * @param String $field
	 * @param bool $eval (default: true)
	 * @return void
	 */
	function field($field, $eval = true){
		$this->field_ = $field;
		$this->eval_field_ = $eval;

		return $this;
	}

	/**
	 * isEqualTo function.
	 * Crea un string del campo-filtro con la condicion '='
	 * @access public
	 * @param mixed $val [Valor del campo-filtro]
	 * @return void
	 */
	function isEqualTo($val){
		if($this->check($val))
			$this->where_ .= $this->operator . $this->field_ . " = '" . $val . "'";

		return $this;
	}

	/**
	 * isNotEqualTo function.
	 * Crea un string del campo-filtro con la condicion '<>'
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function isNotEqualTo($val){
		if($this->check($val))
			$this->where_ .= $this->operator . $this->field_ . " <> '" . $val . "'";

		return $this;
	}

	/**
	 * isGreaterThan function.
	 * Crea un string del campo-filtro con la condicion '>'
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function isGreaterThan($val){
		if($this->check($val))
			$this->where_ .= $this->operator . $this->field_ . " > '" . $val . "'";

		return $this;
	}

	/**
	 * isMinorThan function.
	 * Crea un string del campo-filtro con la condicion '<'
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function isMinorThan($val){
		if($this->check($val))
			$this->where_ .= $this->operator . $this->field_ . " < '" . $val . "'";

		return $this;
	}

	/**
	 * isGreaterOrEqualThan function.
	 * Crea un string del campo-filtro con la condicion '>='
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function isGreaterOrEqualThan($val){
		if($this->check($val))
			$this->where_ .= $this->operator . $this->field_ . " >= '" . $val . "'";

		return $this;
	}

	/**
	 * isMinorOrEqualThan function.
	 * Crea un string del campo-filtro con la condicion '<='
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function isMinorOrEqualThan($val){
		if($this->check($val))
			$this->where_ .= $this->operator . $this->field_ . " <= '" . $val . "'";

		return $this;
	}

	/**
	 * between function.
	 * Crea un string del campo-filtro con la Clausula BETWEEN
	 * @access public
	 * @param mixed $start [Valor inicial]
	 * @param mixed $end   [Valor final]
	 * @return void
	 */
	function between($start, $end){
		if($this->check($start) && $this->check($end))
			$this->where_ .= $this->operator . "(" . $this->field_ . " BETWEEN '" . $start . "' AND '" . $end . "') ";

		return $this;
	}

	/**
	 * in function.
	 * Crea un string del campo-filtro con la Sentencia IN
	 * @access public
	 * @param Array $values [conjunto de valores para ingresar a la condicion]
	 * @return void
	 */
	function in($values){
		$_values = '';
		foreach($values as $key => $val){
			$_values .= "'" . $val . "',";
		}
		$this->where_ .= $this->operator . $this->field_ . " in (" . substr($_values, 0, -1) . ") ";
		return $this;
	}

	/**
	 * isNot function.
	 *
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function isNot($val){
		if($this->check($val))
			$this->where_ .= $this->operator . " NOT " . $this->field_ . "='" . $val . "'";

		return $this;
	}

	/**
	 * check function.
	 * Evalua un valor y retorna Bool si dicho valor esta definido y es distinto de NULL, EMPTY
	 * @access public
	 * @param mixed $val
	 * @return void
	 */
	function check($val){
		if($this->eval_field_){
			if(isset($val) && !is_null($val) && !empty($val)){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	/**
	 * select function.
	 * Crea la Operacion SELECT
	 * @access public
	 * @param Array | String $fields [Array: conjunto de campos deseados de la tabla | String: Cadena con los campos deseados "campo, campo, campo as field..."]
	 * @return void
	 */
	function select($fields){
		$fields_ = '';
		if(is_array($fields)){
			foreach($fields as $k => $v){
				$fields_ .= $v . ',';
			}
			$fields_ = substr($fields_, 0, -1);
		}else{
			$fields_ = $fields;
		}
		$this->sql_ = "SELECT " . $fields_;
		return $this;
	}

	/**
	 * insert function.
	 * Crea la Sentencia INSERT
	 * @access public
	 * @param mixed $table [Nombre de la tabla]
	 * @param mixed $values [Array: conjunto de valores]
	 * @return void
	 */
	function insert($table, $values){
		$this->sql_ = "INSERT INTO " . $table . " SET ";
		foreach($values as $k => $v){
			$this->sql_ .= $k . " = '" . $v . "', ";
		}
		$this->sql_ = substr(trim($this->sql_), 0, -1);
		return $this;
	}

	/**
	 * update function.
	 * Crea la Sentencia UPDATE
	 * @access public
	 * @param mixed $table [Nombre de la tabla]
	 * @param mixed $values [Array: conjunto de valores]
	 * @return void
	 */
	function update($table, $values){
		$this->sql_ = "UPDATE " . $table . " SET ";
		foreach($values as $k => $v){
			$this->sql_ .= $k . " = '" . $v . "', ";
		}
		$this->sql_ = substr(trim($this->sql_), 0, -1);
		return $this;
	}

	/**
	 * where function.
	 * Establece si la Query lleva condicion
	 * @access public
	 * @return void
	 */
	function where($field = null){
		if(!is_null($field))
			$this->field($field, true);

		$this->where_bool = true;
		return $this;
	}

	/**
	 * AND_ function.
	 * Agrega el Operador AND a la Query
	 * @access public
	 * @return void
	 */
	function AND_($field = null){
		if(!is_null($field))
			$this->field($field);

		$this->operator = " AND ";
		return $this;
	}

	/**
	 * OR_ function.
	 * Agrega el Operador OR a la Query
	 * @access public
	 * @return void
	 */
	function OR_($field = null){
		if(!is_null($field))
			$this->field($field);

		$this->operator = " OR ";
		return $this;
	}

	/**
	 * NOT function.
	 * Agrega el Operador NOT a la Query
	 * @access public
	 * @return void
	 */
	function NOT($field = null){
		if(!is_null($field))
			$this->field($field);

		$this->operator = " NOT ";
		return $this;
	}

	/**
	 * from function.
	 * Agrega la Sentencia FROM
	 * @access public
	 * @param String $table [nombre de la tabla]
	 * @return void
	 */
	function from($table){
		$this->sql_ .= " FROM " . $table;
		return $this;
	}

	/**
	 * joinWith function.
	 * Agrega la Sentencia INNER JOIN
	 * @access public
	 * @param String $table [nombre de la tabla a realizar en la operacion]
	 * @param mixed $origin [campo de la tabla 1]
	 * @param mixed $compare [campo de la tabla 2]
	 * @return void
	 */
	function joinWith($table, $origin, $compare){
		$this->sql_ .= " INNER JOIN " . $table . " on " . $origin . '=' . $compare;
		return $this;
	}

	/**
	 * orderBy function.
	 * Agrega la clausula ORDER BY
	 * @access public
	 * @param string $field [nombre del campo a utilizar]
	 * @param string $order (default: 'ASC')
	 * @return void
	 */
	function orderBy($field, $order = 'ASC'){
		$this->order_ = " ORDER BY " . $field . " " . $order;
		return $this;
	}

	/**
	 * groupBy function.
	 * Agrega la clausula GROUP BY
	 * @access public
	 * @param mixed $field [nombre del campo a utilizar]
	 * @return void
	 */
	function groupBy($field){
		$this->group_ = " GROUP BY " . $field;
		return $this;
	}

	/**
	 * limit function.
	 * Agrega la clausula LIMIT
	 * @access public
	 * @param String $limit [valor utilizado para establecer el limite de registros]
	 * @return void
	 */
	function limit($limit){
		$this->limit_ = " LIMIT " . $limit;
		return $this;
	}

	/**
	 * toString function.
	 * Retorna la consulta SQL
	 * @access public
	 * @return String
	 */
	function toString(){
		$this->where_ = ($this->where_bool) ? " WHERE " . $this->where_ : '';
		return $this->sql_ . $this->cleanWhereClause() . $this->group_ . $this->order_ . $this->limit_ . ';';
	}

	/**
	 * cleanWhereClause function.
	 * limpia inconsistencias en la Clausula WHERE
	 * @access private
	 * @return String
	 */
	private function cleanWhereClause(){
		if(stripos($this->where_, 'where  and') !== false || stripos($this->where_, 'where  or') !== false){
			return " WHERE " . str_ireplace('where  and','', str_ireplace('where  or', '', $this->where_));
		}else{
			return $this->where_;
		}

	}

	/**
	 * Reset a los elementos de la consulta
	 * @return void
	 */
	function clean(){
		$this->sql_ = '';
		$this->field_ = '';
		$this->operator = '';
		$this->where_ = '';
		$this->where_bool = false;
		$this->group_ = '';
		$this->order_ = '';
		$this->limit_ = '';
	}
}
