@extends('layouts.master')

@section('content')

	<h4>Import Book</h4><br>
	<p>At the moment, the book must be formatted in a very specific way</p>
	<li>It must be a text file</li>
	<li>It must have each paragraph on a separate line</li>
	<li>Chapters have their titles removed, and begin with a single line with a "^"</li>
	<li>The beginning of books/parts of books must be marked with an @ symbol</li><br>
	<p>If the above is followed, the book should import itself. Translations are done per landing afterwards if their fee is paid.</p>
	
	
	
	<form action="{{ url('/admin/import') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="row">
    		<div class="col-sm-6">
        	 	<div class="form-group">
                    <label for="title">Book name</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
            </div>
            <div class="col-sm-6">
        	 	<div class="form-group">
                    <label for="title">Book author</label>
                    <input type="text" class="form-control" id="author" name="author">
                </div>
            </div>
            <div class="col-sm-6">
                        	 	<div class="form-group">
                        	 	                  <label for="language">Book language</label>
                <div class="input-group mb-3" id="language" name="language">
                  <select class="custom-select" id="inputGroupSelect01" name="language">
                  @foreach($languages as $language)
                  
                    <option value="{{ $language->id }}" name="language">{{ $language->language }}</option>
                    
                    
                    @endforeach
                  </select>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
            	<div class="form-group">
                    <label for="book">Import book</label>
                	<div class="custom-file">
                  	  <input type="file" class="custom-file-input" id="book" name="book">
                  	  <label class="custom-file-label" for="book">Choose file</label>
                	</div>
                </div>
            </div>
            <br><br>
        </div>
        <br>
        <div class="row">
        	<div class="col-sm-10"></div>
        	<div class="col-sm-2">
        		<button type="submit" class="btn btn-primary">Submit</button>
        	</div>
        </div>
    </form>

@endsection