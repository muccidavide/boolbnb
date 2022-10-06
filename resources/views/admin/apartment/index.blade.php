@extends('layouts.app')
@section('content')
    <section id="dashboard">

        <div class="row">

            <!-- /.col sx -->
            <div class="container">
                {{-- messaggio di creazione, modifica, eliminazione --}}
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Sezione per aggiungere un ulteriore appartamento -->
                <div class="d-flex justify-content-between py-4">
                    <h1>Lista di appartamenti</h1>
                    <div id="query_mobile">
                        <a href="{{ route('admin.apartment.create') }}" class="media_none btn btn-primary text-white">Aggiungi nuovo
                            appartamento
                        </a>
                        <a href="{{ route('admin.apartment.create') }}" class="media_block btn btn-primary text-white d-none">+
                        </a>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Titolo</th>
                                <th class="d_none">Immagine</th>
                                <th>Indirizzo</th>
                                <th class="d_none">Servizi</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @forelse($apartments as $apartment)
                                <tr>
                                    <td scope="row" class={{ $apartment->visibility ? 'bg-light' : 'opacity-50' }}>{{ $apartment->id }}</td>
                                    <td class={{ $apartment->visibility ? 'bg-light' : 'opacity-50' }}>{{ $apartment->title }}</td>
                                    <td class="d_none" > <img style="max-width: 200px" class={{ $apartment->visibility ? 'bg-light' : 'opacity-50' }} src="{{ asset('/storage/' . $apartment->thumb) }}"
                                            alt="thumb of {{ $apartment->title }}"></td>
                                    <td class={{ $apartment->visibility ? 'bg-light' : 'opacity-50' }}>{{ $apartment->address }}</td>
                                    <td class="d_none">
                                        @if (count($apartment->services) > 0)
                                            @foreach ($apartment->services as $service)
                                                <span class={{ $apartment->visibility ? 'bg-light' : 'opacity-50' }}>#{{ $service->name }}</span>
                                            @endforeach
                                        @else
                                            <span class={{ $apartment->visibility ? 'bg-light' : 'opacity-50' }}>Nessun Servizio</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <a class="btn btn-primary text-white btn-sm"
                                                    href="{{ route('admin.apartment.show', $apartment->slug) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="btn btn-success text-white btn-sm"
                                                    href="{{ route('admin.apartment.edit', $apartment->slug) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                        <path
                                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                                    </svg>
                                                </a>

                                            </li>
                                            <li>
                                                <!-- Bottone per avviare la modale -->
                                                <button type="button" class="btn btn-danger btn-sm text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete-apartment-{{ $apartment->slug }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                    </svg>
                                                </button>

                                                <!-- Modale -->
                                                <div class="modal fade" id="delete-apartment-{{ $apartment->slug }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="modelTitle-{{ $apartment->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Elimina appartmento:
                                                                    "{{ $apartment->title }}"</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Sei sicuro di voler eliminare questo appartamento?<br>
                                                                !Attenzione questa è un'operazione distruttiva!
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annulla</button>


                                                                <form
                                                                    action="{{ route('admin.apartment.destroy', $apartment->slug) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button type="submit"
                                                                        class="btn btn-danger text-white">Elimina</button>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Bottone per accedere alle sponsorizzazioni -->
                                            <li>
                                                <a class='btn btn-light border rounded border-dark text-dark btn-sm' href="{{ route('admin.publicity.index', $apartment->id)}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                                </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td scope="row">
                                        Nessun appartamento da mostrare 😥. Inserisci il tuo primo appartamento<a
                                            class='display-5 text-primary' href="{{ route('admin.apartment.create') }}">
                                            Qui</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col dx -->
        </div>
        <!-- /.row down Dashboard -->
    </section>
@endsection
