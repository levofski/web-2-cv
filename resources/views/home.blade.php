@extends('master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
                    <input type="text" ng-model="testText" placeholder="Enter text here" />
					[[testText]]
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
