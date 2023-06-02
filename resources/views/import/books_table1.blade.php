
@if((count($books) > 0))

<div class="card mb-3">
	<div class="card-header">@lang('user_book_import.books_that_you_have_added')</div>
	<div class="card-body">

		<table class="table table-hover table-borderless">
			<thead>
				<tr>
					<th scope="col">@lang('landing.title')</th>
					<th scope="col">@lang('user_book_import.state')</th>
					<th scope="col">@lang('user_book_import.review_validate')</th>
				</tr>
			</thead>
			<tbody>
				@foreach($books as $book)

				<tr>
					<td>{{ $book->title }}</td>
					<td>{{ $book->getTextState() }}</td>
					<td><a href="{{ url('/import/review/' . $book->id) }}">@lang('user_book_import.review_validate')</a></td>
				</tr>

				@endforeach
			</tbody>
		</table>

		@endif