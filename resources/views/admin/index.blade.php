@extends('layouts.master')

@section('content')

	<h4>Admin</h4>
	<a href="{{ url('/admin/import') }}">Import a book</a>
	<br>
	<a href="{{ url('/admin/fix/books') }}">Fix book translations</a>
	<br>
	<a href="{{ url('/admin/order') }}">Order books</a>
    <br>
    <a href="{{ url('/admin/horizon') }}">Horizon</a>
    <br>
    <a href="{{ url('/admin/modify/books') }}">Modify books/Create translations</a>
    <br>
	<a href="{{ url('/admin/languages') }}">Edit Language Whitelists/Replace lists</a>
    <br>
	<a href="{{ url('/admin/languages/settings') }}">Edit Global Language Whitelists/Replace lists</a>
    <br>
@endsection