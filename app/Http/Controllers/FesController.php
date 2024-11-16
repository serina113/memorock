<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fes;
use App\Models\Artist;
use App\Models\Setlist;

class FesController extends Controller
{
    /**
 * Fes投稿一覧を表示する
 * 
 * @param Fes Fesモデル
 * @return array Fesモデルリスト
 */
    public function index(Fes $fes)
    {
        $fesPosts = $fes->get();
        return view('fes.index', compact('fesPosts'));
    }
    public function show(Fes $fes)
    {
    // Fesに関連するArtistsと、それぞれのSetlistsもEager Loadingで取得
        $fes->load(['artists.setlists']);
    
        return view('fes.show', compact('fes'));
    }
    public function create() 
    {
        return view('fes.create'); 
    }

    public function store(Request $request) 
    {
        $fes = Fes::create([
        'title' => $request->input('title'), 
        'body' => $request->input('body'), 
        'fes_name' => $request->input('fes_name'), 
        'hashtag' => $request->input('hashtag'), 
        'date' => $request->input('date'), 
        'user_id' => Auth::id(),
        ]);
        
        foreach ($request->input('artists', []) as $artistData) { 
            $artist = $fes->artists()->create([
                'name' => $artistData['name'],
                'body' => $artistData['body'],
        ]);
        foreach ($artistData['setlists'] ?? [] as $setlistData) { 
            $artist->setlists()->create([
                'song_name' => $setlistData['song_name'],
                'position' => $setlistData['position'], 
            ]);
            }
        }
            return redirect()->route('fes.index')->with('success', '投稿が完了しました');
            
    }
}