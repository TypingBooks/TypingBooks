@extends('layouts.master') @section('content') @if(count($books) > 0)


<table class="table">
	<tr>
		<th scope="col">Title</th>
		<th scope="col">Translation</th>
		<th scope="col">Issues</th>
		<th scope="col">Fix</th>
	</tr>
	@foreach($books as $book)

	<tr>



		<td>{{ $book->title }}</td>
		<td>{{ $book->getLanguage()->language }}</td>
		<td>{{ $book->getValidationErrors() }}</td>
		<td>

			<form action="{{ url('/admin/fix/books') }}" method="POST">

				@csrf </input type="hidden" name="translationId" value="{{ $book->id }}">
				<button type="submit" class="btn btn-primary">Purchase fixes</button>
			</form>



		</td>

	</tr>

	@endforeach

</table>

@else


<h3>All translated books are without errors!</h3>

@endif @endsection
