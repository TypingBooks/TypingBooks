 @extends('layouts.master') 
 
 
 @section('content')


 <div class="jumbotron jumbotron-fluid mb-3">
  <div class="container">
    <h1 class="display-4">{{__('all_stats.languages')}}</h1>
    <p class="lead">{{__('all_stats.languages_that_the_user')}} <a href="{{ $user->getStatsAddress() }}">{{ $user->name }} </a> {{__('all_stats.has_typed')}}</p>
  </div>
</div>



		<div class="row">
		
		@foreach($languages as $lang) 
		



		<div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 ">
			<div class="list-group mb-4 shadow" align="center">
				<a class=" stretched-link  list-group-item list-group-item-action"
					href="{{ url('/stats/' . $user->id . '/language/' . $lang->id) }}"><h6>{{
						__('languages.' . $lang->abbreviation) }}</h6> <img src="{{ url($lang->img) }}"
					height="50px" class="rounded border border-secondary shadow"></img> </a>
			</div>

		</div>
 @endforeach

	</div>

@endsection