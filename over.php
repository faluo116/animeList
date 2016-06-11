<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("core/Sqlite.php");
require("core/Page.php");
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
$happy = $db -> query_sql_result('select * from happy where a_tag = 99 order by a_week');
$pageId = 0;
// 每页显示15条记录
$count_pre_page = 15;
// 页码数
$page_count = 8;
$c = count($happy);
// 当前页面地址是?list，显示8个页码，每页15条数据
$page = new MafuyuPage('?',$page_count,$count_pre_page);
$page -> set_total_count($c);
$page -> set_css_span('normal');
$page -> set_css_span_right_how('right_now');
$pageId = 0;
if (null != $_GET['p'] && !empty($_GET['p'])){
    $pageId = $_GET['p'];
}
if (!is_numeric($pageId)){
	$pageId = 0;
}
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>我的番组</title>
		<link rel="shortcut icon" href="fac.png"/>
		<link href="css/anime.css" rel="stylesheet"/>
        <link href="css/page.css" rel="stylesheet"/>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:1000px;margin-left:auto;margin-right:auto;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;"><?php echo title();?></div>
			<div style="line-height:50px;float:right;"><input type="button" class="btn" value="&nbsp;返&nbsp;回&nbsp;" onclick="location.href='index.php'"/></div>
            <table width="100%" id="order" style="margin-top:20px;margin-bottom:20px;">
                <tr align="left">
                    <th id="otd">#</th>
                    <th id="otd">ID</th>
                    <th id="otd">名称</th>
                    <th id="otd">集数</th>
                    <th id="otd">放送</th>
					<th id="otd"></th>
                </tr>
			<?php
                $s = $pageId * $count_pre_page;
                $e = $s + $count_pre_page;
                if ($e > $c){
                    $e = $c;
                }
				for ($i = $s ; $i < $e ; ++$i){
					echo '<tr class="hline">';
					echo '<td id="otd" align="center">';
					echo $i + 1;
					echo '</td>';
					echo '<td id="otd" align="center">';
					echo $happy[$i]['id'];
					echo '</td>';
					echo '<td id="otd" align="left">';
					echo $happy[$i]['a_name'];
					echo '</td>';
					echo '<td id="otd" align="center">';
					echo $happy[$i]['a_count'];
					echo '</td>';
					echo '<td id="otd" align="center">';
					echo $housou[$happy[$i]['a_housou']][0];
					echo '</td>';
					echo '<td id="otd" align="center">';
					echo '<a href="info.php?id=' . $happy[$i]['id'] . '" class="web" target="_blank">详情</a>';
					echo '</td>';
					echo '</tr>';
				}
			?>
			</table>
            <?php echo '<br/>' . $page -> page_str($pageId);?>
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2015]</div>
	</body>
</html>
