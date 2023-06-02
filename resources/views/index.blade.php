 @extends('layouts.master') @section('content')



@if(isset($native_abbreviation))

<div class="row">
	<div class="col-sm-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/l') }}">@lang('crumb.language')
						{{ __('languages.' . $native_lang->abbreviation) }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">@lang('crumb.select_learning')</li>
			</ol>
		</nav>
	</div>
</div>


<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">@lang('index.title2')</h1>
    <p class="lead">@lang('index.description2') </p>
  </div>
</div>
	@else

	<div class="row">
		<div class="col-sm-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">@lang('crumb.select')</li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">@lang('index.title')</h1>
    <p class="lead">@lang('index.description') </p>
  </div>
</div>





		@endif 
		
		<div class="row">
		
		@foreach($languages as $lang) @if(isset($native_abbreviation))

		<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 ">
			<div class="list-group mb-4 shadow" align="center">
				<a class=" stretched-link  list-group-item list-group-item-action"
					href="{{ url('/l/' . $native_abbreviation . '/' . $lang->abbreviation) }}"><h6>{{
						__('languages.' . $lang->abbreviation) }}</h6> <img src="{{ url($lang->img) }}"
					height="50px" class="rounded border border-secondary shadow"></img> </a>
			</div>

		</div>




		@else


		<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 ">
			<div class="list-group mb-4 shadow" align="center">
				<a class=" stretched-link  list-group-item list-group-item-action"
					href="{{ url('/l/' . $lang->abbreviation . '/') }}"><h6>{{
						__('languages.' . $lang->abbreviation, [], $lang->abbreviation) }}</h6> <img src="{{ url($lang->img) }}"
					height="50px" class="rounded border border-secondary shadow"></img> </a>
			</div>

		</div>

		@endif @endforeach

	</div>

	@endsection