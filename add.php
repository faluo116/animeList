<!DOCTYPE html>
<?php
define("TRUE_PATH",__DIR__ . "/");
require("core/Sqlite.php");
require("functions.php");
$db = new Sqlite(TRUE_PATH,'anime.db');
$id = 0;
// 新增
if (!empty($_GET['up'])){
	$a_title = $_POST['a_title'];
	$a_housou = $_POST['a_housou'];
	$a_week = $_POST['a_week'];
	$a_count = $_POST['a_count'];
	if (is_null($a_count) || "" == $a_count){
		$a_count = 0;
	}
	$a_tag = $_POST['a_tag'];
	$a_yandere_tag = $_POST['a_yandere'];
	$a_first = $_POST['a_first'];
	$a_step = $_POST['a_step'];
	$a_cover_img = $_POST['a_cover_img'];
	$a_content = $_POST['a_content'];

	$sql = "INSERT INTO happy 
	(a_name,
	a_week,
	a_count,
	a_housou,
	a_watch,
	a_tag,
	a_yandere_tag,
	a_first,
	a_step,
	a_content,
	a_cover_img) 
	VALUES 
	('" . $a_title . "',
	" . $a_week . ",
	" . $a_count . ",
	" . $a_housou . ",
	0,
	" . $a_tag . ",
	'" . $a_yandere_tag . "',
	0,
	7,
	'" . $a_content . "',
	'" . $a_cover_img . "'
	)";

	$db -> query_sql($sql,false);
	// back();
}
$week = get_week();
$housou = get_housou_info();
$this_week = this_week();
$this_week = $this_week == 0 ? 7 : $this_week;
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>我的番组</title>
		<link rel="shortcut icon" href="fac.png" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/ajaxUpload.js" type="text/javascript"></script>
		<script src="js/chosen.js" type="text/javascript"></script>
		<script src="js/anime.js" type="text/javascript"></script>
		<link href="css/anime.css" rel="stylesheet"/>
		<link href="css/chosen.css" rel="stylesheet"/>
	</head>
	<body style="background-color:#E2E2E2;overflow-x:hidden;">
		<div style="padding:16px;background-color:#FFFFFF;width:900px;height:auto;margin-left:auto;margin-right:auto;">
			<div style="color:#999999;font-weight:bold;font-size:28px;padding-bottom:16px;"><?php echo title();?></div>
			<div id="div_form">
				<div style="height:50px;">
					<div id="form_title">标题:</div>
					<div id="form_content"><input type="text" id="a_title" name="title" value="" class="form_inbox" placeholder="节目标题"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">放送:</div>
					<div id="form_content">
						<select data-placeholder="放送" name="a_housou" id="a_housou" class="chzn-select" style="width:310px;">
							<option value=""></option>
							<?php
								for($i = 1 ; $i <= count($housou) ; ++$i){
									echo "<option value=" . $i . ">" . $housou[$i][0] . "</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div style="height:50px;">
					<div id="form_title">周:</div>
					<div id="form_content">
						<select data-placeholder="周" name="a_week" id="a_week" class="chzn-select" style="width:310px;">
							<option value=""></option>
							<?php
								for($i = 1 ; $i < count($week) ; ++$i){
									if ($this_week == $i){
										echo "<option value=" . $i . " selected>" . $week[$i] . "</option>";
									} else {
										echo "<option value=" . $i . ">" . $week[$i] . "</option>";
									}
								}
							?>
						</select>
					</div>
				</div>
				<div style="height:50px;">
					<div id="form_title">集数:</div>
					<div id="form_content"><input type="text" id="a_count" name="a_count" value="0" class="form_inbox" placeholder="当前集数"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">首播日:</div>
					<div id="form_content"><input type="text" id="a_first" name="a_first" value="0" class="form_inbox" placeholder="第一集播出日期"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">步长:</div>
					<div id="form_content"><input type="text" id="a_step" name="a_step" value="7" class="form_inbox" placeholder="每X天更新一次"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">图片:</div>
					<div id="form_content"><input type="text" id="a_cover_img" name="a_cover_img" value="" class="form_inbox" readonly="true" onClick="hid('pop')" placeholder="封面图260X350"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">yande.re:</div>
					<div id="form_content"><input type="text" id="a_yandere" name="a_yandere" value="" class="form_inbox" placeholder="yande.re图床标签"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">备注:</div>
					<div id="form_content"><input type="text" id="a_content" name="a_content" value="" class="form_inbox" placeholder="输入备注"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">状态:</div>
					<div id="form_content">
						<select data-placeholder="状态" name="a_tag" id="a_tag" class="chzn-select" style="width:310px;">
							<option value=0>放送中</option>
							<option value=99>已完结</option>
						</select>
					</div>
				</div>
				<div style="height:50px;">
					<div id="form_title"><input type="button" class="btn" onclick="location.href='index.php'" value="&nbsp;返&nbsp;回&nbsp;"/></div>
					<div id="form_content"><input type="button" class="btn_submit" onclick="newAnime()" value="&nbsp;+&nbsp;保&nbsp;存&nbsp;并&nbsp;增&nbsp;加&nbsp;"/></div>
				</div>
			</div>
		</div>
		<div style="width:100%;text-align:center;padding:10px;color:#999999;">copyright:faluo[2016]</div>
		<!-- 图片上传弹出层 -->
		<div id="pop" class="popWindow">
            <div id="popTitle" class="popTitle">
                	上传封面
            </div>
            <div id="popBody" class="popBody">
                <div style="padding-left:5px;padding-top:20px;">
                    <a href="javascript:;" class="inputFile">
                        <input type="file" name="coverImg" id="coverImg" onchange="upImgTip();"/><snap id="imgTip">+点我选择一张封面</snap>
                    </a>
                    <br/></br/>
                    <input type="button" id="uploadBtn" class="btn_submit" style="font-size:15px;" name="uploadBtn" value="上&nbsp;&nbsp;传" onClick="return fileUpload();" />
				</div>
                <div id="popTip" class="popTip">!!封面图尺寸最好限制在260X350。</div>
            </div>
        </div>
	</body>
	<script type="text/javascript"> $(".chzn-select").chosen(); </script>
</html>
