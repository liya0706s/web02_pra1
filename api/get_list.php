<?php
include_once "./db.php";

// 取得所有指定分類的文章
$rows=$News->all(['type'=>$_GET['type'],'sh'=>1]);

// 使用迴圈來印出title文字及link內容
foreach($rows as $row){
    // 在點擊title連結時的執行，取得文章內容的函式，並傳入文章id
    echo "<a href='Javascript:getNews({$row['id']})'>";
    echo $row['title'];
    echo "</a>";
}


?>

