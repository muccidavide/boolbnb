@extends('layouts.app')

@section('content')
    <section id="dashboard">
        <div class="card">
            <div class="card-header">
                <h2>{{ __('Dashboard') }}</h2>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                Adesso sei loggato!
            </div>
        </div>
    </section>
@endsection
