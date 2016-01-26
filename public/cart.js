$.ajaxSetup({ 
	headers: {        
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    
	}
});
$('table').on('click', 'button.buy-card', 'click', function(){
	var sku = $(this).data('sku'),
	    that = this;
	$.post('/cart/add', {
		'sku' : sku,
		'description' : 'desc',
		},function(data){
		var response = $.parseJSON(data);
		if(response.status == 'success') {
			$('#size').html(response.cart_size);
			$(that).html('Remove')
				.removeClass('btn-primary')
				.removeClass('buy-card')
				.addClass('remove-card')
				.addClass('btn-danger');
		}
	});
});

$('table').on('click', '.remove-card', function(){
	var sku = $(this).data('sku'),
		that = this;
	
	$.post('/cart/delete', {
		'sku' : sku
	}).done(function(data){
		if(data.status == 'success') {
			$(that).html('Buy Now')
				.removeClass('btn-danger')
				.removeClass('remove-card')
				.addClass('btn-primary')
				.addClass('buy-card');

			$('#size').html(data.cart_size);
		}
	})
	.fail(function(errors){
	});
});

$('input[name="card-number"]').keyup(function(event){
	event.preventDefault();
	var number = $(this).val(),
		maxlength = 19;

	if(/^[0-9 ]+$/.test(number) == false) {
		$(this).val('');
		return;
	}
	
	/*if(number.length == 4 || 
		number.length == 9 ||
		number.length == 14) {
			$(this).val(number + ' ' );
	}*/

	number = number.replace(/ /g, '')
	console.log(number);

	if(/^[0-9]{16}$/.test(number)) {
		$('input[name="pin"]').focus();
	}
});

$('input[name="pin"]').keyup(function(event) {
	event.preventDefault();

	var pin = $(this).val(),
		cardnum = $('input[name="card-number"]').val();
		maxlength = 6;

		cardnum = cardnum.replace(/ /g, '')

	
	if(/^[0-9]{6}$/.test(pin) == false ||  /^[0-9]{16}$/.test(cardnum) == false) {
		return;	
	}
	validateCard($('#validate-card'));
});

function formatDate(isoDate) {
	var mDate = new Date(isoDate),
		month = mDate.getMonth() + 1;
	if(month < 10) {
		month = '0' + month;
	}
	return mDate.getFullYear() + '-' + (month) + '-' + mDate.getDate();
}


function validateCard(that) {
		$.post('/check-gift-card-balance', $('form').serialize())
			.done(function(data) {
				if(data.status == 'success') {
					$('.auto-filled-fields').show();
					$('#balance').val(data.data.balance);
					$('input[name="date"]').val((data.data.expiry));
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
}
