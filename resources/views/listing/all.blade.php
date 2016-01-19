@extends('layouts.app')

@section('content')
<div class="containter">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Dashboard</div>
					<div class="panel-body">
					<table>
					 <tr>
					   <th>Value</th>
					   <th>% Off</th>
					   <th>Price</th>
					   <th>Expiry date</th>
					   <th></th>
					 </tr>
	@forelse($gift_cards as $giftcard)
		
			<tr>
			<td>{{ $giftcard['balance'] }}</td>
			<td>10%</td>
			<td>{{ $giftcard['offer_price'] }}</td>
			<td> {{ $giftcard['expiry_date'] }} </td>
			<td><button>Buy</button></td>
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
