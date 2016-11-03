<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("core/Sqlite.php");
require("functions.php");
$today = today();
$this_week = this_week();
$this_week = $this_week == 0 ? 7 : $this_week;
$week = get_week();
// $housou = get_housou();
$housou = get_housou_info();
$db = new Sqlite(TRUE_PATH,'anime.db');
$happy = null;
if (!empty($_POST['do_search'])){
	$kw = $_POST['do_search'];
	if (!is_null($kw)){
		// 直接执行SQL
		$happy = $db -> query_sql_result('SELECT * FROM happy WHERE a_name LIKE \'%' . $kw . '%\' ORDER BY id DESC');
	}
}
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
					<input type="button" class="btn" value="&nbsp;返&nbsp;回&nbsp;" onclick="location.href='index.php'"/>
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
						echo $happy[$i]['a_name'];
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
						echo '<a href="info.php?id=' . $happy[$i]['id'] . '" class="web" target="_blank">详情</a>';
						echo '&nbsp;&nbsp;';
						echo '<a href="modify_old.php?id=' . $happy[$i]['id'] . '" class="web" target="_blank">修改</a>';
						echo '</td>';
						echo '</tr>';
					}
				}
			?>
			</table>
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2016]</div>
	</body>
</html>
