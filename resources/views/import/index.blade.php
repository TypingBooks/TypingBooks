@extends('layouts.master') 

@section('content') 

@include('import/books_table1')
@if((count($books) > 0))
		<div class="row">
			<div class="col-sm-12" align="right">
				<a class="btn btn-sm btn-primary"
					href="{{url($baseAddress . '/1')}}">@lang('user_book_import.all_books')</a>

			</div>

		</div>
@endif
@include('import/books_table2')

<div class="row">
	<div class="col-lg-8 col-sm-12">

		<div class="card mb-3">

			<div class="card-header">@lang('user_book_import.import_a_book')</div>


			<div class="card-body">




				<form action="{{ url('/import') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="title">@lang('user_book_import.book_title')</label> <input type="text"
									class="form-control " id="title" name="title">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="title">@lang('user_book_import.author')</label> <input type="text"
									class="form-control " id="author" name="author">
							</div>
						</div>
						
						
					</div>
					<div class="row mb-3">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="language">@lang('user_book_import.language')</label>
								<div class="input-group mb-3 " id="language" name="language">
									<select class=" form-control"
										id="inputGroupSelect01" name="language"> 
										@foreach($languages as $language)

										<option value="{{ $language->id }}" name="language">
										{{ __('languages.' . $language->abbreviation) }}</option> 
											@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group mb-3">
								<label for="book">@lang('user_book_import.text_file')</label>
								<div class="custom-file" id="importBookGroup">
									<input type="file" class="custom-file-input" id="book" name="book"> 
									<label class="custom-file-label" for="book">@lang('user_book_import.choose_file')</label>
									<div class="invalid-feedback">@lang('user_book_import.you_can_only_import_text_files')</div>
								</div>
							</div>
						</div>
						
						<script>
                            document.querySelector('.custom-file-input').addEventListener('change',function(e) {
                            
                                let fileName = "Choose file";
                                let importTag = document.getElementById("book");
                                
                                if(importTag.files[0] != null) {
                                
                                	fileName = importTag.files[0].name;
                                
                                }
                                
                                if(!fileName.endsWith(".txt")) {
                                
                            		importTag.classList.remove("is-valid");
                                	importTag.classList.add("is-invalid");
                                	
                                	
                                } else {
                                
                                	importTag.classList.remove("is-invalid");
                                	importTag.classList.add("is-valid");
                                	
                                }
                                
                                let nextSibling = e.target.nextElementSibling;
                                nextSibling.innerText = fileName;
                            });
						
						</script>
					</div>
					<div class="row mb-3" align="right">
						<div class="col-sm-12">
							<div class="form-check">
								<input type="checkbox" name="isPrivate" class="form-check-input"
									id="exampleCheck1"> <label class="form-check-label"
									for="exampleCheck1">@lang('user_book_import.only_allow_me_to_use_this_book')</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" align="right">
							<button type="submit" class="btn btn-primary btn-sm">@lang('user_book_import.import')</button>
						</div>
					</div>
				</form>

			</div>

		</div>


	</div>
	<div class="col-lg-4 col-sm-12">
		<div class="card mb-3">
			<div class="card-header">@lang('user_book_import.help_with_importing_books')</div>
			<div class="card-body">
				@lang('user_book_import.read') <a href="{{url('/import/format')}}">@lang('user_book_import.this_guide')</a> @lang('user_book_import.to_learn_how_to_format_books_for_import')
			</div>
		</div>




	</div>
</div>




@endsection
