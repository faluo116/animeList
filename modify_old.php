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
		backToOld();
	} else {
		// 保存修改
		if (!empty($_GET['up'])){
			$a_title = $_POST['a_title'];
			$a_housou = $_POST['a_housou'];
			$a_week = $_POST['a_week'];
			$a_count = $_POST['a_count'];
			$a_tag = $_POST['a_tag'];
			$a_yandere_tag = $_POST['a_yandere'];
			$a_first = $_POST['a_first'];
			$a_step = $_POST['a_step'];
			$a_cover_img = $_POST['a_cover_img'];
			$a_content = $_POST['a_content'];
			$sql = "UPDATE happy SET
			a_name='" . $a_title . "',
			a_week=" . $a_week . ",
			a_housou=" . $a_housou . ",
			a_count=" . $a_count . ",
			a_tag=" . $a_tag . ",
			a_yandere_tag='" . $a_yandere_tag . "',
			a_first=" . $a_first . ",
			a_step=" . $a_step . ",
			a_content='" . $a_content . "',
			a_cover_img='" . $a_cover_img . "' 
			WHERE id=" .$id;
			$db -> query_sql($sql,false);
			backToOld();
		}
	}
} else {
	backToOld();
}
$week = get_week();
$housou = get_housou_info();
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
					<div id="form_title">ID:</div>
					<div id="form_content"><?php echo $id;?><input type="hidden" id="id" value="<?php echo $id;?>" /></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">标题:</div>
					<div id="form_content"><input type="text" id="a_title" name="title" value="<?php echo $happy[0]['a_name']?>" class="form_inbox" placeholder="节目标题"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">放送:</div>
					<div id="form_content">
						<select data-placeholder="放送" name="a_housou" id="a_housou" class="chzn-select" style="width:310px;">
							<option value=""></option>
							<?php
								for($i = 1 ; $i <= count($housou) ; ++$i){
									if ($happy[0]['a_housou'] == $i){
										echo "<option value=" . $i . " selected>" . $housou[$i][0] . "</option>";
									} else {
										echo "<option value=" . $i . ">" . $housou[$i][0] . "</option>";
									}
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
									if ($happy[0]['a_week'] == $i){
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
					<div id="form_content"><input type="text" id="a_count" name="a_count" value="<?php echo $happy[0]['a_count']?>" class="form_inbox" placeholder="当前集数"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">首播日:</div>
					<div id="form_content"><input type="text" id="a_first" name="a_first" value="<?php echo $happy[0]['a_first']?>" class="form_inbox" placeholder="第一集播出日期"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">步长:</div>
					<div id="form_content"><input type="text" id="a_step" name="a_step" value="<?php echo $happy[0]['a_step']?>" class="form_inbox" placeholder="每X天更新一次"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">图片:</div>
					<div id="form_content"><input type="text" id="a_cover_img" name="a_cover_img" value="<?php echo $happy[0]['a_cover_img']?>" class="form_inbox" readonly="true" onClick="hid('pop')" placeholder="封面图260X350"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">yande.re:</div>
					<div id="form_content"><input type="text" id="a_yandere" name="a_yandere" value="<?php echo $happy[0]['a_yandere_tag']?>" class="form_inbox" placeholder="yande.re图床标签"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">备注:</div>
					<div id="form_content"><input type="text" id="a_content" name="a_content" value="<?php echo $happy[0]['a_content']?>" class="form_inbox" placeholder="输入备注"/></div>
				</div>
				<div style="height:50px;">
					<div id="form_title">状态:</div>
					<div id="form_content">
						<select data-placeholder="状态" name="a_tag" id="a_tag" class="chzn-select" style="width:310px;">
							<?php 
							if ($happy[0]['a_tag'] == 0){
								echo "<option value=0 selected>放送中</option>";
								echo "<option value=99>已完结</option>";
							} else {
								echo "<option value=0>放送中</option>";
								echo "<option value=99 selected>已完结</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div style="height:50px;">
					<div id="form_title"><input type="button" class="btn" onclick="location.href='over.php'" value="&nbsp;放&nbsp;弃&nbsp;"/></div>
					<div id="form_content"><input type="button" class="btn_submit" onclick="checkFormOld()" value="&nbsp;+&nbsp;保&nbsp;存&nbsp;"/></div>
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
