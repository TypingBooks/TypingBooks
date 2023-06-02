			<div class="row">
				<div class="col-sm-12">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ url('/l') }}">@lang('crumb.language') {{ __('languages.' . $native_lang->abbreviation) }}</a>
							</li>
							
																					<li class="breadcrumb-item">
								<a href="{{ url('/l/' . $native_lang->abbreviation) }}">@lang('crumb.learning') {{ __('languages.' . $learning_lang->abbreviation) }}</a>
							</li>
							
							@if($isLanding)
							
									<li class="breadcrumb-item active" aria-current="page">@lang('crumb.materials') </li>
							
							
							@else
							
																					<li class="breadcrumb-item">
								<a href="{{ url('/l/' . $native_lang->abbreviation . '/' . $learning_lang->abbreviation) }}">@lang('crumb.materials')</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">@lang('landing.books')</li>
							
							
							@endif
						</ol>
					</nav>
				</div>
			</div>