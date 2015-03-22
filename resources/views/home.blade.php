@extends('master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body" ng-app="cvApp">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group" role="group">
                            <a ui-sref="document.new" class="btn btn-primary">New Document</a>
                        </div>
                    </div>
                    <div ui-view></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
