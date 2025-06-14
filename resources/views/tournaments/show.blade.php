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
      .round-row { margin-bottom: 2em; }
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
      .matchup-block .vs { text-align: center; margin: 0.5em 0; font-weight: bold; }
    </style>

    @php
      // Total participants at start
      $initialPlayers = $tournament->players->count();
      // Group and sort matchups by their round index
      $groups = $tournament->matchUps->groupBy('round')->sortKeys();
      // Stage labels by number of participants
      $stageLabels = [
        64 => 'Round of 64',
        32 => 'Round of 32',
        16 => 'Round of 16',
         8 => 'Quarterfinals',
         4 => 'Semifinals',
         2 => 'Grand Final',
      ];
      // Max round index
      $maxRound = $groups->keys()->max();
    @endphp

    <div class="bracket-rows">
      @for($round = 0; $round <= $maxRound; $round++)
        @if(isset($groups[$round]))
          @php
            $playersThisRound = (int) max(2, $initialPlayers / (2 ** $round));
            $stageName = $stageLabels[$playersThisRound] ?? "Round of {$playersThisRound}";
          @endphp

          <div class="round-row">
            <div class="round-title">{{ $stageName }}</div>
            <div class="matches-row">
              @foreach($groups[$round] as $match)
                <div class="matchup-block">
                  <div class="player">
                    {{ $match->player1->name }} – {{ $match->player1_score ?? '–' }}
                  </div>
                  <div class="vs">vs</div>
                  <div class="player">
                    {{ $match->player2->name }} – {{ $match->player2_score ?? '–' }}
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endfor
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
      <p>No comments yet. Be the first to comment!</p>
    @endforelse
  </section>

@endsection