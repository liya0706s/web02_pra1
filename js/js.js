// JavaScript Document
function lo(th, url) {
	$.ajax(url, { cache: false, success: function (x) { $(th).html(x) } })
}

function good(news) {
	$.post("../api/good.php", {
		news
	}, () => {
		// 使用重整頁面的方式來更新按讚的結果
		location.reload();
	})
}