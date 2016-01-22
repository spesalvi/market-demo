@extends('layouts.app')

@section('content')
<div class="containter">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Sell your gift card</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST">
					{!! csrf_field() !!}
					<div class="form-group{{ $errors->has('card-number') ? ' has-error' : '' }} ">
						<label class="col-md-4 control-label">
							Card Number
						</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="card-number">
							@if($errors->has('card-number'))
								<span class="helper-block">
									<strong>
									 {{ $errors->first('card-number') }}
									</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
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
					<div class="form-group">
					  <div class="col-md-6 col-md-offset-4">
					  	<button type="submit" class="btn btn-primary">
						  <i class="fa fa-btn fa-sign-in"></i>Validate Card
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
