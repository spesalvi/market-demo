@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">My Purchased Gift Cards</div>
				<div class="panel-body">
				{{@if new_purchase }}
				   <span>Your purchase was successful</span>
				{{@endif}}
					<table class="table table-striped">
						<tr>
							<th class="col-md-2">Brand</th>
							<th class="col-md-2">Stored Value</th>
							<th class="col-md-2">Purchase Price</th>
							<th class="col-md-2">Savings</th>
							<th class="col-md-2">Expires on</th>
						</tr>
						@forelse($cards as $card)
							<tr>
								<td>
									<img width="68" height="68" src="{{$card->brand->img_large}}">
								</td>
								<td>&#8377;{{$card['stored_value']}}</td>
								<td>&#8377;{{$card['purchase_value']}}</td>
								<td>&#8377;{{$card['stored_value'] - $card['purchase_value']}}</td>
								<td>{{$card->card->expiry_date}}</td>
							</tr>
						@empty
							No cards 
						@endforelse
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
