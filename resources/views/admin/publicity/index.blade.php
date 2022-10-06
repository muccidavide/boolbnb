@extends('layouts.app')
@section('content')
@if (session('success_message'))
            <div class='alert alert-success'>
                {{ session('success_message') }}
            </div>
@endif
   <div class="container">
   <h2 class='text-center'>Seleziona la sponsorizzazione</h2>
     <div class="row row-cols-12">
        @foreach($publicities as $publicity)
        <div class="col offset-1 mt-5 text-center">
            <a href="{{route('admin.publicity.edit', [$apartment->id, $publicity->id])}}">
                <div class="card py-4 d-flex flex-column justify-content-around">
                    <h3 class='py-2'>{{$publicity->type}}</h3>
                    <img height='150' src="https://picsum.photos/300" alt="{{$publicity->type}}">
                    <div class="d-flex align-items-center justify-content-between p-2">
                        <p>costo sottoscrizione</p>
                        <p class='py-4'>{{$publicity->price}} €</p>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between p-2">
                        <p>durata sottoscrizione</p>
                        <p class='py-4'>{{$publicity->duration}} ore</p>
                    </div>
                    
                </div>

            </a>
        </div>
        @endforeach
     </div>
   </div>
@endsection