@extends('master')

@section('content')
<div class="container">
	<div class="row">
		<div ng-app="cvApp">
            <div ui-view></div>
		</div>
	</div>
</div>
@endsection
