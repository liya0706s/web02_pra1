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

    // 註冊 .type-item 的點擊事件
    $(".type-item").on('click',function(){
        // 取出點擊的文字並放入導航列中
        $('.type').text($(this).text())
        
        // 點擊同時取得分類項目的代號
        let type=$(this).data('type')

        // 執行取得分類文章列表函式
        getList(type)
    })

    
</script>