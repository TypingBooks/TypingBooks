@extends('layouts/master')

@section('content')

@if(count($recentUniqueBookParagraphs) > 0)

<div class="row">
	<div class="col-sm-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-3">

				<li class="breadcrumb-item" aria-current="page"
					id="gameCrumbTitle"><a href="{{ url('/profile') }}">@lang('crumb.profile')</a></li>
					
									<li class="breadcrumb-item active" aria-current="page"
					id="gameCrumbTitle2">@lang('profile.activity')</li>
			</ol>
		</nav>
	</div>
</div>

<div class="card mb-3">
	<div class="card-header">{{ __('all_activity.all_activity') }}</div>
	<div class="card-body">


		<table class="table table-hover table-borderless">
			<thead>
				<tr>
					<th scope="col">{{ __('all_activity.last_activity') }}</th>
					<th scope="col">@lang('profile.progress')</th>
					<th scope="col">@lang('profile.book')</th>
					<th scope="col">@lang('profile.language')</th>
				</tr>
			</thead>
			<tbody>

				@for($i = 0; $i < count($recentUniqueBookParagraphs); $i++)

				<tr>

					@if($recentUniqueBookParagraphs[$i]->hasNextParagraph())
					
					<td>{{ date_format($recentUniqueBookTests[$i]->updated_at, 'm/d/Y') }}</td>

					<td><a href="{{ url('/start/' . $nextParagraphs[$i]->translated_book) }}">{{
							$nextParagraphs[$i]->getLocationInBook() }}</a></td> 
							
					@else

					<td>{{ date_format($recentUniqueBookTests[$i]->updated_at, 'm/d/Y') }}</td>
					<td>@lang('profile.completion')</td> 
					
					@endif

					<td><a href="{{ url('/start/' . $recentUniqueBookParagraphs[$i]->translated_book) }}">{{
							$booksForParagraphs[$i]->getTitle() }}</a> (<a href="{{ $booksForParagraphs[$i]->getBookAddress() }}">@lang('landing.index')</a>)</td>

					
					
					
					<td><a href="{{ url('/l/' . $nextParagraphs[$i]->getTranslationLanguage()->abbreviation . '/' . $nextParagraphs[$i]->getOriginalLanguage()->abbreviation) }}">
					{{ __('languages.' . $nextParagraphs[$i]->getOriginalLanguage()->abbreviation) }}</a></td>

				</tr>
				@endfor
			</tbody>
		</table>
		
		<div class="row">
		<div class="col-sm-6">
						@if(\App\Http\Controllers\HomeController::allActivityHasPreviousPage($page))
						<a class="btn btn-sm btn-primary" href="{{ url('/profile/activity/' . ($page - 1)) }}">{{__('all_activity.previous')}}</a>
						@else
						<a class="btn btn-sm btn-primary disabled" href="{{ url('/profile/activity/' . ($page - 1)) }}" disabled>{{__('all_activity.previous')}}</a>
						@endif
		</div>
		<div class="col-sm-6">
				<div class="row">
		<div class="col-sm-12" align="right">
		@if(\App\Http\Controllers\HomeController::allActivityHasNextPage($page))
		<a class="btn btn-sm btn-primary" href="{{ url('/profile/activity/' . ($page + 1)) }}">{{__('all_activity.next')}}</a>
		@else
		<a class="btn btn-sm btn-primary disabled" href="{{ url('/profile/activity/' . ($page + 1)) }}" disabled>{{__('all_activity.next')}}</a>
		@endif
		
		</div>
		
		</div>
		
		
		</div>
		</div>
		

	</div>

</div>

@endif

@endsection