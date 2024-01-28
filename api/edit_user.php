<?php
include_once "db.php";

// 判斷是否有需要刪除的資料
// 檢查 $_POST 全局變數中是否存在鍵名為 'del' 的元素
if(isset($_POST['del'])){
    // 使用迴圈來刪除指定id的帳號資料
    foreach($_POST['del'] as $id){

        // 調用db.php中 $User 物件的 del 方法來刪除特定ID的資料
        $User->del($id);
    }
}
// 返回會員管理頁面
to("../back.php?do=admin");

?>