<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Tournament;
use App\Models\Player;
use App\Models\Organiser;
use App\Services\TranslationService;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])->except(['index','show']);
    }

    public function index()
    {
        $tournaments = Tournament::with('players')
                          ->orderByDesc('created_at')
                          ->paginate(10);

        return view('pages.archives', compact('tournaments'));
    }

    public function create()
    {
        return view('tournaments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organiser.name'                => 'required|string|max:255',
            'organiser.contact_information' => 'nullable|string|max:500',
            'organiser.website_link'        => 'nullable|url',

            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'prize_pool'       => 'nullable|numeric',
            'competition_type' => 'required|string|in:1v1,2v2,4v4',
            'tournament_type'  => 'required|string|max:100',
            'location'         => 'nullable|string|max:255',

            'matchups'                    => 'required|array',
            'matchups.*.*.player1_name'  => 'required|string|max:255',
            'matchups.*.*.player2_name'  => 'required|string|max:255',
            'matchups.*.*.player1_score' => 'nullable|integer|min:0',
            'matchups.*.*.player2_score' => 'nullable|integer|min:0',

            'sources'                => 'array',
            'sources.*.stream_url'   => 'nullable|url',
            'sources.*.video_url'    => 'nullable|url',
            'sources.*.forum_url'    => 'nullable|url',
        ]);

        $organiserData = $data['organiser'];
        $organiser = Organiser::firstOrCreate(
            ['name' => $organiserData['name']],
            Arr::only($organiserData, ['contact_information','website_link'])
        );

        $tournament = Tournament::create([
            'organiser_id'     => $organiser->id,
            'title'            => $data['title'],
            'description'      => $data['description'],
            'prize_pool'       => $data['prize_pool'] ?? null,
            'competition_type' => $data['competition_type'],
            'tournament_type'  => $data['tournament_type'],
            'location'         => $data['location'] ?? null,
        ]);

        $names = collect($data['matchups'])
            ->collapse()
            ->flatMap(fn($m) => [
                $m['player1_name'], $m['player2_name']
            ])
            ->unique();

        $playerIds = $names->map(fn($name) =>
            Player::firstOrCreate(['name' => $name])->id
        )->all();

        $tournament->players()->sync($playerIds);

        $initialCount = count($playerIds);
        $stageNames = [
            64 => 'Round of 64',
            32 => 'Round of 32',
            16 => 'Round of 16',
             8 => 'Quarterfinals',
             4 => 'Semifinals',
             2 => 'Grand Final',
        ];

        foreach ($data['matchups'] as $roundIndex => $matches) {
            $playersThisRound = (int) max(2, $initialCount / (2 ** $roundIndex));
            $stage = $stageNames[$playersThisRound] ?? "Round of {$playersThisRound}";

            foreach ($matches as $m) {
                $p1 = Player::where('name', $m['player1_name'])->first()->id;
                $p2 = Player::where('name', $m['player2_name'])->first()->id;

                $tournament->matchUps()->create([
                    'round'          => $roundIndex,
                    'stage'          => $stage,
                    'player1_id'     => $p1,
                    'player2_id'     => $p2,
                    'player1_score'  => $m['player1_score'] ?? null,
                    'player2_score'  => $m['player2_score'] ?? null,
                ]);
            }
        }

        foreach ($data['sources'] ?? [] as $s) {
            $tournament->sources()->create($s);
        }

        return redirect()
               ->route('archives')
               ->with('success', 'Tournament created!');
    }


    public function show(Tournament $tournament, Request $request, TranslationService $translator)
    {
        $tournament->load([
            'organiser',
            'players',
            'matchUps.player1',
            'matchUps.player2',
            'sources',
            'comments.user',
        ]);

        $language = $request->input('lang', 'en');

        $translatedDescription = $language !== 'en'
            ? $translator->translate($tournament->description, $language)
            : $tournament->description;

        return view('tournaments.show', compact('tournament', 'translatedDescription', 'language'));
    }
}
