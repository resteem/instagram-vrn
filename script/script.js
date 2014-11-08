$(document).ready(function(){
	$("a").hover(function () {
		$("a[href='" + $(this).attr("href") + "']").toggleClass("hover");
	});
});