<?php
include_once "db.php";

// 根據表單資料取出被選擇的選項
$opt=$Que->find($_POST['opt']);


// 票數資料加1
$opt['vote']++;

// 更新選項資料
$Que->save($opt);

// 根據選項資料的subject_id欄位來取得主題資料
$sub=$Que->find($opt['subject_id']);

// 主題票數資料加1
$sub['vote']++;

// 更新主題資料
$Que->save($sub);

// 主題要加1,選項也要加1,因為累計之後算占比比較方便
// dd($opt);


to("../index.php?do=result&id={$sub['id']}");

?>