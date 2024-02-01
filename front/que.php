<fieldset>
    <legend>目前位置:首頁 > 問卷調查</legend>
<table>
    <tr>
        <th width="10%">編號</th>
        <th width="60%">問卷題目</th>
        <th width="10%">投票總數</th>
        <th width="10%">結果</th>
        <th width="10%">狀態</th>
    </tr>
<?php
// 取出所有問卷的主題
$ques=$Que->all(['subject_id'=>0]);
foreach($ques as $key => $que){
?>
    <tr>
        <td><?=$key+1;?></td>
        <td><?=$que['text'];?></td>
        <td><?=$que['vote'];?></td>
        <td>
            <!-- 連結要加上主題資料的id -->
<a href="?do=result&id=<?=$que['id'];?>">結果</a>
        </td>
        <td>
            <?php
// 使用session來判斷使用者登入狀態
if(isset($_SESSION['user'])){
    echo "<a href='?do=vote&id={$que['id']}'"
}
            ?>
        </td>
    </tr>
    <?php
}
?>
</table>

</fieldset>
