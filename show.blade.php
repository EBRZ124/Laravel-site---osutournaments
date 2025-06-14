{{-- resources/views/tournaments/show.blade.php --}}
@extends('layouts.app')

@section('content')

  {{-- Tournament Title & Description --}}
  <article class="box post">
    <header><h2>{{ $tournament->title }}</h2></header>
    <p>{{ $tournament->description }}</p>
  </article>

  {{-- Participants List --}}
  <section class="box post">
    <header><h3>Participants</h3></header>
    <ul>
      @foreach($tournament->players as $player)
        <li>
          {{ $player->name }}
          @if($player->country)
            ({{ $player->country }})
          @endif
        </li>
      @endforeach
    </ul>
  </section>

  {{-- Bracket Display --}}
  <section class="box post">
    <header><h3>Bracket</h3></header>

    <style>
      .bracket-rows { display: flex; flex-direction: column; gap: 2em; }
      .round-row   { }
      .round-title { margin-bottom: 0.5em; font-size: 1.1em; }
      .matches-row { display: flex; gap: 1em; overflow-x: auto; }
      .matchup-block {
        border: 1px solid #ccc;
        border-radius: 0.4em;
        padding: 0.75em;
        background: #fff;
        box-shadow: 0 0.5em 1em rgba(0,0,0,0.1);
        min-width: 180px;
      }
      .matchup-block .player { font-weight: 500; }
      .matchup-block .vs     { text-align: center; margin: 0.5em 0; font-weight: bold; }
    </style>

    @php
      // 1) Eager-load matchUps ordered by round
      $matchUps = $tournament->matchUps->sortBy('round');

      // 2) Group them by the 'stage' column
      $byStage = $matchUps->groupBy('stage');
    @endphp

    <div class="bracket-rows">
      @foreach($byStage as $stageName => $matches)
        <div class="round-row">
          <div class="round-title">{{ $stageName }}</div>
          <div class="matches-row">
            @foreach($matches as $m)
              <div class="matchup-block">
                <div class="player">
                  {{ $m->player1->name }} – {{ $m->player1_score ?? '–' }}
                </div>
                <div class="vs">vs</div>
                <div class="player">
                  {{ $m->player2->name }} – {{ $m->player2_score ?? '–' }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- Sources --}}
  <section class="box post">
    <header><h3>Sources</h3></header>
    <ul>
      @foreach($tournament->sources as $s)
        @if($s->stream_url)
          <li><a href="{{ $s->stream_url }}">Stream</a></li>
        @endif
        @if($s->video_url)
          <li><a href="{{ $s->video_url }}">Video Archive</a></li>
        @endif
        @if($s->forum_url)
          <li><a href="{{ $s->forum_url }}">Forum Thread</a></li>
        @endif
      @endforeach
    </ul>
  </section>

  {{-- Comments --}}
<section class="box post">
  <header><h3>Comments</h3></header>

  {{-- 1) List all existing comments --}}
  @forelse($tournament->comments as $c)
    <div class="comment">
      <strong>{{ $c->user->name }}</strong> says:
      <p>{{ $c->body }}</p>
    </div>
  @empty
    <p>No comments yet.</p>
  @endforelse

  {{-- 2) If user is logged in & verified, show form --}}
  @auth
    <form method="POST" action="{{ route('comments.store', $tournament) }}" style="margin-top:1em;">
      @csrf
      <div class="field">
        <label for="body">Leave a comment</label>
        <textarea name="body" id="body" rows="3" required></textarea>
        @error('body')
          <div class="error" style="color:red">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="button">Post Comment</button>
    </form>
  @else
    <p><a href="{{ route('login') }}">Log in</a> to leave a comment.</p>
  @endauth
</section>


@endsection
