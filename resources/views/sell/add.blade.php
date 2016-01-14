@extends('layouts.app')

@section('content')
<div class="containter">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel-body">
				<form method="post">
					<label>Card Number</label>
					<input type="text" name="card-number">
					<br>
					<label>Pin</label>
					<input type="password" name="pin" size="4">
					<br/>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="submit" value="Sell">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
