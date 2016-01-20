$.ajaxSetup({    
	headers: {        
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    
	}
});
$('button').click(function(){
	$.post('/cart/add', function(data){
		var response = $.parseJSON(data);
		if(response.status == 'success') {
			$('#size').html(response.cart_size);
		}
		console.log(response);
		console.log('cart add invoked');
	});
});
