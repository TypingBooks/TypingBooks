@extends('layouts.master') @section('content')

<h4>ADMIN - Order translations</h4>
<p>You really shouldn't be here unless you're using Google Cloud credits
	or in development mode. It really does cost $20-40 to translate a book,
	and this page allows you to spend money very quickly.</p>

<br>

<table class="table">
	<thead>
		<tr>
			<th scope="col">Book</th>
			<th scope="col">Language</th>
			<th scope="col">Translation</th>
			<th scope="col">Cost</th>
			<th scope="col">Fake Order</th>
			<th scope="col">Order</th>
		</tr>
	</thead>
	<tbody>

		@foreach($books as $book)

		<tr>
			<th>{{ $book->getTitle() }}</th>
			<td>{{ $book->getBook()->getLanguage()->language }}</td>
			<td>{{ $book->getLanguage()->language }}</td>
			<td>${{ $book->getPricing() }}</td>
			<td>
				<form action="{{ url('/admin/order') }}" method="POST">
					@csrf <input type="hidden" name="bookTranslationId"
						value="{{ $book->id }}"> <input type="hidden" name="isReal"
						value="0">
					<button type="submit" class="btn btn-sm btn-primary">Fake it</button>
				</form>


				</form>


			</td>
			<td>


				<button type="button" class="btn btn-primary btn-sm"
					data-toggle="modal"
					data-target="#exampleModalCenter{{ $loop->index }}">Order</button>

				<div class="modal fade" id="exampleModalCenter{{ $loop->index }}"
					tabindex="-1" role="dialog"
					aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

					<form action="{{ url('/admin/order') }}" method="POST">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<form action="{{ url('/admin/order') }}" method="POST">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalCenterTitle">Are you
											sure?</h5>
										<button type="button" class="close" data-dismiss="modal"
											aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										You're about to <b>spend ${{ $book->getPricing() }}</b> to
										order this book! Are you sure you want to purchase this
										translation? <br>
										<br> <b>Book: </b>{{ $book->getTitle() }}<br> <b>Language: </b>
										{{ $book->getBook()->getLanguage()->language }}<br> <b>
											Translation: </b>{{ $book->getLanguage()->language }}
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary"
											data-dismiss="modal">Close</button>

										@csrf <input type="hidden" name="bookTranslationId"
											value="{{ $book->id }}"> <input type="hidden" name="isReal"
											value="1">
										<button type="submit" class="btn btn-primary">Order</button>



									</div>
							
							</div>
						</div>
					</form>
				</div>



			</td>
		</tr>


		@endforeach


	</tbody>
</table>

@endsection
