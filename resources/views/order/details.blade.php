
<div class="card mb-3">
	<a href="{{ $order->getAddress() }}" class="h5 card-header">@lang('order_details.details', [], $locale)</a>
	<div class="card-body">
		<table class="table table-bordered">
			<thead class="thead-dark">
				<tr align="center">
					<th scope="col">@lang('order.book', [], $locale)</th>
					<th scope="col">@lang('landing.author', [], $locale)</th>
					<th scope="col">@lang('profile.language', [], $locale)</th>
					<th scope="col">@lang('order.translation', [], $locale)</th>
				</tr>
			</thead>
			<tbody>

				<tr>
					<td align="center"><a href="{{ url('/game/' . $book->id . '/1') }}">{{
							$book->getTitle() }}</a> (<a href="{{ $book->getIndexAddress() }}">@lang('landing.index', [], $locale)</a>)</td>
					<td align="center">{{ $book->getAuthor() }}</td>
					<td align="center">{{ __('languages.' . $book->getBook()->getLanguage()->abbreviation, [], $locale) }}</td>
					<td align="center">{{ __('languages.' . $book->getLanguage()->abbreviation, [], $locale) }}</td>
			
			</tbody>
		</table>
		<div class="card">
			<div class="card-body">

				<div class="row">

					<div class="col-sm-6" align="center">
						<h6>
						
						@lang('order_details.date', [], $locale)
						
						
						</h6>
						<div class="mb-3">{{ date_format($order->updated_at, 'm-d-Y') }}</div>
						<b><h6>
						
						
						
						@lang('order_details.price', [], $locale)
						
						
						
						</h6></b>${{ $book->getPricing() }} ({{
						number_format($book->getBook()->characters +
						$book->characters_not_in_dictionary) }} @lang('order_details.characters', [], $locale))<br>

					</div>
					<div class="col-sm-6" align="center">
						<b><h6>@lang('order_details.status', [], $locale)</h6></b>
						<div class="mb-3">@lang($order->getFormattedState(), [], $locale)</div>
						<h6>
						
						
			
						
						@lang('order_details.progress', [], $locale)
						
						
						</h6>
						<div class="progress" style="height: 22px; width: 60%">
							<div class="progress-bar" role="progressbar"
								style="width: {{ $book->getTranslationProgress() }}%;"
								aria-valuenow="{{ $book->getTranslationProgress() }}"
								aria-valuemin="0" aria-valuemax="100">{{
								$book->getFormattedTranslationProgress() }}</div>
						</div>

					</div>
				</div>

			</div>
		</div>

	</div>

</div>