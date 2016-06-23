<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("core/Sqlite.php");
require("functions.php");
function checkdb(){
	$dbpath = TRUE_PATH . 'anime.db';
	if (!file_exists($dbpath)){
		// 建库建表
		$ddl_happy = "CREATE TABLE happy (id INTEGER PRIMARY KEY AUTOINCREMENT, 
		a_name VARCHAR(0,255) DEFAULT (''), 
		a_week INTEGER DEFAULT (0), 
		a_count INTEGER DEFAULT (0), 
		a_housou VARCHAR(0,255) DEFAULT (''), 
		a_watch INTEGER DEFAULT (0)),
		a_tag INTEGER DEFAULT (0),
		a_yandere_tag TEXT DEFAULT (''),
		a_first INTEGER DEFAULT (0),
		a_step INTEGER DEFAULT (0),
		a_content TEXT DEFAULT (''),
		a_cover_img TEXT DEFAULT ('')";
		$db = new Sqlite(TRUE_PATH,'anime.db');
		$db -> query_sql($ddl_happy);
	}
}
checkdb();
$today = today();
$this_week = this_week();
$this_week = $this_week == 0 ? 7 : $this_week;
$week = get_week();
// $housou = get_housou();
$housou = get_housou_info();
$db = new Sqlite(TRUE_PATH,'anime.db');
if (!empty($_GET['id'])){
	$id = $_GET['id'];
	if (!is_null($id) && is_numeric($id)){
		// 标记
		$sql = "UPDATE happy SET a_count=a_count+1,a_watch=" . $today . " WHERE id=" . $id;
		$db -> query_sql($sql);
		back();
	}
}
if (!empty($_POST['do_sql'])){
	$do_sql = $_POST['do_sql'];
	if (!is_null($do_sql)){
		// 直接执行SQL
		if ('clear' == $do_sql){
			// 彻底清表
			$db -> query_sql('DELETE FROM happy');
			// $db -> query_sql('update sqlite_sequence set seq=0 where name=\'happy\'');
		} else {
			$db -> query_sql($do_sql);
		}
		back();
	}
}
$happy = $db -> query_sql_result('SELECT * FROM happy WHERE a_tag = 0 ORDER BY a_week');
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>我的番组</title>
		<link rel="shortcut icon" href="fac.png" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/chosen.js" type="text/javascript"></script>
		<script src="js/anime.js" type="text/javascript"></script>
		<link href="css/anime.css" rel="stylesheet"/>
		<link href="css/chosen.css" rel="stylesheet"/>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:auto;margin-left:auto;margin-right:auto;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;"><?php echo title();?></div>
			<div style="line-height:50px;">
				<span style="float:right;">
					<input type="button" class="btn_submit" value="&nbsp;增&nbsp;加&nbsp;" onclick="location.href='add.php'"/>
				</span>
				<span style="float:right;">
					<input type="button" class="btn" value="&nbsp;已&nbsp;完&nbsp;结&nbsp;" onclick="location.href='over.php'"/>
				</span>
			</div>
            <table width="100%" id="order" style="margin-top:20px;margin-bottom:20px;">
                <tr align="left">
                    <th id="otd">#</th>
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
						echo to_chinese_date($happy[$i]['a_watch']);
						echo '</td>';
						echo '<td id="otd" align="center">';
						// 放送
						echo $housou[$happy[$i]['a_housou']][0];
						echo '</td>';
						echo '<td id="otd" align="center">';
						echo '<a href="info.php?id=' . $happy[$i]['id'] . '" class="web" target="_blank">详情</a>&nbsp;&nbsp;<a href="modify.php?id=' . $happy[$i]['id'] . '" class="web">修改</a>';
						echo '</td>';
						echo '</tr>';
					}
				}
			?>
			</table>
			<form action="index.php" method="post">
				<input type="text" id="do_sql" name="do_sql" class="inbox" />
				<input type="submit" class="btn" value="&nbsp;执&nbsp;行&nbsp;"/>
			</form>
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2015]</div>
	</body>
	<script type="text/javascript"> $(".chzn-select").chosen({disable_search:true}); </script>
</html>
