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
        7 => array('PPTV','')
    );
}
?>