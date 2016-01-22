@extends('layouts.app')

@section('content')
<div class="containter">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Sell your gift card</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" autocomplete="off">
					{!! csrf_field() !!}
					<div id='card-number-container' class="form-group{{ $errors->has('card-number') ? ' has-error' : '' }} ">
						<label class="col-md-4 control-label">
							Card Number
						</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="card-number" value="">
							@if($errors->has('card-number'))
								<span class="helper-block">
									<strong>
									 {{ $errors->first('card-number') }}
									</strong>
								</span>
							@endif
						</div>
					</div>
					<div id="pin-container" class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">
							Pin
						</label>
						<div class="col-md-6">
							<input type="password" name="pin" class="form-control" size="4">
							@if($errors->has('pin'))
								<span class="helper-block">
									<strong>
									 {{ $errors->first('pin') }}
									</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group" >
						<label class="col-md-4 control-label">
						 	Stored Value
						</label>
						<div class="col-md-6">
						  <input id="balance" name="balance" type="text" class="form-control" readonly value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">
							Selling Price
						</label>
						<div class="col-md-6">
							<input id="price" name="price" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">
							Expiry Date	
						</label>
						<div class="col-md-6">
							<input type="date" id="date" name="date" type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
					  <div class="col-md-6 col-md-offset-4">
					  	<button type="submit" id="validate-card" class="btn btn-primary">
						  <i class="fa fa-btn fa-sign-in"></i>Validate Card
						</button>
						<button type="submit" style="display:none;" id="sell-card" class="btn btn-prmiary">
						  <i class="fa fa-btn fa-sign-in"></i>Sell Card
						</button>

					  </div>
					</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
