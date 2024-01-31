<?php
include_once "db.php";

/**
 * 處理文章編輯表單傳過來的資料
 */

// 檢查是否有設定 $_POST['id']
if(isset($_POST['id'])){
    // 使用迴圈來巡訪 $_POST['id']陣列 
    foreach($_POST['id'] as $id){
        // 檢查是否有設定 $_POST['del'] 且 $id 在 $_POST['del']陣列中 
        if(isset($_POST['del']) && in_array($id,$_POST['del'])){
            // 呼叫 News 物件的 del() 方法刪除新聞
            $New->del($id);
        }else{
            // 取得指定id的新聞資料
            $news=$News->find($id)
        }
    }
}

?>