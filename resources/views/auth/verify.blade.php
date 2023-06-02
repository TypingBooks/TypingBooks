@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('login2.verify') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('login2.verification_link') }}
                        </div>
                    @endif

                    {{ __('login2.before') }}
                    {{ __('login2.no_receive') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('login2.another_one') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
