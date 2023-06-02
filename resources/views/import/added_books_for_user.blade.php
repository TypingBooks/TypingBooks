@extends('layouts.master') 

@section('content')

@include('import/books_table1')
<div class="row">
	<div class="col-sm-6">
		@if(\App\Http\Controllers\ImportController::importedBooksForUserHasPage($page - 1))
		<a class="btn btn-sm btn-primary"
			href="{{ url($baseAddress . '/' . ($page - 1)) }}">{{__('all_activity.previous')}}</a>
		@else <a class="btn btn-sm btn-primary disabled"
			href="{{ url($baseAddress . '/' . ($page - 1)) }}" disabled>{{__('all_activity.previous')}}</a>
		@endif
	</div>
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-12" align="right">
				@if(\App\Http\Controllers\ImportController::importedBooksForUserHasPage($page + 1))
				<a class="btn btn-sm btn-primary" href="{{ url($baseAddress . '/' . ($page + 1)) }}">{{__('all_activity.next')}}</a>
				@else <a class="btn btn-sm btn-primary disabled"
					href="{{ url($baseAddress . '/' . ($page + 1)) }}" disabled>{{__('all_activity.next')}}</a>
				@endif

			</div>

		</div>


	</div>
</div>

@include('import/books_table2')

@endsection
