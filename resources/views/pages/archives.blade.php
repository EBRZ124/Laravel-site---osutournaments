@extends('layouts.app')

@section('content')
  <h2>Archived Tournaments</h2>

  {{-- Success flash --}}
  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  {{-- Tournament list --}}
  @forelse($tournaments as $t)
    <article class="box post post-excerpt">
      <header>
        <h3>
          <a href="{{ route('tournaments.show', $t) }}">
            {{ $t->title }}
          </a>
        </h3>
        <span class="date">{{ $t->created_at->format('M j, Y') }}</span>
      </header>
      <p>{{ Str::limit($t->description, 150) }}</p>
      <a href="{{ route('tournaments.show', $t) }}" class="button">
        View Details
      </a>
    </article>
  @empty
    <p>No tournaments yet. Be the first to create one!</p>
  @endforelse

  {{-- Pagination --}}
  <div class="pagination" style="margin-top: 2em;">
    {{ $tournaments->links() }}
  </div>
@endsection
