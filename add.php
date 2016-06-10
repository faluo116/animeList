<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("core/Sqlite.php");
require("functions.php");
function today(){
    date_default_timezone_set('PRC');
	return date('ymd',time());
}
function this_week(){
    date_default_timezone_set('PRC');
	return date('w');
}
$today = today();
$this_week = this_week();
$this_week = $this_week == 0 ? 7 : $this_week;
$week = get_week();
$housou = get_housou_info();
$db = new Sqlite(TRUE_PATH,'anime.db');
if (!empty($_GET['id'])){
	$id = $_GET['id'];
	if (!is_null($id) && is_numeric($id)){
		// 标记
		$sql = "UPDATE happy SET a_count=a_count+1,a_watch=" . $today . " WHERE id=" . $id;
		$db -> query_sql($sql);
		header("Location:index.php");
		exit();
	}
}
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>我的番组</title>
		<link rel="shortcut icon" href="fac.png" />
		<link href="css/anime.css" rel="stylesheet"/>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:1000px;margin-left:auto;margin-right:auto;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;">Faluo's BannguMi Chart</div>
			
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2015]</div>
	</body>
</html>
