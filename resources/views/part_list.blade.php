 @extends('layouts.master') @section('content')

<div class="row">
	<div class="col-sm-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/l') }}">@lang('crumb.language') {{
						__('languages.' . $translatedLanguage->abbreviation) }}</a></li>
				<li class="breadcrumb-item"><a
					href="{{ url('/l/' . $translatedLanguage->abbreviation) }}">@lang('crumb.learning')
						{{ __('languages.' . $originalLanguage->abbreviation) }}</a></li>
				<li class="breadcrumb-item"><a
					href="{{ url('/l/' . $translatedLanguage->abbreviation . '/' . $originalLanguage->abbreviation) }}">@lang('crumb.materials')</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page"
					id="gameCrumbTitle">{{ $book->title }}
					
					@isset($chapters)
						Pt. {{ $part }} 
					@endisset
					
					@isset($paragraphs)
						Pt. {{ $part }} Ch. {{ $chapter }}
					@endisset
					
					
					</li>
			</ol>
		</nav>
	</div>
</div>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">{{ $book->title }} 
    
    
    - @lang('part_list.index')
    
    </h1>
    <p class="lead">@lang('part_list.by') {{ $book->author }}
    
    			@isset($chapters)
						- <a href="{{ url('/book/' . $bookTranslation->id . '/') }}">@lang('part_list.part') {{ $part }}</a>
					@endisset
					
					@isset($paragraphs)
						- <a href="{{ url('/book/' . $bookTranslation->id . '/') }}">@lang('part_list.part') {{ $part }}</a> <a href="{{ url('/book/' . $bookTranslation->id . '/' . $part) }}">@lang('part_list.chapter') {{ $chapter }}</a>
					@endisset
    
    
    </p>
        
    
  </div>
</div>



@isset($parts)
<div class="row">
	@for($i = 1; $i <= $parts; $i++)
	<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2" >
	<div class="list-group mb-4 shadow" align="center">
				<a class="stretched-link  list-group-item list-group-item-action" href="{{ url('/book/' . $bookTranslation->id . '/' . $i) }}"><h6>@lang('part_list.part')
					{{ $i }}</h6></a>
			</div>
		
	</div>

	@endfor
</div>

@endisset @isset($chapters)



<div class="row">

	@for($i = 1; $i <= $chapters; $i++)
	<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2" >
	<div class="list-group mb-4 shadow" align="center">
				<a class="stretched-link  list-group-item list-group-item-action" href="{{ url('/book/' . $bookTranslation->id . '/' . $part . '/' . $i) }}"><h6>@lang('part_list.chapter')
					{{ $i }}</h6></a>
			</div>
		</div>

	@endfor
</div>
@endisset @isset($paragraphs)

<div class="row">
	@foreach($paragraphs as $paragraph)
	<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2" >
	<div class="list-group mb-4 shadow" align="center">
				<a class="stretched-link  list-group-item list-group-item-action" href="{{  url('/game/' . $bookTranslation->id . '/' . $paragraph->paragraph_count) }}"><h6>@lang('part_list.paragraph')
					{{ $paragraph->paragraph }}</h6></a>
			</div>
		</div>

	@endforeach
</div>

@endisset @endsection
