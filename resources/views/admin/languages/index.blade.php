@extends('layouts.master')

@section('content')

	<h4>Edit Language White lists/replace characters</h4><br>
	
	@foreach($languages as $language)
	
		<a href="/admin/language/{{ $language->id }}">{{ $language->language }}</a><br>
	
	
	@endforeach

@endsection