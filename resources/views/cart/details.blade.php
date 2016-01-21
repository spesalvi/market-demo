@extends('layouts.app')

@section('content')
<div class="containter">
   <div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Cart</div>
					<div class="panel-body">
					<table class="table table-striped">
					<tr>
						<th class="col-md-2">SKU</th>
						<th class="col-md-5">Description</th>
						<th class="col-md-2">quantity</th>
						<th class="col-md-2">price</th>
						<th class="col-md-2">total</th>
					</tr>
					@forelse($cart->all() as $item)
						<tr>
							<td>{{$item['sku']}}</td>
							<td>{{$item['description']}}</td>
							<td>{{$item['quantity']}}</td>
							<td>{{$item['price']}}</td>
							<td>{{ $item['quantity'] * $item['price'] }}</td>

						</tr>
					@empty
						Your cart is empty
					@endforelse
						<tr>
						  <td></td>
						  <td></td>
						  <td>Grand total: </td>
						  <td>{{ $cart->total() }}</td>
						  <td>
<form action="/purchase" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="rzp_test_C4L2rxsV1t84Ks"
    data-amount="{{ $cart->total() * 100}}"
    data-name="Woohoo Market"
    data-description="Selling GiftCard"
    data-image="https://stage.woohoo.in/media/smartbanner/woohoo_banner.png"
    @if (Auth::guest())
    data-prefill.name="Robert George"
    @else 
    data-prefill.name="{{Auth::user()->name}}"
    @endif
    data-prefill.email="robert.george@qwikcilver.com"
    data-prefill.contact="9986442677"
    data-theme.color="#F37254"
></script>
<input type="hidden" value="Hidden Element" name="hidden">
{!! csrf_field() !!}
</form>
						</td>
						</tr>
					</div>
					</table>
			</div>
		</div>
   <div>
</div>
@endsection
