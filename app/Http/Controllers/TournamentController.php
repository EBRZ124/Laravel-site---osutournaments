<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Tournament;
use App\Models\Player;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])
             ->except(['index','show']);
    }

    // 1) List all tournaments
    public function index()
    {
        $tournaments = Tournament::with('players')
                          ->orderBy('created_at','desc')
                          ->paginate(10);
        return view('pages.archives', compact('tournaments'));
    }

    // 2) Show form (you already have)
    public function create()
    {
        return view('tournaments.create'); 
    }

    // 3) Persist new tournament
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'prize_pool'       => 'nullable|numeric',
            'competition_type' => 'required|string|in:1v1,2v2,4v4',
            'tournament_type'  => 'required|string|max:100',
            'location'         => 'nullable|string|max:255',
            'matchups'         => 'required|array',
            'matchups.*.*.player1_name'  => 'required|string|max:255',
            'matchups.*.*.player2_name'  => 'required|string|max:255',
            'matchups.*.*.player1_score' => 'nullable|integer|min:0',
            'matchups.*.*.player2_score' => 'nullable|integer|min:0',
            'sources'          => 'array',
            'sources.*.stream_url' => 'nullable|url',
            'sources.*.video_url'  => 'nullable|url',
            'sources.*.forum_url'  => 'nullable|url',
        ]);

        // a) Create tournament
        $t = Tournament::create(
            Arr::only($data, [
                'title','description','prize_pool',
                'competition_type','tournament_type','location'
            ])
        );

        // b) Collect unique player names
        $names = collect($data['matchups'])
            ->collapse()
            ->flatMap(fn($m) => [
                $m['player1_name'], $m['player2_name']
            ])
            ->unique();

        // c) Find or create players and gather IDs
        $ids = $names->map(fn($name) => 
            Player::firstOrCreate(['name'=>$name])->id
        )->all();

        // d) Attach pivot
        $t->players()->sync($ids);

        // e) Save each matchup
        foreach ($data['matchups'] as $roundIndex => $matches) {
            foreach ($matches as $m) {
                $p1 = Player::where('name', $m['player1_name'])->first()->id;
                $p2 = Player::where('name', $m['player2_name'])->first()->id;
        
                $t->matchUps()->create([
                    // ← THIS MUST BE PRESENT
                    'round'          => $roundIndex,
                    'player1_id'     => $p1,
                    'player2_id'     => $p2,
                    'player1_score'  => $m['player1_score'] ?? null,
                    'player2_score'  => $m['player2_score'] ?? null,
                ]);
            }
        }


        // f) Save sources
        foreach ($data['sources'] as $s) {
            $t->sources()->create($s);
        }

        return redirect()
            ->route('archives')
            ->with('success','Tournament created!');
    }

    // 4) Show a single tournament (you already have)
    public function show(Tournament $tournament)
    {
        $tournament->load([
            'players',
            'matchUps.player1',
            'matchUps.player2',
            'sources',
            'comments.user',
        ]);
    
        return view('tournaments.show', compact('tournament'));
    }
    
}


