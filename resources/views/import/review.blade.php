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

@if($book->state == 'importing')
<div class="row">
<div class="col-sm-12">
<div class="alert alert-danger">@lang('user_book_import.92')</div>

</div>

</div>
@endif

@if($book->state == 'error')
<div class="row">
<div class="col-sm-12">
<div class="alert alert-danger">@lang('user_book_import.93')</div>

</div>

</div>
@endif


<form action="{{ url('/import/review/' . $book->id) }}" method="post">

@csrf

<div class="card mb-3">

	<div class="card-header">@lang('user_book_import.book_information')</div>

	<div class="card-body">


		<table class="table table-hover table-borderless">
			<thead>
				<tr>
					<th scope="col">@lang('user_book_import.date_added')</th>
					<th scope="col">@lang('user_book_import.book')</th>
					<th scope="col">@lang('user_book_import.access')</th>
										<th scope="col">@lang('user_book_import.state')</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="align-middle">{{ date_format($book->created_at, 'm/d/Y') }}</td>
					<td class="align-middle"><b>@lang('user_book_import.title')</b>: {{ $book->getTitle() }}<br><b>@lang('user_book_import.author')</b>: {{$book->getAuthor()}}<br><b>@lang('user_book_import.language')</b>: {{ __('languages.' . $book->getLanguage()->abbreviation) }}</td>
					<td class="align-middle">{{ $book->isPrivate() ? __('user_book_import.only_you') : __('user_book_import.everyone') }}</td>
					<td class="align-middle">{{ $book->getTextState() }}</td>

				</tr>
			</tbody>
		</table>

	</div>

</div>


@if($book->state != 'importing' && $book->state != 'error')

<div class="row">

	<div class="col-sm-6  d-flex ">


		<div class="card w-100 mb-3 ">

			<div class="card-header">@lang('user_book_import.detected_index_in_book')</div>

			<div class="card-body ">

				@if(!$book->hasIndex())

				<div class="alert alert-danger">@lang('user_book_import.no_index_for_this_book_has_been_detected')</div>
					
				@else


        				<div 
        				@if(isset($darkMode))
        			
        					class="card bg-secondary" 
        				@else
        			
        					class="card bg-light" 
        					
        				@endif
        					
        					>
        					<pre>
        						<code>
        	 			{!! $book->getHTMLIndices() !!}
        				</code>
        					</pre>
        				</div>
				
				@endif
			</div>

		</div>

	</div>
	
	@if(isset($bookErrors) && (count($bookErrors) > 0))
	
	<div class="col-sm-6 d-flex">
		<div class="card mb-3 w-100 ">
			<div class="card-header">@lang('user_book_import.fix_letters_that_are_not_typeable')</div>
			<div class="card-body">



				<table class="table">
					<thead align="center">
						<th scope="col" align="center">@lang('user_book_import.detected_character')</th>
						<th scope="col">@lang('user_book_import.desired_replacement')</th>
					</thead>

					<tbody>
						@foreach($bookErrors as $error)
						<tr>
							<td align="center" class="align-middle"><kbd>{{ $error }}</kbd></td>
							<td class="align-middle"><input
								class="form-control form-control-sm" type="text" name="replacement{{ $loop->index }}" 
								
								@isset($userReplacements)
								
								value="{{ $userReplacements[$loop->index] }}" 
								
								@if($book->state != 'validation')
								disabled
								@endif
								
								@endisset
								></td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>

	</div>
	
	@else
	@if($book->state == 'validation')
		<div class="col-sm-6 d-flex">
		<div class="card mb-3 w-100 ">
			<div class="card-header">@lang('user_book_import.confirm')</div>
			<div class="card-body">
			<div class="row">
<div class="col-sm-12 mb-3">
@lang('user_book_import.confirm_text')

</div>
<div class="col-sm-12"><button type="submit" class="btn btn-primary btn-block">@lang('user_book_import.submit')</button></div>
</div>
			
			</div>
			</div>
			</div>
			@endif
	
	@endif
</div>

@endif


@if($book->state == 'validation')
	@if(isset($bookErrors) && (count($bookErrors) > 0))
<div class="row">
<div class="col-sm-12">

<div class="card mb-3">
<div class="card-header">
@lang('user_book_import.confirm')
</div>
<div class="card-body">
<div class="row">
<div class="col-sm-8">
@lang('user_book_import.confirm_text')

</div>
<div class="col-sm-4"><button type="submit" class="btn btn-primary btn-block">@lang('user_book_import.submit')</button></div>
</div>

</div>


</div>

</div>

</div>
@endif
@endif

</form>

 @endsection
