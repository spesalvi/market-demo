@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"> </div>
				<div class="panel-body">
					<table class="table table-striped">
						<tr>
							<th class="col-md-2">Brand</th>
							<th class="col-md-2">Value</th>
							<th class="col-md-2">Selling Price</th>
							<th class="col-md-2">Status</th>
						</tr>
						@forelse($cards as $card)
							<tr>
								<td>
									<img width="68" height="68" src="http://devcdn.giftbig.com/dev3/brands_logo/large/3_logo.png">
								</td>
								<td>{{$card['balance']}}</td>
								<td>{{$card['offer_price']}}</td>
								<td>Sold</td>
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
