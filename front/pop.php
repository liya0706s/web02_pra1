<fieldset>
    <legend>目前位置:首頁 > 人氣文章區</legend>
    <table style="width:95%;margin:auto">
        <tr>
            <th width="30%">標題</th>
            <th width="50%">內容</th>
            <th>人氣</th>
        </tr>
        <?php
        // 製作分頁
        $total = $News->count(['sh' => 1]);
        $div = 5;
        $pages = ceil($total / $div);
        // 判斷是否有GET網頁傳值的p，有的話就是該頁碼，否則是1
        $now = $_GET['p'] ?? 1;
        $start = ($now - 1) * $div;

        // 撈資料限制從開始頁取5筆
        // 更改排序的方式，只要更改取資料的sql語法即可
        $rows = $News->all(['sh' => 1], " order by `good` desc limit $start,$div");
        foreach ($rows as $row) {
        ?>
            <tr>
                <td>
                    <!-- pointer刪除改用js hover -->
                    <div class='title' data-id="<?= $row['id']; ?>">
                        <?= $row['title']; ?>
                    </div>
                </td>
                <!-- 字串中取部分 substr 從0開始取25個字 -->
                <!-- position:relative 呼應index style的absolute -->
                <td style="position: relative;">
                    <div>
                        <?= mb_substr($row['news'], 0, 25); ?>...
                    </div>
                    <!-- 完整的內容 -->
                    <div id="p<?= $row['id']; ?>" class="pop">
                        <h3 style='color:skyblue'><?= $row['title']; ?></h3>
                        <pre><?= $row['news']; ?></pre>
                    </div>
                </td>
                <!-- 在第三欄增加一個人氣的顯示 -->
                <!-- 數值的部分單獨使用一個span包起來，方便js處理 -->
                <td class="ct">
                    <span><?= $row['good']; ?></span>個人說
                    <img src="../icon/02B03.jpg" style="width:20px">
                </td>
                <!-- 根據登入狀態來顯示讚的程式 -->
                <td>
                    <?php
                    // 1.判斷有沒有登入
                    if (isset($_SESSION['user'])) {
                        // 2.判斷有沒有按過讚
                        // 傳遞給count方法的條件參數。這個參數是一個關聯陣列，代表著要搜尋的條件
                        // count($where='',$other='')
                        if ($Log->count(['news' => $row['id'], 'acc' => $_SESSION['user']]) > 0) {
                            // 如果大於0，表示在資料庫中找到了符合這些條件的記錄，已經按過讚
                            echo "<a href='Javascript:good({$row['id']})'>收回讚</a>";
                        } else {
                            echo "<a href='Javascript:good({$row['id']})'>讚</a>";
                        }
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <div>
        <?php
        if (($now - 1) > 0) {
            $prev = $now - 1;
            echo "<a href='?do=pop&p=$prev'> < </a>";
        }
        for ($i = 1; $i <= $pages; $i++) {
            $fontsize = ($now == $i) ? "font-size:20px" : "font-size:16px";
            echo "<a href='?do=pop&p=$i' style='$fontsize'> $i </a>";
        }
        if (($now + 1) <= $pages) {
            $next = $now + 1;
            echo "<a href='?do=pop&p=$next'> > </a>";
        }
        ?>
    </div>
</fieldset>

<script>
    // 點擊事件改為hover
    $(".title").hover(
        function() {
            // 滑鼠移過去，先將所有的pop隱藏起來
            $(".pop").hide()
            // 取得點擊的id
            let id = $(this).data("id")
            $("#p" + id).show();

        }
    )
</script>