<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("Sqlite.php");
function checkdb(){
	$dbpath = TRUE_PATH . 'anime.db';
	if (!file_exists($dbpath)){
		// 建库建表	
		$ddl_happy = "CREATE TABLE happy (id INTEGER PRIMARY KEY AUTOINCREMENT, a_name VARCHAR(0,255) DEFAULT (''), a_week INTEGER DEFAULT (0), a_count INTEGER DEFAULT (0), a_housou VARCHAR(0,255) DEFAULT (''), a_watch INTEGER DEFAULT (0));";
		$db = new Sqlite(TRUE_PATH,'anime.db');
		$db -> query_sql($ddl_happy);
	}
}
function today(){
    date_default_timezone_set('PRC');
	return date('ymd',time());
}
function this_week(){
    date_default_timezone_set('PRC');
	return date('w');
}
checkdb();
$today = today();
$this_week = this_week();
$week = array('Err','一','二','三','四','五','六','日');
$housou = array('Err','bilibili','youku','271','letv','sohu','tencent','pptv');
$db = new Sqlite(TRUE_PATH,'anime.db');
if (!empty($_POST['a_n'])){
	$a_n = $_POST['a_n'];
	if (!is_null($a_n)){
		// 添加	
		$a_w = $_POST['a_w'];
		$a_h = $_POST['a_h'];
		var_dump($a_w);
		var_dump($a_h);
		$sql = "insert into happy (a_name,a_week,a_count,a_housou,a_watch) values ('" . $a_n . "'," . $a_w . ",0,'" . $housou[$a_h] . "',0)";
		$db -> query_sql($sql);
		header("Location:index.php");
		exit();
	}
}
if (!empty($_GET['id'])){
	$id = $_GET['id'];
	if (!is_null($id) && is_numeric($id)){
		// 标记
		$sql = "update happy set a_count=a_count+1,a_watch=" . $today . " where id=" . $id;
		$db -> query_sql($sql);
		header("Location:index.php");
		exit();
	}
}
if (!empty($_POST['do_sql'])){
	$do_sql = $_POST['do_sql'];
	if (!is_null($do_sql)){
		// 直接执行SQL
		if ('clear' == $do_sql){
			// 彻底清表
			$db -> query_sql('delete from happy');
			// $db -> query_sql('update sqlite_sequence set seq=0 where name=\'happy\'');
		} else {
			$db -> query_sql($do_sql);
		}
		header("Location:index.php");
		exit();
	}
}
$happy = $db -> query_sql_result('select * from happy order by a_week');
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Anime</title>
		<link rel="shortcut icon" href="fac.png" />
		<style>
			table#order{
				border:1px;
				border-style:solid;
				border-color:#CCCCCC;
				border-collapse:collapse;
				color:#000000;
			}
			td#otd{
				border:1px;
	   			border-style:solid;
	   			border-color:#CCCCCC;
	   			letter-spacing:1px;
				padding:6px;
			}
			th#otd{
				border:1px;
				color:#000000;
	  			border-style:solid;
	  			border-color:#CCCCCC;
	  			letter-spacing:1px;
				padding:6px;
				text-align:center;
				background-color:#F1F1F1;
			}
			tr.hline:hover{
				background-color:#F1F1F1;
			}
			#line{
				margin-left:1px;
				margin-right:6px;
				margin-top:-3px;
				margin-bottom:3px;
				border-bottom: 1px solid #BEC0C2;
			}
			#title{
				clear:both;
				font-weight:bold;
				font-size:16px;
				font-family:华文细黑,serif;
				padding:10px;
			}
			#content{
				padding:10px;
			}
			#web{
				float:left;
				padding-top:5px;	  
				padding-right:20px;
				padding-bottom:5px;
				padding-left:10px;
				margin-top:10px;
			}
			#alist{
				padding-top:5px;	  
				padding-right:20px;
				padding-bottom:5px;
				padding-left:10px;
				margin-top:10px;
			}
			a.web:link{
				color:#666666;
				text-decoration:none;
			}
			a.web:visited{
				color:#666666;
				text-decoration:none;
			}
			a.web:hover{
				color:#F05A28;
				text-decoration:none;
			}
			.btn{
				margin-left:3px;
				border:1px solid #CCCCCC;
				background-color:#E2E2E2;
				font-size:16px;
				padding:2px;
				cursor:pointer;
			}
		</style>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:1000px;margin-left:auto;margin-right:auto;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;">Faluo's Anime Chart</div>
			<form action="index.php" method="post">
				<input type="text" id="a_n" name="a_n" style="float:left;width:260px;font-size:18px;border:1px solid #CCCCCC;"/>
				<select id="a_w" name="a_w" style="font-size:18px;margin-left:3px;"><?php
					for ($i = 1 ; $i < count($week) ; ++$i){
						echo '<option value="' . $i . '">' . $week[$i] . '</option>';
					}
					?></select><select id="a_h" name="a_h" style="font-size:18px;margin-left:3px;"><?php
					for ($i = 1 ; $i < count($housou) ; ++$i){
						echo '<option value="' . $i . '">' . $housou[$i] . '</option>';
					}
					?></select><input type="submit" class="btn" value="&nbsp;保&nbsp;存&nbsp;"/>
			</form>
            <table width="100%" id="order" style="margin-top:20px;margin-bottom:20px;">
                <tr align="left">
                    <th id="otd">#</th>
                    <th id="otd">ID</th>
                    <th id="otd">名称</th>
                    <th id="otd">周</th>
                    <th id="otd">集数</th>
                    <th id="otd">最后观看</th>
                    <th id="otd">放送</th>
                </tr>
			<?php
				if (!is_null($happy)){
					$c = count($happy);
					for ($i = 0 ; $i < $c ; ++$i){
						echo '<tr class="hline">';
						echo '<td id="otd" align="center">';
						echo $i + 1;
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo $happy[$i]['id'];
						echo '</td>';
						echo '<td id="otd" align="left">';
						if ($this_week == $happy[$i]['a_week']){
							if ($today == $happy[$i]['a_watch']){
								// 今天看过了
								echo '<span style="color:#0AA34A;font-weight:bold;">' . $happy[$i]['a_name'] . '</span>';
							} else {
								// 今天没看过
								echo '<span style="color:#1655A5;font-weight:bold;">' . $happy[$i]['a_name'] . '</span>';
							}
						} else {
							// 非今天
							echo $happy[$i]['a_name'];
						}
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo $week[$happy[$i]['a_week']];
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo '<a href="index.php?id=' . $happy[$i]['id'] . '" class="web">' . $happy[$i]['a_count'] . '</a>';
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo $happy[$i]['a_watch'];
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo $happy[$i]['a_housou'];
						echo '</td>';
						echo '</tr>';
					}
				}
			?>
			</table>
			<form action="index.php" method="post">
				<input type="text" id="do_sql" name="do_sql" style="float:left;width:260px;font-size:18px;border:1px solid #CCCCCC;" />
				<input type="submit" class="btn" value="&nbsp;执&nbsp;行&nbsp;"/>
			</form>
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2015]</div>
	</body>
</html>
