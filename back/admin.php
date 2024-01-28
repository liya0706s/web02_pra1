<fieldset>
    <legend>帳號管理</legend>
    <form action="./api/edit_user.php" method="post">
        <table style="width:55%;margin:auto;text-align:center">
            <tr>
                <td class="clo">帳號</td>
                <td class="clo">密碼</td>
                <td class="clo">刪除</td>
            </tr>
            <?php
            // user表單中的所有資料撈出來，放到$rows變數裡
            $rows = $User->all();
            // 用迴圈把 $rows 一個個帶入 $row
            foreach ($rows as $row) {
                // 判斷將每個帳號列出來，除了管理者 'adimn' 帳號密碼 
                if ($row['acc'] != 'admin') {
            ?>
                    <tr>
                        <td><?= $row['acc']; ?></td>
                        <!-- 取得$row['pw']的多字節字串長度，然後生成一個相同數量的星號組成的字符串 -->
                        <td><?= str_repeat("*", mb_strlen($row['pw'])); ?></td>
                        <td>
                            <input type="checkbox" name="del[]" value="<?= $row['id']; ?>">
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
        <div class="ct">
            <input type="submit" value="確定清除">
            <input type="reset" value="清空選取">
        </div>
    </form>
</fieldset>

<h2>新增會員</h2>
<span style="color:red">*請設定您要註冊的帳號及密碼(最長12個字元)</span>
<table>
    <tr>
        <td class="clo">Step1:登入帳號</td>
        <td><input type="text" name="acc" id="acc"></td>
    </tr>
    <tr>
        <td class="clo">Step2:登入密碼</td>
        <td><input type="password" name="pw" id="pw"></td>
    </tr>
    <tr>
        <td class="clo">Step3:再次確認密碼</td>
        <td><input type="password" name="pw2" id="pw2"></td>
    </tr>
    <tr>
        <td class="clo">Step4:信箱(忘記密碼時使用)</td>
        <td><input type="text" name="email" id="email"></td>
    </tr>
    <tr>
        <td>
            <input type="button" value="註冊" onclick="reg()">
            <input type="reset" value="清除">
        </td>
        <td></td>
    </tr>
</table>

<script>
    // 檢查帳號是否已被使用，
    // 確認申請的帳號在資料表中是不重覆的，
    // 才會把表單資料送到後端去進行資料表新增會員資料的動作
    function reg() {
        // 取得使用者輸入的帳號、密碼、確認密碼和電子信箱
        let user = {
            acc: $("#acc").val(),
            pw: $("#pw").val(),
            pw2: $("#pw2").val(),
            email: $("#email").val()
        }

        // 檢查使用者輸入的資訊是否完整
        if (user.acc != '' && user.pw != '' && user.pw2 != '' && user.email != '') {
            // 檢查密碼和確認密碼是否相符
            if (user.pw == user.pw2) {
                // 發送 POST 請求檢查密碼是否重覆
                $.post("./api/chk_acc.php", {
                    acc: user.acc
                }, (res) => {
                    // 如果回傳值的結果為1,表示帳號重覆
                    if (parseInt(res) == 1) {
                        alert("帳號重覆")
                    } else {
                        // 發送 POST 請求進行註冊
                        $.post("../api/reg.php", user, (res) => {
                            // 註冊完成時直接重整頁面，不用跳出註冊成功通知
                            location.reload()
                        })
                    }
                })
            } else {
                alert("密碼錯誤")
            }
        } else {
            alert("不可空白")
        }
    }
</script>