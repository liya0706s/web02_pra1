<!-- 最新文章後台管理功能 -->
<form action="./api/edit_news.php" method="post">
<table>
    <tr>
        <td>編號</td>
        <td>標題</td>
        <td>顯示</td>
        <td>刪除</td>
    </tr>
    <?php
// 計算有幾筆資料
$total=$News->count();
// 每頁有三筆
$div=3;
// 總共的頁數是，總共的筆數除以3頁(取整數)，例如7筆/3=共三頁
$pages=ceil($total/$div);
// 現在的頁數是用GET傳值?p=xx, 否則是第一頁
$now=$_GET['p']??1;
// 每一頁開始的編號是(現在頁數-1)*3, 例如第三頁，(3-1)*3=6
$start=($now-1)*$div;
// news資料表中查詢所有資料限制從開始筆數，取三筆
$rows=$News->all(" limit $start,$div");
// 用迴圈的方式將所有筆數內容細分定義成 key-value($idx=>$row)
foreach($rows as $idx => $row);
    ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
</form>