@extends('layouts.app')

@section('content')

<style>
    .box.post header h3 {
      font-size: 1.8rem;
      line-height: 0.5;
    }
    .box.post article header h2 {
      font-size: 2rem;
      line-height: 1.2;
    }
</style>

{{-- Language Selector --}}
<form method="GET" action="{{ url()->current() }}" style="margin-bottom: 1em;">
  <label for="lang">Translate description:</label>
  <select name="lang" onchange="this.form.submit()">
    <option value="en" {{ $language == 'en' ? 'selected' : '' }}>English</option>
    <option value="es" {{ $language == 'es' ? 'selected' : '' }}>Spanish</option>
    <option value="de" {{ $language == 'de' ? 'selected' : '' }}>German</option>
    <option value="lv" {{ $language == 'lv' ? 'selected' : '' }}>Latvian</option>

  </select>
</form>

{{-- Tournament Title & Description --}}
<article class="box post">
  <header><h2>{{ $tournament->title }}</h2></header>
  <p>{{ $translatedDescription }}</p>
</article>

<section class="box post">
<header><h3>Organiser</h3></header>
@if($tournament->organiser)
  <p><strong>{{ $tournament->organiser->name }}</strong></p>
  @if($tournament->organiser->contact_information)
    <p>Contact: {{ $tournament->organiser->contact_information }}</p>
  @endif
  @if($tournament->organiser->website_link)
    <p>Website: <a href="{{ $tournament->organiser->website_link }}" target="_blank">
      {{ $tournament->organiser->website_link }}
    </a></p>
  @endif
@else
  <p><em>No organiser info provided.</em></p>
@endif
</section>

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
    $matchUps = $tournament->matchUps->sortBy('round');
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

@forelse($tournament->comments as $c)
  <div class="comment">
    <strong>{{ $c->user->name }}</strong> says:
    <p>{{ $c->body }}</p>
  </div>
@empty
  <p>No comments yet.</p>
@endforelse

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
