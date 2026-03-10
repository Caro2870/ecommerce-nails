@extends('layouts.app')

@section('content')
<section class="section-title-wrap top-space">
    <div>
        <h1>Galeria de diseños</h1>
        <p class="subtitle-small">Trabajos recientes de {{ $siteName }}</p>
    </div>
</section>

@if($categories->isNotEmpty())
    <section class="tabs-wrap" aria-label="Categorias">
        @foreach ($categories as $category)
            <a
                class="tab-chip {{ $activeCategorySlug === $category->slug ? 'is-active' : '' }}"
                href="{{ route('gallery', ['cat' => $category->slug]) }}"
            >
                {{ $category->name }}
            </a>
        @endforeach
    </section>
@endif

<section class="gallery-grid big">
    @forelse ($photos as $photo)
        <figure class="gallery-item">
            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption ?: 'Diseño de uñas' }}" loading="lazy" />
            <figcaption>
                @if($photo->caption)
                    <strong>{{ $photo->caption }}</strong>
                @endif
                @if($photo->tags)
                    <span>{{ $photo->tags }}</span>
                @endif
            </figcaption>
        </figure>
    @empty
        <p class="empty-state">Aun no hay fotos publicadas.</p>
    @endforelse
</section>

<div class="pagination-wrap">
    {{ $photos->links() }}
</div>
@endsection
