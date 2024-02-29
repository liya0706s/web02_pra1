<fieldset>
    <legend>忘記密碼</legend>
    <div>請輸入信箱以查詢密碼</div>
    <div>
        <input type="text" name="email" id="email">
    </div>
    <div id="result"></div>
    <div>
        <button onclick="forget()">尋找</button>
    </div>a
</fieldset>

<script>
    function forget(){
        // 使用 jQuery 的 $.get 方法發起一個 GET 請求到 "./api/forget.php" 這個URL
        // 向服務器傳送一個名為 email 的參數，其值為 id 為 "email" 的輸入框中的值
        $.get("../api/forget.php",{email:$("#email").val()},(res)=>{
            // 當請求成功並收到回應後，將回應的內容 (res) 顯示在 id 為 "result" 的 div 元素內
            // 這裡的 res 是服務器響應的數據，可能包含用戶的密碼或者一條錯誤的訊息
            $("#result").text(res)
        })
    }
</script>