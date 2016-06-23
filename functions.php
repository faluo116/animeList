<?php
function get_week(){
    return array('Err','一','二','三','四','五','六','日');
}

function get_housou(){
    return array('Err','bilibili','tudou','271','letv','sohu','tencent','pptv');
}

function get_housou_info(){
    return array(
        1 => array('B站','http://www.bilibili.tv'),
        2 => array('优酷土豆','http://www.tudou.com'),
        3 => array('爱奇艺',''),
        4 => array('乐视',''),
        5 => array('搜狐视频',''),
        6 => array('腾讯视频',''),
        7 => array('PPTV',''),
        8 => array('无[补录]','')
    );
}

function to_chinese_date($d){
    if (empty($d)){
        return "尚未观看";
    }
    $month = substr($d,2,2);
    $date = substr($d,4,2);
    return $month . "月" . $date . "日";
}

function back(){
    header("Location:index.php");
	exit();
}

function title(){
    return "Faluo's Bangumi Chart";
}

function today(){
    date_default_timezone_set('PRC');
	return date('ymd',time());
}

function this_week(){
    date_default_timezone_set('PRC');
	return date('w');
}
?>