 @extends('layouts.master') @section('content')


@if(count($recentUniqueBookParagraphs) > 0)
<div class="row">
	<div class="col-sm-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-3">

				<li class="breadcrumb-item active" aria-current="page"
					id="gameCrumbTitle">@lang('crumb.profile')</li>
			</ol>
		</nav>
	</div>
</div>
@endif


@if(count($recentUniqueBookParagraphs) > 0)

<div class="card mb-3">
	<div class="card-header">@lang('profile.activity')</div>
	<div class="card-body">


		<table class="table table-hover table-borderless">
			<thead>
				<tr>
					<th scope="col">@lang('profile.progress')</th>
					<th scope="col">@lang('profile.book')</th>
					<th scope="col">@lang('profile.language')</th>
				</tr>
			</thead>
			<tbody>

				@for($i = 0; $i < count($recentUniqueBookParagraphs); $i++)

				<tr>

					@if($recentUniqueBookParagraphs[$i]->hasNextParagraph())

					<td><a href="{{ url('/start/' . $nextParagraphs[$i]->translated_book) }}">{{
							$nextParagraphs[$i]->getLocationInBook() }}</a></td> @else

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
		<div class="col-sm-12" align="right">
		<a class="btn btn-sm btn-primary" href="{{url('/profile/activity/1')}}">{{__('profile_8-6-20.all_activity')}}</a>
		
		</div>
		
		</div>

	</div>

</div>

@else



                  <div class="alert alert-primary">
                  
                  @lang('profile_8-1-20.new_user')
                  
                  
      
                  </div>
@endif

@if(count($scores) > 0)

<div class="card mb-3">
	<div class="card-header">@lang('game.statistics')</div>
	<div class="card-body">

		<div class="row">
			<div class="col-lg-9 col-xl-10 col-md-12 mb-3 d-flex">
				<div class="card w-100">
					<div class="card-body">

						<canvas id="typingHistory" width="756" height="134"></canvas>

					</div>

				</div>


			</div>
			<div class="col-lg-3 col-xl-2 col-md-12 mb-3 d-flex">
				<div class="card w-100">
					<div class="card-body">

						<b>@lang('game.tests')</b><br> {{ count($scores) }}<br> <b>@lang('game.average')</b><br> {{
						$averageWPM }} WPM
					</div>

				</div>

			</div>
		</div>


		<div class="row">
		<div class="col-sm-12" align="right">
		<a class="btn btn-sm btn-primary" href="{{ url('/stats/' . Auth::id()) }}">{{__('profile_8-6-20.all_stats')}}</a>
		
		</div>
		
		</div>

	</div>

</div>

@endif




<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 ">

					<form action="{{ url('/profile/password') }}" method="POST">
					<input type="hidden" name="_method" value="PATCH">
					@csrf
		<div class="card mb-3">

			<div class="card-header">@lang('profile.change_password')</div>
			<div class="card-body">



				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="exampleInputPassword1">@lang('profile.current_password')</label> <input
								type="password" class="form-control form-control-sm"
								id="exampleInputPassword1" name="currentPassword">
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-sm-6">
						<div class="form-group">
							<label for="exampleInputPassword2">@lang('profile.new_password')</label> <input
								type="password" class="form-control form-control-sm"
								id="exampleInputPassword2" name="newPassword">
						</div>

					</div>
					<div class="col-sm-6">

						<div class="form-group">
							<label for="exampleInputPassword3">@lang('profile.repeat_new_password')</label> <input
								type="password" class="form-control form-control-sm"
								id="exampleInputPassword3" name="newPasswordConfirm">
						</div>

					</div>


				</div>
				<div class="row">
					<div class="col-sm-12 text-right">




						<button class="btn btn-primary btn-sm">@lang('profile.submit')</button>
					</div>

				</div>
			</div>
		</div>
		</form>




	</div>


	<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

					<form action="{{ url('/profile/email') }}" method="POST">
					<input type="hidden" name="_method" value="PATCH">
					@csrf
		<div class="card mb-3">

			<div class="card-header">@lang('profile.change_email')</div>


			<div class="card-body">


				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="exampleInputPassword4">@lang('profile.current_password')</label> <input
								type="password" class="form-control form-control-sm"
								id="exampleInputPassword4" name="currentPassword">
						</div>
					</div>
					<div class="col-sm-6" align="center">
						<b>@lang('profile.current_email')</b><br> <span class="small">{{ \App\User::find(Auth::id())->email }}</span>
					</div>

				</div>
				<div class="row">

					<div class="col-sm-6">
						<div class="form-group">
							<label for="exampleInputPassword5">@lang('profile.new_email')</label> <input
								type="text" class="form-control form-control-sm"
								id="exampleInputPassword5" name="newEmail">
						</div>

					</div>
					<div class="col-sm-6">

						<div class="form-group">
							<label for="exampleInputPassword6">@lang('profile.repeat_new_email')</label> <input
								type="text" class="form-control form-control-sm"
								id="exampleInputPassword6" name="newEmailConfirm">
						</div>

					</div>


				</div>
				<div class="row">
					<div class="col-sm-12 text-right">




						<button action="submit" class="btn btn-primary btn-sm">@lang('profile.submit')</button>
					</div>

				</div>
				
			</div>
		</div>
</form>



	</div>

</div>
<form action="{{ url('/profile/darkmode') }}" method="post">
					<input type="hidden" name="_method" value="PATCH">
@csrf
<div class="row">
<div class="col-md-6 col-sm-12 ">
<div class="card"><div class="card-header">
{{__('profile_8-6-20.display')}}
</div>
<div class="card-body">
@csrf
<button type="submit" class="btn btn-primary btn-block">{{__('profile_8-6-20.dark_mode')}}: {{ \App\User::find(Auth::id())->darkmode_on ? __('profile_8-6-20.on') : __('profile_8-6-20.off') }}</button>

</div></div>
</div>


</div>
</form>
<br>


@endsection 


@section('scripts')

@if(count($scores) > 0)

<script src="{{ url('/js/util/Chart.js') }}"></script>
<script>
var scoreHistoryChart = new Chart(document.getElementById('typingHistory'),
{
	"type":"line","data":
	{
		"labels":
		[
		@foreach($scores as $score)

		@if(!$loop->last)
		"{{ $score->created_at }}",
		@else
		"{{ $score->created_at }}"
		@endif
		
		@endforeach


			],
		"datasets":[{
			"label":" WPM",
			"display":false,
			"data":
				[		
					@foreach($scores as $score)

					@if(!$loop->last)
					{{ $score->wpm }},
					@else
					{{ $score->wpm }}
					@endif
					
					@endforeach
					],
				"fill":false,
				"borderColor":"#007bff",
				"lineTension":0.0
			}
		]
	},"options":{


	    legend: {
	        display: false
	    },
        scales: {
            xAxes: [{
                ticks: {
                    display: false,
                },
            }]
        },
	    layout: {
	        padding: 10
	      }

	}
});

</script>

@endif


@endsection
