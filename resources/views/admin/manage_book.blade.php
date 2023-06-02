@extends('layouts.master') @section('content') @if(count($books) > 0)

<script>

var languages = [

	@foreach($languages as $language)
	
		"{{ $language->language }}"
	
		@if(!$loop->last)
		
		,
		
		@endif
	
	@endforeach

]

var books = [

	@foreach($books as $book)
	
		[
	
		@foreach($book as $translation)
			
			{!! $translation->has_translation ? '"Already translated"' : ('"$' . $translation->getPricing() . '"') !!}
			
			@if(!$loop->last)
				,
			@endif
			
		@endforeach
	
		] 
		
		@if(!$loop->last)
		,
		@endif
	
	@endforeach()

];

function updateCostForTranslation(bookId, translationId) {

	document.getElementById("costForBook" + bookId).innerHTML = books[bookId][translationId];

}



</script>


@foreach($books as $book)

<div class="card mb-3">
	<div class="card-body">

		<div class="row">
			<div class="col-sm-12">



				<table class="table">
					<tr>
						<th scope="col">Title</th>
						<th scope="col">Author</th>
						<th scope="col">Language</th>
					</tr>


					<tr>


						<td>{{ $book[0]->getTitle() }}</td>
						<td>{{ $book[0]->getAuthor() }}</td>
						<td>{{ $book[0]->getBook()->getLanguage()->language }}</td>

					</tr>


				</table>




			</div>

		</div>


		<div class="row">
			<div class="col-sm-6">

				<form action="{{ url('/admin/modify/books') }}" method="POST">
				
				@csrf

					<div class="row">

						<div class="col-sm-6">
							<div class="form-group">
								<label for="title">Regex replace</label> <input type="text"
									class="form-control form-control-sm" name="replace">
							</div>



						</div>

						<div class="col-sm-6">


							<div class="form-group">
								<label for="title">Replace with</label> <input type="text"
									class="form-control form-control-sm" name="replaceWith">
							</div>

						</div>


					</div>




					<input type="hidden" name="bookId"
						value="{{ $book[0]->getBook()->id }}">
					<button name="isRegex" type="submit" class="btn btn-primary btn-sm"
						value="1">Replace</button>


				</form>



				<form action="{{ url('/admin/modify/books') }}" method="POST">
				
				@csrf


					<div class="row">

						<div class="col-sm-6">


							<div class="form-group">
								<label for="title">Regular replace</label> <input type="text"
									class="form-control form-control-sm" name="replace">
							</div>

						</div>

						<div class="col-sm-6">


							<div class="form-group">
								<label for="title">Replace with</label> <input type="text"
									class="form-control form-control-sm" name="replaceWith">
							</div>
						</div>


					</div>


					<input type="hidden" name="bookId"
						value="{{ $book[0]->getBook()->id }}">

					<button name="isRegex" type="submit" class="btn btn-primary btn-sm"
						value="0">Replace</button>

				</form>

			</div>

			<div class="col-sm-6">

				<h5>Create Translation</h5>

				<form action="{{ url('/admin/order') }}" method="POST">

					@csrf

					<div class="row">
						<div class="col-sm-6">

							<div class="form-group">
								<label for="language">Translation Language</label>
								<div class="input-group mb-3" id="language" name="language">
								@php $firstLoop = $loop->index; @endphp
									<select class="custom-select" id="inputGroupSelect01"
										name="bookTranslationId"
										
										onchange="updateCostForTranslation({{ $firstLoop }}, this.selectedIndex);" onfocus="this.selectedIndex = 0; updateCostForTranslation({{ $firstLoop }}, 0);"
										
										> @foreach($book as $translation)

										<option value="{{ $translation->id }}">{{
											$translation->getLanguage()->language }}</option> @endforeach
									</select>
								</div>
							</div>
							
							
							<h5>Cost: <span id="costForBook{{ $loop->index }}">${{ $book[0]->getPricing() }}</span></h5>

							<script>updateCostForTranslation({{ $loop->index }}, 0);</script>
							

						</div>
						<div class="col-sm-6">

							<button name="isReal" type="submit"
								class="btn btn-primary btn-block mb-2 btn-sm" value="0">Fake
								translation</button>
							<button name="isReal" type="submit"
								class="btn btn-danger btn-block btn-sm" value="1">Purchase translation</button>

						</div>

					</div>



				</form>



			</div>


		</div>




	</div>

</div>


@endforeach @else


<h3>No books added</h3>

@endif @endsection
