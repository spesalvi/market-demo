@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Buy {{ucfirst($brand)}} Gift Cards</div>
					<div class="panel-body">
					<table class="table table-striped">
					 <tr>
					   <th class="cold-md-2">Brand</th>
					   <th class="col-md-2">Value</th>
					   <th class="col-md-2">% Off</th>
					   <th class="col-md-2">Price</th>
					   <th class="col-md-2">Expiry date</th>
					   <th class="col-md-2"></th>
					 </tr>
	@forelse($gift_cards as $giftcard)
		
			<tr>
			<td><img width="68" height="68" src="{{$giftcard['image']}}"></img></td>
			<td>&#8377;{{ $giftcard['balance'] }}</td>
			<td>{{ number_format(round(($giftcard['balance'] - $giftcard['offer_price'])*100)/$giftcard['balance'], 2)}} %</td>
			<td>&#8377;{{ $giftcard['offer_price'] }}</td>
			<td> {{ $giftcard['expiry_date'] }} </td>
			<td>
				<button class="buy-card btn btn-primary" data-sku="{{ $giftcard['sku'] }}" data-desc="" data-price="{{ $giftcard['offer_price']}}">
					Buy Now
				</button>
			</td>
			</tr>
	@empty
		No cards in offering.
	@endforelse
					</table>
	</div>
	</div>
	</div>
	</div>
</div>
@endsection
