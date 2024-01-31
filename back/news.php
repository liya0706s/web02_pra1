<!-- 最新文章後台管理功能 -->
<form action="./api/edit_news.php" method="post">
    <table style="width:90%;text-align:center">
        <tr>
            <td>編號</td>
            <td style="width:80%;">標題</td>
            <td>顯示</td>
            <td>刪除</td>
        </tr>
        <?php
        // 計算有幾筆資料
        $total = $News->count();
        // 每頁有三筆
        $div = 3;
        // 總共的頁數是，總共的筆數除以3頁(取整數)，例如7筆/3=共三頁
        $pages = ceil($total / $div);
        // 現在的頁數是用GET傳值?p=xx, 否則是第一頁
        $now = $_GET['p'] ?? 1;
        // 每一頁開始的編號是(現在頁數-1)*3, 例如第三頁，(3-1)*3=6
        $start = ($now - 1) * $div;
        // news資料表中查詢所有資料限制從開始筆數，取三筆
        $rows = $News->all(" limit $start,$div");
        // 用迴圈的方式將所有筆數內容細分定義成 key-value($idx=>$row)
        foreach ($rows as $idx => $row) {
        ?>
            <tr>
                <!-- 編號是索引+1再加上每頁的第一個頁碼 -->
                <td><?= $idx + 1 + $start; ?></td>
                <td><?= $row['title']; ?></td>
                <td>
                    <input type="checkbox" name="sh[]" value="<?= $row['id']; ?>" <?= ($row['sh'] == 1) ? 'checked' : ''; ?>>
                </td>
                <td>
                    <input type="checkbox" name="del[]" value="<?= $row['id']; ?>">
                    <input type="hidden" name="id[]" value="<?= $row['id']; ?>">
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <div class="ct">
        <?php
        // 現在的頁數減一大於零，可以前一頁
        if ($now - 1 > 0) {
            $prev = $now - 1;
            echo "<a href='back.php?do=news&p=$prev'> < </a>";
        }
        // 從第一頁開始，小於等於所有的頁數，每次增加一頁
        for ($i = 1; $i <= $pages; $i++) {
            // 如果是現在頁數字型尺寸會是22px,否則是16px
            $size = ($i == $now) ? 'font-size:22px' : 'font-size:16px';
            // 用a標籤表示當前頁數的連結套上字型效果
            echo "<a href='back.php?do=news&p=$i' style='{$size}'> $i </a>";
        }
        // 假設現在的頁數+1<=總共的頁數 
        if ($now + 1 <= $pages) {
            $next = $now + 1;
            echo "<a href='back.php?do=news&p=$next'> > </a>";
        }
        ?>
    </div>
<div class="ct"><input type="submit" value="修改確定"></div>
</form>