$.ajaxSetup({ 
	headers: {        
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    
	}
});
$('button').click(function(){
	var price = $(this).data('price'),
	    sku = $(this).data('sku'),
	    that = this;
	$.post('/cart/add', {
		'sku' : sku,
		'description' : 'desc',
		'price' : price
		},function(data){
		var response = $.parseJSON(data);
		if(response.status == 'success') {
			$('#size').html(response.cart_size);
			$(that).html('Sell');
		}
	});
});

