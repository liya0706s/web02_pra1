<?php
include_once "db.php";

// 從數據庫中檢索所有符合條件的新聞行。
// $_GET['type'] 從URL中獲取的'type'參數，用於指定要查詢的新聞類型。
// 'sh'=>1 指定只選擇那些'sh'（可能是“顯示”或類似的標記）為1的新聞。
$rows = $News->all(['type' => $_GET['type'], 'sh' => 1]);
// <a href="javascript:getNews(2)">jioajekj</a><a href=""></a><a href=""></a>
// 遍歷每一行新聞。
foreach ($rows as $row) {
    // 為每一條新聞生成一個可點擊的連結。
    // {$row['id']} 使用每條新聞的唯一ID來生成JavaScript函數getNews的調用。
    // 該連結在點擊時將執行JavaScript函數getNews，並將新聞的ID作為參數傳遞。
    echo "<a href='Javascript:getNews({$row['id']})' style='display:block'>";
    
    // 輸出新聞標題。
    echo $row['title'];
    
    echo "</a>";
}
