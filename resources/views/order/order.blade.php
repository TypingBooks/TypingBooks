

@extends('layouts.master') 

@php
// laziness, this probably could go somewhere better

if(Auth::check()) {
	
	$temp = \App\User::find(Auth::id())->darkmode_on;
	
	if($temp) {
	
		$darkMode = true;
	
	}

}

@endphp


@section('content')

<div class="row">
	<div class="col-sm-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/l') }}">@lang('crumb.language')
						{{ __('languages.' . $translationBook->getLanguage()->abbreviation) }}</a></li>
				<li class="breadcrumb-item"><a
					href="{{ url('/l/' . $translationBook->getLanguage()->abbreviation . '/') }}">@lang('crumb.learning')
						{{ __('languages.' . $book->getLanguage()->abbreviation) }}</a></li>
				<li class="breadcrumb-item"><a
					href="{{ url('/l/' . $translationBook->getLanguage()->abbreviation . '/' . $book->getLanguage()->abbreviation) }}">@lang('crumb.materials')</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">@lang('order.donate')</li>
			</ol>
		</nav>
	</div>
</div>

<div class="card">
	<h5 class="card-header">@lang('order.donate')</h5>
	<div class="card-body">
		<small>
			<p>@lang('order.p1')</p>

			<p>
				@lang('order.p2_1') @lang('order.p2_2')<a
					href="https://cloud.google.com/translate/pricing">@lang('order.p2_3')</a>.
				@lang('order_7-1-20.p2_4_replacement')
			</p>

			<p>@lang('order.p3')</p>
			<p>@lang('order.p4')</p>

			<div class="card mb-3 mt-3">
			
			@if(!isset($darkMode))
			<div class="card-body bg-light">
			@else
			<div class="card-body bg-secondary">
			@endif
					<var>@lang('order.f1')</var>
					+
					<var>@lang('order.f2')</var>
					+
					<var>@lang('order_7-1-20.f3')</var>
				</div>
			</div>

			<p>
				<b>@lang('order.p5_1')</b> @lang('order_7-1-20.p5_2_replacement')
			</p>

		</small>

		<div class="row mb-3">
			<div class="col-sm-6 d-flex">
				<div class="card w-100">
					<h5 class="card-header">@lang('order.book')</h5>
					<div class="card-body">
						<b>@lang('order.book')</b>: {{ $book->title }}<br> <b>@lang('order.author')</b>:
						{{ $book->author }}<br> <b>@lang('order.language')</b>: {{
						__('languages.' . \App\Language::find($book->language)->abbreviation) }}<br> <b>@lang('order.translation')</b>:
						{{
						__('languages.' . \App\Language::find($translationBook->translation_language)->abbreviation)
						}}<br>

					</div>
				</div>

			</div>
			<div class="col-sm-6 d-flex">
				<div class="card w-100">
					<h5 class="card-header">@lang('order.pricing')</h5>
					<div class="card-body">
						<b>@lang('order.characters_in_book')</b>: {{
						number_format($book->characters) }} <br>
						
						 <b>@lang('order.characters_in_words')</b>:
						{{ number_format($book->characters_in_words) }} <br>
						
						 <b>@lang('order.amount_in_dictionary')</b>:
						{{ number_format($book->characters_in_words -
						$translationBook->characters_not_in_dictionary) }}<br>
						
						<b>@lang('order_7-1-20.service_fee')</b>: $5<br>
						
						 <b>@lang('order.pricing_information')</b>:
						 <br>
						(({{ number_format($book->characters_in_words) }} - {{
						number_format($book->characters_in_words -
						$translationBook->characters_not_in_dictionary) }}) + {{
						number_format($book->characters) }}) * ($20 / 1,000,000) + $5 = ${{
						$translationBook->getPricing() }}<br>

					</div>
				</div>


			</div>
		</div>
		
		<div class="row">
		
				<div class="col-sm-6">
		
		@if(!isset($darkMode))
		
				<div class="card mb-0 pt-1 bg-light">
				
				@else
				<div class="card mb-0 pt-1 bg-secondary">
				@endif
			<div class="card-body ">
				<h5>
					<b>@lang('order.total')</b>: ${{ $translationBook->getPricing() }}
				</h5>
			</div>
		</div>
		
		</div>
			<div class="col-sm-6 align-self-center ">
					<a class="btn btn-primary btn-block btn-lg "
			href="{{ url('/order/' . $translationBook->id . '/checkout') }}">@lang('order.donate')</a>
			
			
			</div>
		
		</div>
		
	</div>
</div>
<br>


@endsection
