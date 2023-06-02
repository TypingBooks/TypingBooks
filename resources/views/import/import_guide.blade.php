@extends('layouts.master') 

@section('content') 

@php // laziness, this probably could go somewhere better 

	if(Auth::check()) { 
    	$temp = \App\User::find(Auth::id())->darkmode_on; 
    	if($temp) { 
    		$darkMode = true;
   		 } 
	}
@endphp


<div class="row">
<div class="col-sm-12">

	

	<div class="card">
		<h5 class="card-header">
			@lang('user_book_import.5')
		</h5>
		<div class="card-body">
		
		
		<p>@lang('user_book_import.1') <b>@lang('user_book_import.2'), @lang('user_book_import.3'), </b>@lang('user_book_import.03')<b> @lang('user_book_import.4').</b> </p>
		
<div class="row">
		<div class="col-md-12 col-lg-6">
			<h5>@lang('user_book_import.2')</h5>
				<p>@lang('user_book_import.7')</p>
		
		<ul>
			<li>@lang('user_book_import.8') UTF-8</li>
					<li>@lang('user_book_import.9') ".txt"</li>
										<li>@lang('user_book_import.10')</li>
										<li>@lang('user_book_import.11')</li>
		</ul>

		<h5>@lang('user_book_import.3')</h5>
				<p>@lang('user_book_import.12')</p>
		<p>@lang('user_book_import.13') <b>@lang('user_book_import.14')</b>.</p> <p>@lang('user_book_import.15')</p>
	

		
		</div>
		<div class="col-md-12 col-lg-6">
			
				<h5>@lang('user_book_import.6')</h5>
		<ul>
			<li><a href="https://notepad-plus-plus.org/"><b>Notepad++</b></a> - @lang('user_book_import.54') Windows. @lang('user_book_import.55')</li>
			<li><a href="https://www.sublimetext.com/"><b>Sublime Text</b></a> - @lang('user_book_import.56') Notepad++. Notepad++ @lang('user_book_import.57') Windows  @lang('user_book_import.057') Sublime Text  @lang('user_book_import.58')</li>
			<li><a href="https://calibre-ebook.com/"><b>Calibre</b></a> -  @lang('user_book_import.59')</li>
<li><a href="https://medium.com/tech-tajawal/regular-expressions-the-last-guide-6800283ac034"><b>Regex @lang('user_book_import.060')</b></a> - Regex @lang('user_book_import.60') regex. @lang('user_book_import.61') regex @lang('user_book_import.62')</li>
							<li><a href="https://discord.gg/wPvUUDa"><b>@lang('user_book_import.65') Discord</b></a> - @lang('user_book_import.63') Discord @lang('user_book_import.64')</li>
		
		</ul>
		</div>
		
		<div class="col-sm-12">
		
				<h5>@lang('user_book_import.4')</h5>
				
				
		<p>@lang('user_book_import.16') <a href="https://asciidoc.org/">AsciiDoc</a>. @lang('user_book_import.17')
		</p>
		
		<div class="row">
			<div class="col-sm-6 align-self-center">
					<p>@lang('user_book_import.18') "=" @lang('user_book_import.19') "Chapter 3: The Crystal Room", @lang('user_book_import.20')</p>
			</div>
			<div class="col-sm-6">
			<div class="card 
			
			@isset($darkMode)
			bg-secondary
			@else
			bg-light
			@endif
			
			 mb-3
			 pt-3 pl-3">
		<pre><code>=Chapter 3: The Crystal Room</code></pre></div>
			
			</div>
		
		</div>
		
		

		<div class="row">
			<div class="col-sm-6 align-self-center">
					<p>@lang('user_book_import.21') "=" @lang('user_book_import.22')</p>
				
			</div>
			<div class="col-sm-6 ">
			
			<div class="card 
			
						@isset($darkMode)
			bg-secondary
			@else
			bg-light
			@endif
			
			 mb-3 pt-3 pl-3" >
<pre><code>=@lang('user_book_import.26')

@lang('user_book_import.24')

@lang('user_book_import.25')

=@lang('user_book_import.27')

