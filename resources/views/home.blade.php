@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
		<ul>
		@forelse($categories as $category)
			<li>
				<a href="/buy-{{ $category['url'] }}-gift-cards">{{ $category['brand'] }}</a>
			</li>
		@empty
		<div>
			Nothing.
		</div>
		</ul>
		@endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
