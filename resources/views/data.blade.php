@extends('layouts.master')

@php
// laziness, this probably could go somewhere better

if(Auth::check()) {
	
	$temp = \App\User::find(Auth::id())->darkmode_on;
	
	if($temp) {
	
		$darkMode = true;
	
	}

}

@endphp


@section('content')

<div class="jumbotron jumbotron-fluid mb-3">
  <div class="container">
    <h1 class="display-4">@lang('data.title')</h1>
    <p class="lead">@lang('data.title_description')</p>
  </div>
</div>


<div class="card">
<h5 class="card-header">@lang('data.title')</h5>
<div class="card-body">

<p>@lang('data.p1')</p>

<p>@lang('data.p2')</p>

<p>@lang('data.p3_1') {{ \App\BookTranslation::where('has_translation', '=', true)->where('json_file', '!=', null)->count() }} @lang('data.p3_2') {{ \App\Dictionary::where('json_file', '!=', null)->count() }} @lang('data.p3_3')</p>
<div class="col-sm-3 offset-9">
<a class="btn btn-primary" href="{{ url('/data/download') }}">@lang('data.download')</a>
</div><br>

<div class="row mb-3">
<div class="col-lg-6 col-md-12">
<h5>@lang('data.book_translations') ({{ \App\BookTranslation::where('has_translation', '=', true)->where('json_file', '!=', null)->count() }})</h5>
<p>@lang('data.b1_1') <samp><b>filenames</b></samp> @lang('data.b1_2')<br>
<code>@lang('data.language')-@lang('data.translation')-@lang('data.book_title')-@lang('data.author').json</code><br></p>
<p>
@lang('data.b2_1') <samp><b>object</b></samp> @lang('data.b2_2')<br>
@if(!isset($darkMode))
<div class="card bg-light border-light mb-3">
@else
<div class="card bg-secondary mb-3">
@endisset<div class="card-body">
<div class="row">
<div class="col-sm-6">
<samp><b>title <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c1_1')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>author <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c1_2')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>language <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c1_3')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>translation <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c1_4')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>sectionData <br><code><small>Array&lt;Section&gt;</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c1_5_1') <b><samp>array</samp></b> @lang('data.c1_5_2') <b><samp>Section</samp></b> objects. @lang('user_book_import.94')
</div>

</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>sentenceData <br><code><small>Array&lt;Sentence&gt;</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c1_5_1') <b><samp>array</samp></b> @lang('data.c1_5_2') <b><samp>Sentence</samp></b> objects. @lang('data.c1_5_3')
</div>

</div></div></div>

<p>@lang('data.b3_1') <b><samp>index</samp></b> @lang('data.b3_2') <b><samp>sectionData</samp></b> @lang('user_book_import.91') <b><samp>Section</samp></b> object @lang('data.b3_4')</p>

@if(!isset($darkMode))
<div class="card bg-light border-light mb-3">
@else
<div class="card bg-secondary mb-3">
@endisset


<div class="card-body">
<div class="row">
<div class="col-sm-6">
<samp><b>id <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.77') <b><samp>integer</samp></b> @lang('user_book_import.78') <b><samp>Sentence</samp></b> @lang('user_book_import.79') <b><samp>Section</samp></b> objects @lang('user_book_import.80')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>title <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.81')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>parent <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.82') <b><samp>integer</samp></b> @lang('user_book_import.83') <b><samp>null</samp></b>, @lang('user_book_import.84')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>order <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.85')
</div>
</div><br>
</div>
</div>






<p>@lang('data.b3_1') <b><samp>index</samp></b> @lang('data.b3_2') <b><samp>sentenceData</samp></b> @lang('data.b3_3') <b><samp>Sentence</samp></b> object @lang('data.b3_4')</p>

@if(!isset($darkMode))
<div class="card bg-light border-light mb-3">
@else
<div class="card bg-secondary mb-3">
@endisset

<div class="card-body">
<div class="row">
<div class="col-sm-6">
<samp><b>sentence <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c2_1')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>translation <br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c2_2')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>section <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.86') id @lang('user_book_import.87')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>orderInSection <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.88')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>testGroup <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.89')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>orderInTestGroup <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('user_book_import.90')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>orderInBook <br><code><small>Integer</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c2_3')
</div>
</div>
</div></div>
</div>
<div class="col-lg-6 col-md-12">

<h5>@lang('data.dictionaries') ({{ \App\Dictionary::where('json_file', '!=', null)->count() }})</h5>
<p>@lang('data.d1_1') <samp><b>filenames</b></samp> @lang('data.d1_2')<br>
<code>@lang('data.language')-@lang('data.translation').json</code> </p>
<p>@lang('data.d2_1') <samp><b>object</b></samp> @lang('data.d1_2')<br></p>

@if(!isset($darkMode))
<div class="card bg-light border-light mb-3">
@else
<div class="card bg-secondary mb-3">
@endisset<div class="card-body">
<div class="row">
<div class="col-sm-6">
<samp><b>language<br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c3_1')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>translationLanguage<br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c3_2')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>dictionaryItems<br><code><small>Array&lt;DictionaryItem&gt;</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c3_3_1') <b><samp>array</samp></b> @lang('data.c3_3_2') <b><samp>DictionaryItem</samp></b> objects @lang('data.c3_3_3')
</div>
</div>

</div></div>

<p>@lang('data.d3_1') <b><samp>index</samp></b> @lang('data.d3_2') dictionaryItems <b><samp>array</samp></b>, @lang('data.d3_3') <b><samp>DictionaryItem</samp></b> object @lang('data.d3_4')<br></p>
@if(!isset($darkMode))
<div class="card bg-light border-light mb-3">
@else
<div class="card bg-secondary mb-3">
@endisset<div class="card-body">
<div class="row">
<div class="col-sm-6">
<samp><b>word<br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c4_1')
</div>
</div><br>
<div class="row">
<div class="col-sm-6">
<samp><b>translation<br><code><small>String</small></code></b></samp>
</div>
<div class="col-sm-6">
@lang('data.c4_2')
</div>
</div><br></div></div>



</div>
</div>

</div>

</div>
<br>

@endsection
