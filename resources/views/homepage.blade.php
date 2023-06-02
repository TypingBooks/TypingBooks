			@extends('layouts.master')

			@section('content')

			<div class="row">
				<div class="col-sm-12">
					<div class="jumbotron jumbotron-fluid mb-3">
  <div class="container">
    <h1 class="display-4">bType.io - bookTyping</h1>
    <p class="lead">@lang('homepage.1') </p>
  </div>
  
</div>

<div class="row">

		<div class="col-sm-6 align-self-center">
	<h4>@lang('homepage.2')</h4>
		<p class="mb-3">@lang('homepage.3')</b></p>
		<p align="right"><a class="btn btn-primary" href="{{ url('/l/' . $localeID . '/' . $localeID . '/') }}">@lang('homepage.4')</a></p>
		<div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
     <a href="{{ url('img/home/2.png')  }}"> <img src="{{ url('img/home/2.png') }} " width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/2.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal2"> </figure>  </center>
		</div>
		
		</div>
		

<div class="row">


		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/1.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal1"> </figure>  </center>
		</div>
				<div class="col-sm-6 align-self-center">
	<h4>@lang('homepage.5')</h4>
		<p class="mb-3">@lang('homepage.6') <b>@lang('homepage.7')</b> @lang('homepage.8')
				<p><a class="btn btn-primary" href="{{ url('/l') }}">@lang('homepage.9')</a></p>
		<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/1.png')  }}"><img src="{{ url('img/home/1.png')  }}" width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>
		
		</div>


		

<div class="row">

		<div class="col-sm-6 align-self-center">
			<h4>@lang('homepage.10')</h4>
		@lang('homepage.11')
		
		<div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/3.png')  }}"><img src="{{ url('img/home/3.png')  }}" width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/3.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal3"> </figure>  </center>
		</div>
		
		</div>
		

<div class="row">


		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/4.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal4"></figure>  </center>
		</div>
		<div class="col-sm-6 align-self-center">
					<h4>@lang('homepage.12')</h4>
		@lang('homepage.13')
		<div class="modal fade bd-example-modal-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/4.png')  }}"><img src="{{ url('img/home/4.png')  }}" width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>		
		</div>
		
		

<div class="row">

		<div class="col-sm-6 align-self-center">
					<h4>@lang('homepage.14')</h4>
		@lang('homepage.15')
		<div class="modal fade bd-example-modal-lg" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/5.png')  }}"><img src="{{ url('img/home/5.png')  }}" width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/5.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal5"> </figure> </center>
		</div>
		
		</div>
		
		
		
<div class="row">



		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/6.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal6"> </figure>  </center>
		</div>
		<div class="col-sm-6 align-self-center">
					<h4>@lang('homepage.16')</h4>
@lang('homepage.17')
		<div class="modal fade bd-example-modal-lg" id="exampleModal6" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/6.png')  }}"><img src="{{ url('img/home/6.png')  }}" width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>		
		</div>
		
		

<div class="row">
		<div class="col-sm-6 align-self-center">
					<h4>@lang('homepage.18')</h4>
		@lang('homepage.19')
		<div class="modal fade bd-example-modal-lg" id="exampleModal7" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/7.png')  }}"><img src="{{ url('img/home/7.png')  }}" width="100%" class="rounded border"></a>
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/7.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal7"></figure>  </center>
		</div>
		
		</div>
		
		

<div class="row">


		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{ url('img/home/8.png')  }}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal8"></figure>  </center>
		</div>
				<div class="col-sm-6 align-self-center">
							<h4>@lang('homepage.20')</h4>
		@lang('homepage.21')
		<div class="modal fade bd-example-modal-lg" id="exampleModal8" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <a href="{{ url('img/home/8.png')  }}"><img src="{{ url('img/home/8.png')  }}" width="100%" class="rounded border"></a>
	  		
    </div>
  </div>
</div>
		
		</div>
		</div><br><br>

				</div>
			</div>
			
			@endsection
			
		