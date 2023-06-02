			@extends('layouts.master')

			@section('content')

			<div class="row">
				<div class="col-sm-12">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ url('/l') }}">@lang('crumb.language') {{ __('languages.' . \App\Language::find($data->native_language)->abbreviation) }}</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ url('/l/' . \App\Language::find($data->native_language)->abbreviation) }}">@lang('crumb.learning') {{ __('languages.' . \App\Language::find($data->learning_language)->abbreviation) }}</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ url('/l/' . \App\Language::find($data->native_language)->abbreviation . '/' . \App\Language::find($data->learning_language)->abbreviation) }}">@lang('crumb.materials')</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page" id="gameCrumbTitle">{{ $data->book_title }} Pt. {{ $data->part }} Ch. {{ $data->chapter }} #{{ $data->paragraph }}</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 mb-3">
					<div class="card">
						<h5 class="card-header"><span id="wordTranslationTitle">@lang('game.current_word_translation')</span></h5>
						<div class="card-body">
							<div class="card-text" align="center">
								<h1><span id="wordTranslation">

									{{ $data->translated_words[0] }}
		
								</span></h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" >
				<div class="col-sm-12">
					<div class="card mb-3">
						<h5 class="card-header" id="gameTitle">{{ $data->book_title }} Pt. {{ $data->part }} Ch. {{ $data->chapter }} #{{ $data->paragraph }}</h5>
						<div class="card-body">
						
						
						<div class="row">
							<div class="col-sm-10">
							
																<div class="card mb-3" style="background-color: rgba(0,0,0,.03);">
										<div class="card-body">
											<span class="card-text text-break" id="gameText">
											
												@foreach($data->original_words as $word)
												
													{{ $word . " " }}
												
												@endforeach
											
											</span>
										</div>
									</div>
							
							
							</div>

							<div class="col-sm-2">
								<div class="row">
									<div class="col-lg-2 col-sm-1"></div>
									<div class="col-lg-8 col-sm-10" >
									<button type="button"  class="btn btn-primary btn-block btn-sm mb-2" onclick="pageScreen.changeFontBy(+1)">+</button>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-2 col-sm-1"></div>
									<div class="col-lg-8 col-sm-10" >
								<button type="button" class="btn btn-primary btn-block btn-sm mb-2" onclick="pageScreen.changeFontBy(-1)">-</button>
								</div>
								</div>
							
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-sm-3 col-md-3 col-lg-2 mb-2">
							    						
    											<button type="button" class="btn btn-primary btn-block " id="previousGameButton" onclick="pageScreen.loadPreviousGame()">@lang('game.previous')</button>
    								
							</div>
							<div class="col-sm-6 col-md-5 col-lg-6 mb-2">
							    		
    											<input type="text" class="form-control" id="typingInput" oninput="pageScreen.handleGameInput();" onkeydown="if(event.keyCode == 13){ pageScreen.handleGameInput(13) }" placeholder="@lang('game.start_typing')">
    								
							</div>
							<div class="col-sm-3 col-md-2 mb-2">
    												<button type="button" class="btn btn-primary btn-block " id="nextGameButton" onclick="pageScreen.loadNextGame()">@lang('game.next')</button>
    									
							
							</div>
							<div class="col-sm-12 col-md-2 mb-2" align="center">
							<h5 >
											<span class="badge badge-secondary text-break"><span id="gameWPM">0.00</span> WPM</span>
										</h5>
							
							</div>
						
						</div>
						
							
						</div>
					</div>
				</div>
			</div>
			<div class="row" @if($notLearningLanguage) 
			
				style="display: none"
				
				@endif
			
			>
			
			<span id="grammarText" style="display: none">{{ $data->grammar[0] }}</span>

				<div class="col-sm-12 mb-3">
					<div class="card">
						<h5 class="card-header">@lang('game.current_sentence_translation')</h5>
						<div class="card-body" align="center">
							<p class="card-text text-break"><span id="sentenceTranslation">{{ $data->translated_sentences[0] }}</span></p>
						</div>
					</div>
				</div>
			</div>

<div class="card mb-3">
	<h5 class="card-header">@lang('game.statistics')</h5>
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

						<b>@lang('game.tests')</b><br> <span id="testCount">0</span><br> <b>@lang('game.average')</b><br> <span id="averageWPM">0</span> WPM
					</div>

				</div>

			</div>
		</div>


	</div>

</div>
			
			@endsection
			
		@section('scripts')
		
			<script src="{{ url('/js/util/Chart.js') }}"></script>
    		<script src="{{ url('/js/util/TextTools.js') }}"></script>
    		<script src="{{ url('/js/game/Game.js') }}" ></script>
    		<script src="{{ url('/js/game/GameContentData.js') }}" ></script>
    		<script src="{{ url('/js/game/BookMetaData.js') }}" ></script>
    		<script src="{{ url('/js/game/GameMetaData.js') }}" ></script>
    		<script src="{{ url('/js/game/GameData.js') }}" ></script>
    		<script src="{{ url('/js/game/ScoreData.js') }}" ></script>
    		<script src="{{ url('/js/game/GameSplitter.js') }}"></script>
    		<script src="{{ url('/js/game/GameController.js') }}"></script>
    		<script src="{{ url('/js/game/GamePageController.js') }}" ></script>
    		
    		@if(Auth::check())
    			
    		 
    			<script>
    			pageScreen.darkMode = {{\App\User::find(Auth::id())->darkmode_on ? "true" : "false" }};
    			</script>
    		
    		@endif
    		
    		@isset($gameData)
        		<script>
            
        		// load game data on page load
        		
        		pageScreen.wordTranslationDefaultWinTitle = "@lang('game.win_message')";
            	pageScreen.wordTranslationDefaultCompleteTitle = "@lang('game.last_test')"

                @if($notLearningLanguage)

                	pageScreen.wordTranslationDefaultTitle = "WPM";

            		pageScreen.notLearningLanguage = true;
                	
                @else
                    
            		pageScreen.wordTranslationDefaultTitle = "@lang('game.current_word_translation')";
            	
				@endif
                	
        		pageScreen.gameController = new GameController(GameData.createGameDataFromAPIData(JSON.stringify({!! $gameData !!})), pageScreen.getViewport());

        		pageScreen.setupNewGame();
        		pageScreen.updateGameScreen();
                
        		</script>
    		@endisset
		
		@endsection