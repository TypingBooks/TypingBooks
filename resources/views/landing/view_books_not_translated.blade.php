@extends('layouts.master')

@section('content')

@include('landing/crumb')

<h5>@lang('landing.not_translated')</h5>
	
					<table class="table">
					  <thead>
                        <tr>
                          <th scope="col">@lang('landing.title')</th>
                          <th scope="col">@lang('landing.author')</th>
                           <th scope="col">@lang('user_book_import.added_by')</th>
                          <th scope="col">@lang('landing.donate')</th>
                        </tr>
                      </thead>  
                      <tbody>
    				@foreach($books as $notYetTranslatedBook)
    				
    					<tr><td><a href="{{ url('/order/' . $notYetTranslatedBook->id) }}">{{ $notYetTranslatedBook->title  }}</a></td>
    					<td>{{ $notYetTranslatedBook->author }}</td>
    					<td><a href="{{ url('/stats/' . $notYetTranslatedBook->added_by) }}">{{$notYetTranslatedBook->name}}</a></td>
    					<td><b><a href="{{ url('/order/' . $notYetTranslatedBook->id) }}">@lang('landing.donate2')</b></a></td>
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
    				
    				
@endsection