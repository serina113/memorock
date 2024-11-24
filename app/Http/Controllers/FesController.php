<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fes;
use App\Models\Artist;
use App\Models\Setlist;
use App\Models\User;
//use App\Http\Requests\FesRequest;

class FesController extends Controller
{
/**
 * Fes投稿一覧を表示する
 * 
 * @param Fes $fes Fesモデルのインスタンス
 * @return
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

    public function edit(Fes $post)
    {
        return view('fes.edit')->with(['fes' => $post]);
    }

    public function update(Request $request, Fes $post)
    {
        $input_post = $request->post;
        $post->fill($input_post)->save();

        return redirect('/fes/' . $post->id)->with('success', '投稿を更新しました');
    }

    public function store(Request $request, Fes $fes, Artists $artists, Setlist $setlists) 
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

    public function delete(Fes $fes)
    {
        $fes->artists()->each(function ($artist) {
            $artist->setlists()->delete();
            $artist->delete();
        });

        $fes->delete();

        return redirect()->route('fes.index')->with('success', 'フェス情報が削除されました！');
    }

}