<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("core/Sqlite.php");
require("functions.php");
$db = new Sqlite(TRUE_PATH,'anime.db');
$happy = null;
$id = 0;
if (!empty($_GET['id'])){
	$id = $_GET['id'];
	$happy = $db -> query_sql_result('SELECT * FROM happy WHERE id=' . $id);
	if (null == $happy){
		back();
	}
} else {
	back();
}
$week = get_week();
$housou = get_housou_info();
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>我的番组</title>
		<link rel="shortcut icon" href="fac.png" />
		<link href="css/anime.css" rel="stylesheet"/>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:auto;margin-left:auto;margin-right:auto;overflow:hidden;zoom:1;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;"><?php echo title();?></div>
				<div id="div_form" style="float:left;">
					<div style="height:50px;">
						<div id="form_title">ID:</div>
						<div id="form_content"><?php echo $id;?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">标题:</div>
						<div id="form_content"><?php echo $happy[0]['a_name']?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">放送:</div>
						<div id="form_content"><?php echo $housou[$happy[0]['a_housou']][0]?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">周:</div>
						<div id="form_content"><?php echo $week[$happy[0]['a_week']];?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">集数:</div>
						<div id="form_content"><?php echo $happy[0]['a_count']?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">首播日:</div>
						<div id="form_content"><?php echo $happy[0]['a_first']?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">步长:</div>
						<div id="form_content"><?php echo $happy[0]['a_step']?></div>
					</div>
					<div style="height:50px;">
						<div id="form_title">yande.re:</div>
						<div id="form_content">
						<?php
							if ("" == $happy[0]['a_yandere_tag']){
								echo "无";
							} else {
								echo $happy[0]['a_yandere_tag'] . "[<a href=\"https://yande.re/post?tags=" . $happy[0]['a_yandere_tag'] . "\" class=\"web\" target=\"_blank\">图</a>]";
							}
						?>
						</div>
					</div>
					<div style="height:50px;">
						<div id="form_title">备注:</div>
						<div id="form_content">
						<?php
							if ("" == $happy[0]['a_content']){
								echo "无";
							} else {
								echo $happy[0]['a_content'];
							}
						?>
						</div>
					</div>
				</div>
				<div id="div_form" style="float:left;margin-left:120px;">
				<?php
					if ("" == $happy[0]['a_cover_img']){
						echo "<img src=\"img/260.jpg\" alt=\"img\" style=\"width:260px;height:350px;\">";
					} else {
						echo "<img src=\"img/" . $happy[0]['a_cover_img'] . "\" alt=\"img\" style=\"width:260px;height:350px;\">";
					}
				?>
				</div>
			</div>
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2016]</div>
	</body>
</html>
