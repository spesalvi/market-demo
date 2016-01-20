@extends('layouts.app')

@section('content')
<div class="containter">
   <div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Cart</div>
					<div class="panel-body">
					<table>
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
					</div>
					</table>
			</div>
		</div>
   <div>
</div>
@endsection
