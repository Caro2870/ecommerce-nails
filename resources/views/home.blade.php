@extends('layouts.app')

@section('content')
<section class="hero">
    <p class="badge">Estudio de uñas en Lima</p>
    <h1>{{ $siteName }}</h1>
    <p class="subtitle">Uñas impecables en Lima — diseños personalizados y acabado profesional.</p>
    <div class="hero-actions">
        <a class="btn btn-primary" href="{{ $whatsAppUrl }}" target="_blank" rel="noopener">Reservar por WhatsApp</a>
        <a class="btn btn-secondary" href="{{ route('gallery') }}">Ver galeria</a>
    </div>
</section>

<section class="cards-grid">
    <article class="card">
        <h2>Servicios</h2>
        <ul>
            <li>Manicure semipermanente</li>
            <li>Disenos personalizados</li>
            <li>Retoque y mantenimiento</li>
        </ul>
    </article>
    <article class="card">
        <h2>Ubicacion</h2>
        <p>{{ $address }}</p>
    </article>
</section>

<section class="section-title-wrap">
    <h2>Galeria destacada</h2>
    <a class="text-link" href="{{ route('gallery') }}">Ver todas</a>
</section>

<section class="gallery-grid">
    @forelse ($photos as $photo)
        <figure class="gallery-item">
            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption ?: 'Diseño de uñas' }}" loading="lazy" />
            @if($photo->caption)
                <figcaption>{{ $photo->caption }}</figcaption>
            @endif
        </figure>
    @empty
        <p class="empty-state">Pronto veras aqui los ultimos diseños de Jessica.</p>
    @endforelse
</section>
@endsection
