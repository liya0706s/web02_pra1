<fieldset>
    <legend>目前位置:首頁 > 最新文章區</legend>
    <table style="width:95%;margin:auto">
        <tr>
            <th width="30%">標題</th>
            <th width="50%">內容</th>
            <th></th>
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
                    <!-- 文章標題游標放上去會是pointer -->
                    <div class='title' data-id="<?= $row['id']; ?>" style='cursor:pointer'>
                        <?= $row['title']; ?>
                    </div>
                </td>
                <td>
                    <!-- 字串中取部分 substr 從0開始取25個字 -->
                    <div id="s<?= $row['id']; ?>">
                        <?= mb_substr($row['news'], 0, 25); ?>...
                    </div>
                    <div id="a<?= $row['id']; ?>" style="display:none">
                        <?= $row['news']; ?>
                    </div>
                </td>
                <!-- 第三欄 根據登入狀態來顯示讚的程式 -->
                <td>
                    <?php
                    // 1.判斷有沒有登入，有登入才可以按讚
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
            echo "<a href='?do=news&p=$prev'> < </a>";
        }
        for ($i = 1; $i <= $pages; $i++) {
            $fontsize = ($now == $i) ? "font-size:20px" : "font-size:16px";
            echo "<a href='?do=news&p=$i' style='$fontsize'> $i </a>";
        }
        if (($now + 1) <= $pages) {
            $next = $now + 1;
            echo "<a href='?do=news&p=$next'> > </a>";
        }
        ?>
    </div>
</fieldset>

<script>
    /**
     * 新聞標題添加點擊事件，當點擊某個標題時，會切換該新聞的簡短和完整內容的顯示
     */

    // 對class title 進行點擊事件註冊
    $('.title').on('click', (e) => {
        // e.target是被點擊的DOM元素，$(e.target)將其轉換為jQuery對象
        // 取得點擊的id，獲取被點擊元素的data-id屬性值
        // 這個值通常用於識別哪一條新聞被點擊
        let id = $(e.target).data('id');

        // 將箭頭函數改為傳統的函數表達式如下:
        // $('.title').on('click',function(){
        //     let id=$(this).data('id');


        // 對id為 s+id,a+id 的元素進行toggle來切顯示與隱藏
        $(`#s${id},#a${id}`).toggle();
    });

    function good(news){
        $.post("./api/good.php",{news},()=>{
            // 使用重整頁面的方式來更新按讚的結果
            location.reload();
        })
    }
</script>