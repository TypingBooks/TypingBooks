@php
// laziness, this probably could go somewhere better

if(Auth::check()) {
	
	$temp = \App\User::find(Auth::id())->darkmode_on;
	
	if($temp) {
	
		$darkMode = true;
	
	}

}

@endphp

<html>
	<head>
		<title>bType - @lang('master_8-1-20.title')</title>
		    <meta name="description" content="@lang('user_book_import.website_desc')">
		    
		    @if(!isset($darkMode))
		    
	<link rel="stylesheet" href="{{ url('/css/bootstrap/4.5.1/bootstrap.min.css') }}" crossorigin="anonymous">
		
			@else
		
		      <link rel="stylesheet" type="text/css" href="{{ url('/css/bootswatch/darkly/bootstrap.min.css') }}">
		      
			@endif
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173572145-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-173572145-1');
</script>

		
		</head>
		<body>
		@if(isset($logoutButton))
								<form action="{{ url('/logout') }}" method="post">
		@endif
		
			<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"/>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">bType</a>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
					<ul class="navbar-nav mr-auto mt-2 mt-sm-0">
			
						<li class="nav-item">
							<a class="nav-link" href="{{ url('/import') }}">@lang('user_book_import.import')</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="https://discord.gg/wPvUUDa">@lang('master.join') Discord</a>
						</li>
												<li class="nav-item">
							<a class="nav-link" href="{{ url('/data') }}">@lang('master_7-1-20.data')</a>
						</li>
					</ul>
						
					@if(Auth::check()) 
					
						@if(!isset($logoutButton))
					<a href="{{ url('/profile') }}" class="btn btn-primary my-2 my-sm-0 m-1">{{ \App\User::find(Auth::id())->name }}</a>	
						@else
						<form action="{{ url('/logout') }}" method="post">
						
						@csrf
						
						<button type="submit" class="btn btn-danger my-2 my-sm-0 m-1 ">@lang('master_8-1-20-2.logout')</a>	
						
	
						@endif
					
					@else 
					<a href="{{ url('/login') }}" class="btn btn-primary my-2 my-sm-0 m-1">@lang('master.login')</a>	
					
					@endif
					
					
				</div>
			</nav>
					@if(isset($logoutButton))
						</form>
		@endif
			<div class="container">
			@if($errors->any() || session()->has('success') || session()->has('danger'))
			
						<div class="row">
			            @if ($errors->any())

               <div class="col-sm-12">

                  <div class="alert alert-danger">
                     <ul>
                        @foreach ($errors->all() as $error)
                        			
						
                        <li>{{ $error }}</li>

                        @endforeach
                     </ul>
                  </div>

               </div>

            @endif

            @if (session()->has('success'))

               <div class="col-sm-12">


                  <div class="alert alert-success">
                    
                     {{ session()->get('success') }}

                  </div>

               </div>

            @endif

            @if (session()->has('danger'))

               <div class="col-sm-12">


                  <div class="alert alert-danger">
                    
                     {{ session()->get('danger') }}

                  </div>

               </div>

            @endif

        </div>
        @endif
			
			@yield('content')
			
			
			</div>
			
			@yield('scripts')
			
      <script type="text/javascript" src="{{ url('/js/ajax/libs/popper.js/1.16.1/umd/popper.min.js') }}"></script>
            <script type="text/javascript" src="{{ url('/js/jquery/3.5.1/jquery-3.5.1.min.js') }}"></script>
      <script type="text/javascript" src="{{ url('/js/bootstrap/4.5.1/bootstrap.min.js') }}"></script>
			
	</body>
</html>