			@extends('layouts.master')

			@section('content')
			
			<div class="jumbotron jumbotron-fluid mb-3">
  <div class="container">
    <h1 class="display-4">{{__('all_stats.books')}}</h1>
    <p class="lead">{{__('all_stats.books_that_the_user')}} <a href="{{ $user->getStatsAddress() }}">{{ $user->name }} </a> {{__('all_stats.has_typed')}}</p>
  </div>
</div>
			
				
					<table class="table" align="center">
					  <thead>
                        <tr align="center">
                          <th scope="col" align="center">@lang('landing.title')</th>
                          <th scope="col">@lang('landing.author')</th>
                          <th scope="col">@lang('profile.language')</th>
                          <th scope="col">{{__('all_stats.average_wpm')}}</th>
                        </tr>
                      </thead>  
                      <tbody>
    				@foreach($books as $book)
    				
    					<tr align="center"><td><a href="{{ url('/stats/' . $user->id . '/book/' . $book->id) }}">
    					{{ $book->title  }}
    					</a> (<a href="{{ \App\Book::find($book->id)->getBookAddress($request) }}">@lang('landing.index')</a>)</td>
    					<td>{{ $book->author }}</td>
    					<td>{{ __('languages.' . \App\Book::find($book->id)->getLanguage()->abbreviation) }} </td>
    					<td>{{ \App\Book::find($book->id)->getUserWPMInBook($user->id) }}</td>
    					</tr>
    				
    				@endforeach
    				</tbody>
    				</table>
				
				
			
			@endsection