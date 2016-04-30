<?php

/**
  *简单的分页
  *
  *coryright:2015 mafuyu
  *ver:0310
  *
  *使用方法:
  *详见page-demo.php
  *
  */
class MafuyuPage{

// 每页显示的条数	
private $count_pre_page = 20;

// $page_str:要访问的PHP页面
private $page_str = '';

// $css_span:页码的CSS样式
private $css_span = '';

// $css_span_right_now:当前页的CSS样式
private $css_span_right_now = '';

// $show_page_count:页面中最多显示几条页码
private $show_page_count = 10;

// 总数据量
private $total_count = 0;

// 构造函数
// 当前的页面名称,页面最多显示几条页码,每页显示行数
function __construct($page_str,$show_page_count = 10,$count_pre_page = 20){
	$this -> page_str = $page_str;
	$this -> show_page_count = $show_page_count;
	$this -> count_pre_page = $count_pre_page;
}

// 页码的CSS样式
public function set_css_span($css_span){
	$this -> css_span = $css_span;
}

// 当前页的CSS样式
public function set_css_span_right_how($css_span_right_now){
	$this -> css_span_right_now = $css_span_right_now;
}

// 总数据量
public function set_total_count($total_count){
	$this -> total_count = $total_count;
}

// 返回总页数
private function page_count(){
    if ($this -> total_count <= 0 || $this -> count_pre_page <= 0 || $this -> total_count <= $this -> count_pre_page){
        return 1;
    }
    return ceil($this -> total_count / $this -> count_pre_page);
}

// 分页字符串
// $page_now:当前页码
// $s:分割符号.默认=.既p=1
public function page_str($page_now,$s = '='){
	$page_count = $this -> page_count();
    if ($page_count <= 0 || is_null($this -> page_str)){
		echo 'page_count=' . $page_count . '<br/>';
		var_dump($this->page_str);
        return '';
    }
    // 为什么要$page_now+1?因为页码是从“0”开始的
    if ($page_now < 0 || $page_now + 1 > $page_count){
        $page_now = 0;
    }
	$show_page_count = $this -> page_count();
    if ($show_page_count < 3){
        $show_page_count = 3;
    }
    if ($show_page_count > $page_count){
        $show_page_count = $page_count;
    }
    $str = '';
    $tmp = floor($show_page_count / 2);
    $page_start = $page_now - $tmp;    // 显示的开始页码
    $page_end = $page_start + $show_page_count;  // 显示的结束页码
    if ($page_start < 0){
        $page_start = 0;
    }
    if ($page_end - $page_start < $show_page_count){
        // 刚开始的几页,显示的页码明显小于要求显示的总页码
        $page_end = $page_end + ($show_page_count - ($page_end - $page_start));
    }
    if ($page_end > $page_count){
        $page_end = $page_count;
    }
    // $str = '(' . ($page_now + 1) . '/' . $page_count . ')';
    if ($page_now > 0){
        $str = $str . '<span id="page" class="' . $this -> css_span . '" style="padding-left:6px;padding-right:6px;" onclick="location.href=\'' . $this -> page_str .'p' . $s . '0\'">首</span>';
    }
    for ($i = $page_start ; $i < $page_end ; $i++){
        if ($i == $page_now ){
            $str = $str . '<span id="page" class="' . $this -> css_span_right_now . '">' . ($page_now + 1) . '</span>';
        } else {
            $str = $str . '<span id="page" class="' . $this -> css_span . '" onclick="location.href=\'' . $this -> page_str . 'p' . $s . $i . '\'">' . ($i + 1) . '</span>';
        }
    }
    // 想想这里为什么要-1？上面有提示了的
    if ($page_now < $page_count - 1){
        $str = $str . '<span id="page" class="' . $this -> css_span . '" style="padding-left:6px;padding-right:6px;" onclick="location.href=\'' . $this -> page_str . 'p' . $s . ($page_count - 1) . '\'">尾</span>';
    }
    return $str;
}

}

?>
