@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">My Gift Cards</div>
				<div class="panel-body">
					<table class="table table-striped">
						<tr>
							<th class="col-md-2">Brand</th>
							<th class="col-md-2">Value</th>
							<th class="col-md-2">Offer Price</th>
							<th class="col-md-2">Status</th>
						</tr>
						@forelse($cards as $card)
							<tr>
								<td>
									<img width="68" height="68" src="{{$card->brand->img_large}}">
								</td>
								<td>&#8377;{{$card['balance']}}</td>
								<td>&#8377;{{$card['offer_price']}}</td>
								<td>{{$card['status'] == 'purchased' ? 'Sold' : 'In market'}}</td>
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
