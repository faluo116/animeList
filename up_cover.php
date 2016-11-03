<?php
require("functions.php");

if ($_FILES["coverImg"]["error"] > 0){
    echo "error";
} else {
    if ($_FILES["coverImg"]["type"] != 'image/jpeg' && $_FILES["coverImg"]["type"] != 'image/pjpeg'){
        echo '只能上传jpg格式：' . $_FILES["fn"]["type"];
	} else {
        $path = '/img/' . today() . '/';

        $name = timeNow() . '.jpg';

        $coverToShow = today() . '/' . timeNow() . '.jpg';

        // 判断目录是否创建
        if (!file_exists(__DIR__ . $path)){
            $r = mkdir(__DIR__ . $path);
            if (!$r){
                echo "目录创建失败：" . __DIR__ . $path;
            }
        }
        // 上传
        move_uploaded_file($_FILES["coverImg"]['tmp_name'] , __DIR__ . $path . $name);
        echo $coverToShow;
    }
}
?>