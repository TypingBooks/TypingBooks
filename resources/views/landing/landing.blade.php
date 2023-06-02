			@extends('layouts.master')

			@section('content')
			
			@include('landing/crumb')
			
				<h5>@lang('landing.books')</h5>
				
				@if(!(count($translatedBooks) > 0))
					@lang('landing.book_info')<br><br>
				@else
					<table class="table">
					  <thead>
                        <tr>
                          <th scope="col">@lang('landing.title')</th>
                          <th scope="col">@lang('landing.author')</th>
                          <th scope="col">@lang('user_book_import.added_by')</th>
                        </tr>
                      </thead>  
                      <tbody>
    				@foreach($translatedBooks as $translatedBook)
    				
    					<tr><td><a href="{{ url('/start/' . $translatedBook->id . '/') }}">{{ $translatedBook->title  }}</a> (<a href="{{ url('/book/' . $translatedBook->id) }}">@lang('landing.index')</a>)</td>
    					<td>{{ $translatedBook->author }}</td>
    					<td><a href="{{ url('/stats/' . $translatedBook->added_by) }}">{{$translatedBook->name}}</a></td>
    					</tr>
    				
    				@endforeach
    				</tbody>
    				</table>
    				<div class="row" align="right">
    					<div class="col-sm-12">
    						<a href="{{ url('/l/' . $native_lang->abbreviation . '/' . $learning_lang->abbreviation . '/translated/1') }}" class="btn btn-primary btn-sm">@lang('user_book_import.all_books')</a>
    					
    					</div>
    				</div>
				@endif
				
				@if(!$notLearningLanguage)
				
				<h5>@lang('landing.not_translated')</h5>
				
				@if(!(count($notYetTranslatedBooks) > 0))
					@lang('landing.not_translated_info')<br><br>
				@else
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
    				@foreach($notYetTranslatedBooks as $notYetTranslatedBook)
    				
    					<tr><td><a href="{{ url('/order/' . $notYetTranslatedBook->id) }}">{{ $notYetTranslatedBook->title  }}</a></td>
    					<td>{{ $notYetTranslatedBook->author }}</td>
    					<td><a href="{{ url('/stats/' . $notYetTranslatedBook->added_by) }}">{{$notYetTranslatedBook->name}}</a></td>
    					<td><b><a href="{{ url('/order/' . $notYetTranslatedBook->id) }}">@lang('landing.donate2')</b></a></td>
    					</tr>
    				
    				@endforeach
    				</tbody>
    				</table>
   				<div class="row" align="right">
    					<div class="col-sm-12">
    						<a href="{{ url('/l/' . $native_lang->abbreviation . '/' . $learning_lang->abbreviation . '/waiting/1') }}" class="btn btn-primary btn-sm">@lang('user_book_import.all_books')</a>
    					
    					</div>
    				</div>
				@endif
				
				
				
				
				@endif
				
				
				@if(Auth::check()) 
				
													@if((count($translatedBooksForUser) + count($notYetTranslatedBooksForUser)) > 0)
													
					<h5>@lang('landing_9-11-20-2.books_that_you_have_added')</h5>
					

									@if(!(count($translatedBooksForUser) > 0))
					@lang('landing.book_info')<br><br>
				@else
					<table class="table">
					  <thead>
                        <tr>
                          <th scope="col">@lang('landing.title')</th>
                          <th scope="col">@lang('landing.author')</th>
                          <th scope="col">@lang('user_book_import.added_by')</th>
                        </tr>
                      </thead>  
                      <tbody>
    				@foreach($translatedBooksForUser as $translatedBook)
    				
    					<tr><td><a href="{{ url('/start/' . $translatedBook->id . '/') }}">{{ $translatedBook->title  }}</a> (<a href="{{ url('/book/' . $translatedBook->id) }}">@lang('landing.index')</a>)</td>
    					<td>{{ $translatedBook->author }}</td>
    					<td><a href="{{ url('/stats/' . $translatedBook->added_by) }}">{{$translatedBook->name}}</a></td>
    					</tr>
    				
    				@endforeach
    				</tbody>
    				</table>
   				<div class="row" align="right">
    					<div class="col-sm-12">
    						<a href="{{ url('/l/' . $native_lang->abbreviation . '/' . $learning_lang->abbreviation . '/user/translated/1') }}" class="btn btn-primary btn-sm">@lang('user_book_import.all_books')</a>
    					
    					</div>
    				</div>
				@endif
					
					
									@if(!$notLearningLanguage)
														<h5>@lang('landing_9-11-20-2.books_that_you_have_added_that_do_not_yet_have_translations')</h5>
													@if(!(count($notYetTranslatedBooks) > 0))
					@lang('landing.not_translated_info')
				@else
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
    				@foreach($notYetTranslatedBooksForUser as $notYetTranslatedBook)
    				
    					<tr><td><a href="{{ url('/order/' . $notYetTranslatedBook->id) }}">{{ $notYetTranslatedBook->title  }}</a></td>
    					<td>{{ $notYetTranslatedBook->author }}</td>
    					<td><a href="{{ url('/stats/' . $notYetTranslatedBook->added_by) }}">{{$notYetTranslatedBook->name}}</a></td>
    					<td><b><a href="{{ url('/order/' . $notYetTranslatedBook->id) }}">@lang('landing.donate2')</b></a></td>
    					</tr>
    				
    				@endforeach
    				</tbody>
    				</table>
   				<div class="row" align="right">
    					<div class="col-sm-12">
    						<a href="{{ url('/l/' . $native_lang->abbreviation . '/' . $learning_lang->abbreviation . '/user/waiting/1') }}" class="btn btn-primary btn-sm">@lang('user_book_import.all_books')</a>
    					
    					</div>
    				</div>
				@endif
				@endif
			@endif
			
			@endif
			@endsection