
$( ".items" ).mouseover(function() {
	$(this).find('.colorandsizes').toggleClass('dis-none');
	$(this).find('.add-cart').toggleClass('dis-none');
	$(this).find('.quick-view').toggleClass('dis-none');
	$(this).find('.item-spec').toggleClass('dis-none');
	$(this).find('.c-s-padding').toggleClass('dis-5');
});

$( ".items" ).mouseout(function() {
 	$(this).find('.colorandsizes').toggleClass('dis-none');
	$(this).find('.add-cart').toggleClass('dis-none');
	$(this).find('.quick-view').toggleClass('dis-none');
	$(this).find('.item-spec ').toggleClass('dis-none');
	$(this).find('.c-s-padding').toggleClass('dis-5');
	});