==@lang('user_book_import.28')

===@lang('user_book_import.29')

@lang('user_book_import.30')

@lang('user_book_import.31')

@lang('user_book_import.32')

===@lang('user_book_import.33')

@lang('user_book_import.34')

</code></pre></div>
			</div>
		</div>


		
		<h5>@lang('user_book_import.23')</h5>
		
		<div class="row">
		<div class="col-sm-6 align-self-center">
		@lang('user_book_import.35') <b>@lang('user_book_import.36')</b>
		
		<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <img src="{{url('/img/guide/1.png')}}" width="100%" class="rounded border">
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6">
		
				<center><figure class="figure"><img src="{{url('/img/guide/1.png')}}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal1"></img>  <figcaption class="figure-caption text-right">fig. 1</figcaption>
</figure></center>
		</div>
		
		</div>
		
		<h5>@lang('user_book_import.37') Calibre</h5>
@lang('user_book_import.38')
		<div class="row"><div class="col-sm-6 align-self-center">
@lang('user_book_import.39') Calibre. @lang('user_book_import.40') Calibre, @lang('user_book_import.41') Calibre.
		
		<div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <img src="{{url('/img/guide/2.png')}}" width="100%" class="rounded border">
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6 pt-3 mt-0">
		
		<center><figure class="figure"><img src="{{url('/img/guide/2.png')}}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal2"></img>  <figcaption class="figure-caption text-right">fig. 2</figcaption>
		</div></div>
				<div class="row"><div class="col-sm-6 align-self-center">
		@lang('user_book_import.42') Calibre @lang('user_book_import.43')
		
		
<div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel3" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <img src="{{url('/img/guide/3.png')}}" width="100%" class="rounded border">
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6  pt-3 mt-0">
		
		<center><figure class="figure"><img src="{{url('/img/guide/3.png')}}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal3"></img>  <figcaption class="figure-caption text-right">fig. 3</figcaption>
		</div></div>
				<div class="row"><div class="col-sm-6 align-self-center">
@lang('user_book_import.44') "txt" @lang('user_book_import.45') "OK" @lang('user_book_import.46') Calibre @lang('user_book_import.47')
		
		<div class="modal fade bd-example-modal-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel4" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <img src="{{url('/img/guide/4.png')}}" width="100%" class="rounded border">
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6  pt-3 mt-0">
		
		<center><figure class="figure"><img src="{{url('/img/guide/4.png')}}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal4"></img>  <figcaption class="figure-caption text-right">fig. 4</figcaption>
		</div></div>
				<div class="row"><div class="col-sm-6 align-self-center">
		@lang('user_book_import.48') Calibre. @lang('user_book_import.49') "open containing folder." @lang('user_book_import.50') Calibre @lang('user_book_import.51')
		
		<div class="modal fade bd-example-modal-lg" tabindex="-1" id="exampleModal5" role="dialog" aria-labelledby="myLargeModalLabel5" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <img src="{{url('/img/guide/5.png')}}" width="100%" class="rounded border">
    </div>
  </div>
</div>
		
		</div>
		<div class="col-sm-6  pt-3 mt-0">
		
		<center><figure class="figure"><img src="{{url('/img/guide/5.png')}}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal5"></img>  <figcaption class="figure-caption text-right">fig. 5</figcaption>
		</div></div>
				<div class="row"><div class="col-sm-6 align-self-center">
		@lang('user_book_import.52') Calibre @lang('user_book_import.53')
		

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="exampleModal6" role="dialog" aria-labelledby="myLargeModalLabel6" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <img src="{{url('/img/guide/6.png')}}" width="100%" class="rounded border">
    </div>
  </div>
</div>
		
		
		</div>
		<div class="col-sm-6  pt-3 mt-0">
		
		<center><figure class="figure"><img src="{{url('/img/guide/6.png')}}" width="300px" class="rounded border" data-toggle="modal" data-target="#exampleModal6"></img>  <figcaption class="figure-caption text-right">fig. 6</figcaption>
		</div></div>
		
		</div>
	
	</div>
		</div>
	
	</div>

</div>
</div>

 @endsection
