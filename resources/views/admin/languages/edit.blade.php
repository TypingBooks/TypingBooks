@extends('layouts.master')

@section('content')

	<a href="{{ url('/admin') }}">Return to admin</a><br><br>

	<h4>Edit global Language White lists/replace characters for {{ $language->language }}</h4><br>

	<form action="{{ url('/admin/language/'. $language->id) }}" method="post">
	
		@csrf
	


	<div class="row">
	
		<div class="col-sm-4">
		  <div class="form-group">
    <label for="exampleFormControlTextarea1">Whitelisted Characters</label>
    <textarea class="form-control" name="whitelist" id="exampleFormControlTextarea1" rows="10">{{ $language->whitelisted_characters }}</textarea>
  </div>
		
		
		</div>
	<div class="col-sm-4">
	  <div class="form-group">
    <label for="exampleFormControlTextarea2">Replace Characters</label>
    <textarea class="form-control" name="replaceList" id="exampleFormControlTextarea2" rows="10">{{ $language->getPrintedReplaceList() }}</textarea>
  </div>
	
	</div>
	<div class="col-sm-4">
	
	  <div class="form-group">
    <label for="exampleFormControlTextarea3">Punctuation Characters</label>
    <textarea class="form-control" name="punctuationList" id="exampleFormControlTextarea3" rows="10">{{ $language->punctuation_characters }}</textarea>
  </div>
	</div>
	
	</div>
	
	  <div class="form-group form-check">
    <input type="checkbox" name="useWhitelist" class="form-check-input" id="exampleCheck1" {{ $language->use_whitelist ? 'checked' : ''}}>
    <label class="form-check-label" for="exampleCheck1" >Use whitelist</label>
  </div>
	
	<div class="row" align="right">
	
	<div class="col-sm-12">
	
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	
	</div>
	
		</form>

@endsection