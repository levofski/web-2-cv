@extends('master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Documents</div>

				<div class="panel-body" ng-app="cvApp">
                    <div ui-view></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
