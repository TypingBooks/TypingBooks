 @extends('layouts.master') @section('content')

<div class="row">
	<div class="col-sm-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('l') }}">@lang('crumb.language') {{
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
    
    			@isset($section)
    				- 
    				
    				@php
    				
    					$temp = $section;
    					
    					$links = '';
    					
    					while($temp != null) {
    					
    						if($temp->hasParent()) {
    						
    							$links = '<a href="' .  url('/book/' . $bookTranslation->id . '/' . $temp->getParent()->id) . '">' . $temp->title  . '</a> ' . $links;
    						
    						} else {
    						
    						   	$links = '<a href="' . url('/book/' . $bookTranslation->id . '/') . '">' . $temp->title . '</a> ' . $links;
    						
    						}
    					
    						$temp = $temp->getParent();
    					
    					}
    					
    					echo $links;
    				
    				
    				@endphp
    				
    				
    			
    			@endisset
    	
    
    </p>
        
    
  </div>
</div>


@if(isset($tests) || isset($sections))

<div class="row">

	@foreach($sections as $index)
		<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 ">
			<div class="list-group mb-4 shadow" align="center">
				<a class="stretched-link  list-group-item list-group-item-action" href="{{ url('/book/' . $bookTranslation->id . '/' . $index->id) }}"><h6>{{ $index->title }}</h6></a>
			</div>
		
	</div>
		
	
	@endforeach
	

	@foreach($tests as $test)
		<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 ">
			<div class="list-group mb-4 shadow" align="center">
				<a class="stretched-link  list-group-item list-group-item-action" href="{{  url('/game/' . $bookTranslation->id . '/' . $test->paragraph_count) }}"><h6>@lang('part_list.paragraph')
					#{{ $loop->index + 1 }}</h6></a>
			</div>
		</div>

	@endforeach
</div>

@endisset




 @endsection
