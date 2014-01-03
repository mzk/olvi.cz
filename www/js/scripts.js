$(document).ready(function () {
	$('a.menu').click(function () {
		$('a.menu').parent('li').removeClass("active");
		$(this).parent('li').addClass("active");
	})
});