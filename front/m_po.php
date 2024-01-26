<style>
    .type-item {
        display: block;
    }

    .types,
    .news-list {
        display: inline-block;
        vertical-align: top;
        /* 垂直靠上對齊 */
    }

    .news-list {
        width: 600px;
    }
</style>
<div class="nav">目前位置: 首頁 > 分類網誌 >
    <span class="type">健康新知</span>
</div>

<fieldset class="types">
    <legend>分類網誌</legend>
    <!-- data-id自定義類別代碼 -->
    <a class="type-item" data-id="1">健康新知</a>
    <a class="type-item" data-id="2">菸害防治</a>
    <a class="type-item" data-id="3">癌症防治</a>
    <a class="type-item" data-id="4">慢性病防治</a>
</fieldset>

<fieldset class="news-list">
    <legend>文章列表</legend>
    <!-- 點選向後端拿文章資料 -->
    <div class="list-items">
        <!-- <a href="javascript:getNews(2)">jioajekj</a><a href=""></a><a href=""></a> -->
    </div>
    <div class="article"></div>
</fieldset>

<script>
    // init func
    getList(1);
    // 點下a連結，會更換上方路徑的名稱
    // 為class為"type-item"的所有元素設置點擊事件監聽器。
    $(".type-item").on('click', function() {
        $(".type").text($(this).text())
        // 將class為"type"的元素的文本設置為 被點擊的元素的文本。

        // .data會是純數字比較完整物件
        // 獲取被點擊元素的data-id屬性值，並將其存儲在變量type中。
        let type = $(this).data('id')
        getList(type) // 使用該type值調用getList函數
    })

    // 定義getList函數。
    function getList(type) {
        // 使用jQuery的get方法發送HTTP GET請求到"./api/get_list.php"，並傳遞type參數。
        $.get("./api/get_list.php", {type}, (list) => { // 拿到列表list
            // 欄位和值一樣type:type 傳送到下一個地方是GET type
            // 當請求成功時，將返回的數據設置為class為"list-items"的元素的HTML內容
            $(".list-items").html(list)
            $(".article").hide()
            $(".list-items").show()
        });
    }

    function getNews(id) {
        $.get("./api/get_news.php", {id}, (news) => {
            $(".article").show()
            $(".list-items").hide()
        })
    }
</script>