<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("Sqlite.php");
require("functions.php");
function checkdb(){
	$dbpath = TRUE_PATH . 'anime.db';
	if (!file_exists($dbpath)){
		// 建库建表
		$ddl_happy = "CREATE TABLE happy (id INTEGER PRIMARY KEY AUTOINCREMENT, a_name VARCHAR(0,255) DEFAULT (''), a_week INTEGER DEFAULT (0), a_count INTEGER DEFAULT (0), a_housou VARCHAR(0,255) DEFAULT (''), a_watch INTEGER DEFAULT (0)),a_tag INTEGER DEFAULT (0);";
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
$this_week = $this_week == 0 ? 7 : $this_week;
$week = get_week();
// $housou = get_housou();
$housou = get_housou_info();
$db = new Sqlite(TRUE_PATH,'anime.db');
if (!empty($_POST['a_n'])){
	$a_n = $_POST['a_n'];
	if (!is_null($a_n)){
		// 添加
		$a_w = $_POST['a_w'];
		$a_h = $_POST['a_h'];
		// var_dump($a_w);
		// var_dump($a_h);
		$sql = "insert into happy (a_name,a_week,a_count,a_housou,a_watch,a_tag) values ('" . $a_n . "'," . $a_w . ",0," . $a_h . ",0,0)";
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
if (!empty($_GET['end'])){
	$end = $_GET['end'];
	if (!is_null($end) && is_numeric($end)){
		// 完结
		$sql = "update happy set a_tag=99 where id=" . $end;
		$db -> query_sql($sql);
		header("Location:index.php");
		exit();
	}
}
if (!empty($_GET['del'])){
	$del = $_GET['del'];
	if (!is_null($del) && is_numeric($del)){
		// 删除
		$sql = "update happy set a_tag=10 where id=" . $del;
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
$happy = $db -> query_sql_result('select * from happy where a_tag = 0 order by a_week');
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Anime</title>
		<link rel="shortcut icon" href="fac.png" />
		<link href="anime.css" rel="stylesheet"/>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:1000px;margin-left:auto;margin-right:auto;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;">Faluo's Anime Chart</div>
			<div style="line-height:50px;">
				<span style="float:left;">
					<form action="index.php" method="post">
						<input type="text" id="a_n" name="a_n" style="width:260px;font-size:18px;border:1px solid #CCCCCC;"/>
						<select id="a_w" name="a_w" style="font-size:18px;margin-left:3px;"><?php
							for ($i = 1 ; $i < count($week) ; ++$i){
								echo '<option value="' . $i . '">' . $week[$i] . '</option>';
							}
							?></select><select id="a_h" name="a_h" style="font-size:18px;margin-left:3px;"><?php
							for ($i = 1 ; $i < count($housou) ; ++$i){
								echo '<option value="' . $i . '">' . $housou[$i][0] . '</option>';
							}
							?></select><input type="submit" class="btn" value="&nbsp;保&nbsp;存&nbsp;"/>
					</form>
				</span>
				<span style="float:right;">
					<input type="button" class="btn" value="&nbsp;已&nbsp;完&nbsp;结&nbsp;" onclick="location.href='over.php'"/>
				</span>
			</div>
            <table width="100%" id="order" style="margin-top:20px;margin-bottom:20px;">
                <tr align="left">
                    <th id="otd">#</th>
                    <th id="otd">ID</th>
                    <th id="otd">名称</th>
                    <th id="otd">周</th>
                    <th id="otd">集数</th>
                    <th id="otd">最后观看</th>
                    <th id="otd">放送</th>
					<th id="otd"></th>
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
						// 放送
						echo $housou[$happy[$i]['a_housou']][0];
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo '<a href="index.php?end=' . $happy[$i]['id'] . '" class="web">完结</a>&nbsp;&nbsp;<a href="index.php?del=' . $happy[$i]['id'] . '" class="web" onclick="return cofirm(\'真的要删除吗？\')">删除</a>';
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
