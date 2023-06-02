@extends('layouts.master')

@section('content')

@include('landing/crumb')

<h5>@lang('landing.books')</h5>

					<table class="table">
					  <thead>
                        <tr>
                          <th scope="col">@lang('landing.title')</th>
                          <th scope="col">@lang('landing.author')</th>
                          <th scope="col">@lang('user_book_import.added_by')</th>
                        </tr>
                      </thead>  
                      <tbody>
    				@foreach($books as $translatedBook)
    				
    					<tr><td><a href="{{ url('/start/' . $translatedBook->id . '/') }}">{{ $translatedBook->title  }}</a> (<a href="{{ url('/book/' . $translatedBook->id) }}">@lang('landing.index')</a>)</td>
    					<td>{{ $translatedBook->author }}</td>
    					<td><a href="{{ url('/stats/' . $translatedBook->added_by) }}">{{$translatedBook->name}}</a></td>
    					</tr>
    				
    				@endforeach
    				</tbody>
    				</table>
    
		<div class="row">
		<div class="col-sm-6">
						@if($hasPreviousPage)
						<a class="btn btn-sm btn-primary" href="{{ url($baseAddress . ($page - 1)) }}">{{__('all_activity.previous')}}</a>
						@else
						<a class="btn btn-sm btn-primary disabled" href="{{ url($baseAddress . ($page - 1)) }}" disabled>{{__('all_activity.previous')}}</a>
						@endif
		</div>
		<div class="col-sm-6">
				<div class="row">
		<div class="col-sm-12" align="right">
		@if($hasNextPage)
		<a class="btn btn-sm btn-primary" href="{{ url($baseAddress . ($page + 1)) }}">{{__('all_activity.next')}}</a>
		@else
		<a class="btn btn-sm btn-primary disabled" href="{{ url($baseAddress . ($page + 1)) }}" disabled>{{__('all_activity.next')}}</a>
		@endif
		
		</div>
		
		</div>
		
		
		</div>
		</div>


@endsection