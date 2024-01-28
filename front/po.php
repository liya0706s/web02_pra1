<style>
    /* 分類網誌的排列不是inline,改成block */
    .type-item {
        display: block;
    }


    .types,
    .news-list {
        /* 分類網誌區塊和文章列表區塊是inline-block */
        display: inline-block;
        /* 兩者都垂直靠上對齊 */
        vertical-align: top;
    }

    .news-list {
        /* 將文章列表的寬度拉寬 */
        width: 600px;
    }
</style>
<!-- 建立一個麵包屑區塊，用來顯示當前的文章類別 -->
<div class="nav">
    目前位置:首頁 > 分類網誌 >
    <!-- 建立一個區塊用來放置 導航列中點擊到的 -->
    <span class="type">健康新知</span>
</div>
<!-- 建立分類項目區塊，其中data-type為設定分類標籤，和資料表中的type欄位一致 -->
<fieldset class="types">
    <legend>分類網誌</legend>
    <a class="type-item" data-type="1">健康新知</a>
    <a class="type-item" data-type="2">菸害防治</a>
    <a class="type-item" data-type="3">癌症防治</a>
    <a class="type-item" data-type="4">慢性病防治</a>
</fieldset>

<fieldset class="news-list">
    <legend>文章列表</legend>
    <!-- 建立一個區塊用來放置 文章標題列表 -->
    <div class="list-items" style="display:none"></div>
    <!-- 建立一個區塊用來放置 文章內容 -->
    <div class="article"></div>
</fieldset>

<script>
    // 建立分類項目點擊置換上方導引文字功能

    // init func 
    getList(1)
    // 註冊 .type-item 的點擊事件
    $(".type-item").on('click', function() {
        // 取出點擊的文字並放入導航列中
        $(".type").text($(this).text())

        // data-*屬性值，存放在變數中
        // 點擊同時取得分類項目的代號
        let type = $(this).data('type')

        // 執行取得分類文章列表函式
        getList(type)
    })

    // --------------------------------------------------

    // 取得分類列表函式
    // 定義getList函式
    function getList(type) {
        // 使用jQuery的get方法發送HTTP GET請求到"./api/get_list.php"，傳遞type參數
        $.get("./api/get_list.php", {
            type
        }, (list) => { // 返回的數據被存儲在名為list的變量中
            $(".list-items").html(list)
            // 總結來說，$(".list-items").html(list)這段代碼的作用，
            // 是將具有class="list-items"的元素內的HTML內容更新為list變量中的HTML內容。
            $(".article").hide();
            $(".list-items").show();
        })
    }

    function getNews(id) {
        $.get("./api/get_news.php", {
            id
        }, (news) => {
            $(".article").html(news)
            $(".article").show(); 
            // 文章出現
            $(".list-items").hide(); 
        })
    }
</script>