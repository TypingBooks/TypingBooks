 @extends('layouts.master') 
 
 
 @section('content')
 
 <div class="jumbotron jumbotron-fluid mb-3">
  <div class="container">
    <h1 class="display-4">{{__('all_stats.stats')}}</h1>
    <p class="lead">{{__('all_stats.stats_for_the_user')}} <a href="{{ $user->getStatsAddress() }}">{{ $user->name }}</a> {{__('all_stats.with')}} <a href="{{ $book->getBookAddress($request) }}">{{ $book->title }}</a></p>
  </div>
</div>
 
 
 <div class="card mb-3">
	<div class="card-header">{{__('all_stats.last_100_tests_with')}} <a href="{{ $book->getBookAddress($request) }}">{{ $book->title }}</a></div>
	<div class="card-body">

		<div class="row">
			<div class="col-lg-9 col-xl-10 col-md-12 mb-3 d-flex">
				<div class="card w-100">
					<div class="card-body">

						<canvas id="typingHistory1" width="756" height="134"></canvas>

					</div>

				</div>


			</div>
			<div class="col-lg-3 col-xl-2 col-md-12 mb-3 d-flex">
				<div class="card w-100">
					<div class="card-body">

						<b>@lang('game.tests')</b><br> {{ count($last100Tests) }}<br> <b>@lang('game.average')</b><br> {{
						$last100TestsAverage }} WPM
					</div>

				</div>

			</div>
		</div>


	</div>

</div>
 
 
 <div class="card mb-3">
	<div class="card-header">{{__('all_stats.all_tests_with')}} <a href="{{ $book->getBookAddress($request) }}">{{ $book->title }}</a></div>
	<div class="card-body">

		<div class="row">
			<div class="col-lg-9 col-xl-10 col-md-12 mb-3 d-flex">
				<div class="card w-100">
					<div class="card-body">

						<canvas id="typingHistory2" width="756" height="134"></canvas>

					</div>

				</div>


			</div>
			<div class="col-lg-3 col-xl-2 col-md-12 mb-3 d-flex">
				<div class="card w-100">
					<div class="card-body">

						<b>@lang('game.tests')</b><br> {{ count($lastBookTests) }}<br> <b>@lang('game.average')</b><br> {{
						$lastBookTestsAverage }} WPM
					</div>

				</div>

			</div>
		</div>



	</div>

</div>

 
 
  
 
 
 
 @endsection
 
 
 
@section('scripts')

<script src="{{ url('/js/util/Chart.js') }}"></script>
<script>
var scoreHistoryChart1 = new Chart(document.getElementById('typingHistory1'),
{
	"type":"line","data":
	{
		"labels":
		[
		@foreach($last100Tests as $score)

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
					@foreach($last100Tests as $score)

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

var scoreHistoryChart2 = new Chart(document.getElementById('typingHistory2'),
{
	"type":"line","data":
	{
		"labels":
		[
		@foreach($lastBookTests as $score)

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
					@foreach($lastBookTests as $score)

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

@endsection
 