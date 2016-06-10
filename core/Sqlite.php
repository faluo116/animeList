<?php
/**
  *Sqlite的简单操作类
  *
  *copryright:2015 faluo
  *ver:0309
  *基本用法:
  *define("TRUE_PATH",__DIR__ . "/");
  *require_once('Sqlite.php');
  *$db = new Sqlite(TRUE_PATH,'fo.db');
  *$result = $db -> query_sql('select * from table',true);
  *
  */
class Sqlite {

// 数据库地址	
public $path = "";	
// 数据库名
public $dbname = "";

// 路径(/结尾)，数据库名
function __construct($path,$dbname){
	$this -> path = $path;
	$this -> dbname = $dbname;
}

// 返回数据库执行结果
private function get_query_result($conn){
  if (is_null($conn)){
    return 'conn null';
  }
  $reason = array('Successful','SQL error or missing database','An internal logic error in SQLite','Access permission denied','Callback routine requested an abort','The database file is locked','A table in the database is locked','A malloc() failed','Attempt to write a readonly database','Operation terminated by sqlite_interrupt()','Some kind of disk I/O error occurred','The database disk image is malformed','(Internal Only) Table or record not found','Insertion failed because database is full','Unable to open the database file','Database lock protocol error','(Internal Only) Database table is empty','The database schema changed','Too much data for one row of a table','Abort due to contraint violation','Data type mismatch','Library used incorrectly','Uses OS features not supported on host','Authorization denied');
  $a = $conn -> errorInfo();
  // 1:错误代码，2:原因描述
  $code = $a[1];
  if (0 == $code){
  	return $reason[0];
  } else {
  	return $reason[$code] . '<->' . $a[2];
  }
}

// 执行一条SQL，无返回结果。(SQL语句，是否输出执行结果)
public function query_sql($sql,$islog = false){
	if (is_null($this -> path) || is_null($this -> dbname) || is_null($sql)){
		return '-1';
	}
	//if ($islog == null){
	//	$islog = false;
	//}
    $dbp = $this -> path . $this -> dbname;
    $conn = new PDO('sqlite:' . $dbp);
    if ($conn != NULL){
        $conn -> query($sql);
        $result = $this -> get_query_result($conn);
        $conn = NULL;
		if ($islog){
			echo $result . '<br/>->' . $sql;
		}
		if ('Successful' === $result){
			return '0';	
		} 
		return '-1';
    }
}

// 执行一条SQL，返回结果。(SQL语句，是否输出执行结果)
public function query_sql_result($sql,$islog = false){
	if (is_null($this -> path) || is_null($this -> dbname) || is_null($sql)){
		return '-1';
	}
	//if ($islog == null){
	//	$islog = false;
	//}
    $dbp = $this -> path . $this -> dbname;
    $conn = new PDO('sqlite:' . $dbp);
	if ($conn != NULL){
		$tmp = $conn -> query($sql);
		$result = $this -> get_query_result($conn);
		if ($islog){
			echo $result . '<br/>->' . $sql;
		}
		if($tmp != NULL){
			$rows = $tmp -> fetchAll();
			return $rows;
		}
		$conn = NULL;
	}
	return null;
}

// 取得表的总行数(表中必须有id字段)
public function table_count($table_name){
	$sql = 'select count(id) c from ' . $table_name;
	$result = $this -> query_sql_result($sql);
	if ($result != NULL){
		$result2 = $result[0];
		if ($result2 != NULL){
			return $result2['c'];
		}
	}
}

}

?>
