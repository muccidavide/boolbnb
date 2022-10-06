@extends('layouts.app')
@section('content')
<? var_dump(json_encode($publicity)) ?>
<div class="container">
    <h5 class="pt-4">Modifica appartamento</h5>
    <h2 class="pb-4">"{{ $apartment->title }}"</h2>
    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('admin.apartment.update', $apartment->slug) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Titolo -->
        <div class="mb-4">
            <label for="title">Titolo*</label>
            <input type="text" name="title" required id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Appartamento con Soffitto Affrescato Vista Mare" aria-describedby="titleHelper" value="{{ old('title', $apartment->title) }}">
            <small id="titleHelper" class="text-muted">Modifica il Titolo dell'appartamento, massimo 150
                caratteri</small>
        </div>
        <!-- Thumb -->
        <div class="apartment-thumb">
            <img class="img-fluid" src="{{ asset('/storage/' . $apartment->thumb) }}" alt="thumb of {{ $apartment->title }}">
        </div>
        <div class="mb-4">
            <label for="thumb">Immagine*</label>
            <input type="file" name="thumb" id="thumb" class="form-control  @error('thumb') is-invalid @enderror" aria-describedby="thumbHelper" value="{{ old('thumb', $apartment->thumb) }}">
            <small id="thumbHelper" class="text-muted">Modifica l'immagine dell'appartamento (formati accettati:
                wpeg,jpg,jpeg,png || max: 2MB)</small>
        </div>

        {{-- search-box --}}
        <div id="map" style="height:600px"></div>
        <div id="search-box"></div>
        <div class="my-3">
            <!-- Address -->
            <div class="my-3">
                <label for="address">Indirizzo*</label>
                <input type="text" name="address" required id="address" class="form-control  @error('address') is-invalid @enderror" placeholder="Via indipendenza 13, Milano 20090" aria-describedby="addressHelper" value="{{ old('address', $apartment->address) }}" readonly>
                <small id="addressHelper" class="text-muted">Modifica l'indirizzo dell'appartamento</small>
            </div>
            <div class="mb-3 d-none">
                <input class="form-control d-none" type="text" name="lat" id="lat" value="{{ old('lat', $apartment->lat) }}" readonly>
                <label class="text-muted" for="lat">
                    Latitudine
                </label>
            </div>
        </div>
        <div class="mb-3 d-none">
            <input class="form-control" type="text" name="lon" id="lon" value="{{ old('lon', $apartment->lon) }}" readonly>
            <label class="text-muted" for="lon">
                Longitudine
            </label>
        </div>

        <!-- Gallery -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4">
            @forelse($images as $image)
            <div class="col py-2">
                <img class="img-fluid w-100 custom-img" src="{{ asset('/storage/' . $image->src) }}" alt="$image->src">
            </div>

            @empty
            <div class="mb-3">
                <label for="cover_image" class="form-label">Immagini Galleria:</label>
                <input type="file" class="form-control  @error('cover_image') is-invalid @enderror" name="cover_image[]" value="" id="cover_image" placeholder="cover-img.jpg" aria-describedby="cover_imageHelpId" multiple>
                <div id="cover_imageHelpId" class="form-text">Inserisci le immagini che verranno visualizzate
                    all'interno della galleria</div>
            </div>
            @endforelse

        </div>
        @if (count($images) > 0)

        <div class="my-3">
            <div class="">
                <button class="btn btn-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Aggiungi immagini
                </button>
                <a class="btn btn-primary text-white" href="{{ route('admin.apartments.images.index', $apartment->slug) }}">
                    Aggiorna Immagini
                </a>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Immagini Galleria:</label>
                        <input type="file" class="form-control  @error('cover_image') is-invalid @enderror" name="cover_image[]" value="" id="cover_image" placeholder="cover-img.jpg" aria-describedby="cover_imageHelpId" multiple>
                        <div id="cover_imageHelpId" class="form-text">Inserisci le immagini che verranno
                            visualizzate all'interno della galleria</div>
                    </div>
                </div>
            </div>
        </div>

        @endif

        <!-- Body -->
        <div class="mb-4">
            <label for="description">Descrizione*</label>
            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" required id="description" rows="4">{{ old('description', $apartment->description) }}</textarea>
        </div>

        <!-- Details -->
        <div class="mb-3">
            <label for="rooms" class="form-label">Stanze*</label>
            <input type="number" name="rooms" required id="rooms" class="form-control" placeholder="5" aria-describedby="roomsHelper" min=1 value="{{ old('rooms', $apartment->rooms) }}">
            <small id="roomsHelper" class="text-muted">Modifica il numero delle stanze dell'appartamento</small>
        </div>
        <div class="mb-3">
            <label for="baths" class="form-label">Bagni*</label>
            <input type="number" name="baths" required id="baths" class="form-control" placeholder="3" aria-describedby="bedsHelper" min=1 value="{{ old('baths', $apartment->baths) }}">
            <small id="bedsHelper" class="text-muted">Modifica il numero dei bagni dell'appartamento</small>
        </div>
        <div class="mb-3">
            <label for="beds" class="form-label">Letti*</label>
            <input type="number" name="beds" required id="beds" class="form-control" placeholder="2" aria-describedby="bedsHelper" min=1 value="{{ old('beds', $apartment->beds) }}">
            <small id="bedsHelper" class="text-muted">Modifica il numero dei posti letto dell'appartamento</small>
        </div>
        <div class="mb-3">
            <label for="sqm" class="form-label">Metri quadrati*</label>
            <input type="number" name="sqm" required id="sqm" class="form-control" placeholder="80" aria-describedby="sqmHelper" min=10 value="{{ old('sqm', $apartment->sqm) }}">
            <small id="sqmHelper" class="text-muted">Modifica i metri quadrati dell'appartamento</small>
        </div>

        <div class="mb-4">
            <label for="tags" class="form-label m-0">Servizi*</label>
            <select multiple class="form-select select-services" name="services[]" required id="services" aria-label="services" >
                <option value="" disabled>Modifica uno o più servizi</option>
                @forelse ($services as $service)
                @if ($errors->any())
                <option value="{{ $service->id }}" {{ in_array($service->id, old('services')) ? 'selected' : '' }}>{{ $service->name }}
                </option>
                @else
                <option value="{{ $service->id }}" {{ $apartment->services->contains($service->id) ? 'selected' : '' }}>
                    {{ $service->name }}
                </option>
                @endif
                @empty
                <option value="">Non ci sono servizi</option>
                @endforelse
            </select>
        </div>
        <!-- Visibility -->
        <div class="mb-3">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" {{ $apartment->visibility ? 'checked' : '' }} value="true">
            <label class="form-check-label" for="visibility">
                Visibile
            </label>
        </div>
        <div class="mb-3">
            <input class="form-check-input" type="radio" name="visibility" id="visibility" {{ !$apartment->visibility ? 'checked' : '' }} value="false">
            <label class="form-check-label" for="visibility">
                Non visibile
            </label>
        </div>

        <!--  {{-- <a class='btn btn-light border rounded border-dark text-dark btn-sm' href="{{ route('admin.publicity.index')}}">
                    Sponsorizza appartamento                          
            </a> --}}   -->
        <button type="submit" class="btn btn-primary text-white">Conferma modifiche</button>

    </form>
</div>
<script>
    //let apartment = {!! json_encode($apartment->toArray()) !!};
    let apartment = <?php echo json_encode($apartment->toArray()); ?>;
    let latitude = apartment.lat;
    let longitude = apartment.lon;
    let address = apartment.address;
    let title = apartment.title
</script>
<script src="{{ asset('js/map_edit.js') }}"></script>
@endsection