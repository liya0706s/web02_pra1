<?php
// 前台 問卷結果 顯示
// 根據網址參數id取得主題資料
$que = $Que->find($_GET['id'])

?>
<fieldset>
    <!-- text是標題  -->
    <legend>目前位置:首頁 > 問卷調查 <?= $que['text']; ?></legend>
    <!-- 標題用h3標籤 -->
    <h3><?= $que['text']; ?></h3>
    <?php
        //根據主題的id取得所有的選項
    $opts = $Que->all(['subject_id' => $_GET['id']]);
    foreach ($opts as $opt) {
        // 判斷總投票數是否為0，避免發生分母為0的錯誤
        // 如果投票數不為零，就是投票數值，反之是零的話讓它等於一
        $total = ($que['vote'] != 0) ? $que['vote'] : 1;

        // 計算選項票數/總票數的比例，四捨五入到小數點後兩位
        $rate = round($opt['vote'] / $total, 2);

        echo "<div style='width:95%;display:flex;align-items:center;margin:auto'>";
                // 放入選項的文字   
        echo    "<div style='width:65%'>{$opt['text']}</div>";
                // 依照計算的票數比例來計算長條圖長度
                // 使用.運算符，將計算結果轉換為字符串並串接到前面的字符串上
        echo    "<div style='width:" . (40 * $rate) . "%;height:20px;background-color:#ccc'></div>";
        echo    "<div style='width:10%'>{$opt['vote']}票(" . ($rate * 100) . "%)</div>";
        echo "</div>";
    }
    ?>
    <div class="ct">
        <button onclick="location.href='?do=que'">返回</button>
    </div>

</fieldset>