// www.verstka.pro

if ( !window.console) {
	window.console = {};
	window.console.log = function () {};
	window.console.error = function () {};
	window.console.warn = function () {};
}

$('.input.placeholder').each(function () {

	var self = $(this);

	if ($('input', self).val().length) $('span', self).hide(0);

	$('input', self).on('focus init', function () {
		$('span', self).hide(0);
	}).on('blur', function () {
		if (!$(this).val().length) $('span', self).show(0);
	});

});

if ($.browser.msie && $.browser.version <= 8) {

	$('.w-text table tbody tr:nth-child(2n-1) > *').css('background-color', '#e8fabd');

	$('.w-text ul li').append('<s class="before" />');

}