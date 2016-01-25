$.ajaxSetup({ 
	headers: {        
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    
	}
});
$('button.buy-card').click(function(){
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
$('#validate-card').click(function(event){
		event.stopPropagation();
		event.preventDefault();
		var that = this;
		$.post('/check-gift-card-balance', $('form').serialize())
			.done(function(data) {
				if(data.status == 'success') {
					$('.auto-filled-fields').show();
					$('#balance').val(data.data.balance);
					console.log(new Date(data.data.expiry));
					$('#date').val(data.data.expiry);
					console.log(data.data);
					$('input[name="brand_sv"]').val(data.data.brand);
					$(that).hide();
					$('#sell-card').show();
				}
			})
			.fail(function(errors) { 
				var field,
					message;
				errors = errors.responseJSON;
				console.log(errors);
				for(var prop in errors) {
					if(errors.hasOwnProperty(prop)) {
						field = prop + '-container';
						message = errors[prop][0];
						$('#' + field).addClass('has-error');
						$('#' + field + ' > strong').
							html(message);
					}
				}
			});
});
