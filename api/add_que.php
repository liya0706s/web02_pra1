<?php
include_once "db.php";

// 判斷問卷主題是否存在
if (isset($_POST['subject'])) {

    // 新增主題資料，根據 que 資料表中的欄位，用$Que物件save()方法儲存進資料表
    $Que->save(
        [
            'text' => $_POST['subject'],
            'subject_id' => 0,
            'vote' => 0
        ]
    );

    // 根據剛才新增的主題資料去找到 主題的id
    $subject_id = $Que->find(['text' => $_POST['subject']])['id'];

    // 或是使用max()找到最大的id
    // $subject_id=$Que->max('id');
}

// 判斷選項是否正確
if (isset($_POST['option'])) {
    // 使用迴圈來巡訪 $_POST['option'] 陣列
    foreach ($_POST['option'] as $option) {
        // 新增選項資料 save($array)
        $Que->save([
            'text' => $option,
            'subject_id' => $subject_id,
            'vote' => 0
        ]);
    }
}
// 導回後台管理頁面
to("../back.php?do=que");