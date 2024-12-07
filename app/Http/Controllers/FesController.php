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

    public function edit($id)
    {
    // 投稿をIDで取得
    $post = Fes::with('artists.setlists')->findOrFail($id);

    // ビューに渡す
    return view('fes.edit', compact('post'));
    }


    public function update(Request $request, $id)
    {
        $post = Fes::findOrFail($id);
    
        // 基本情報の更新
        $post->update([
            'title' => $request->post['title'],
            'body' => $request->post['body'],
            'fes_name' => $request->post['fes_name'],
            'hashtag' => $request->post['hashtag'],
            'date' => $request->post['date'],
        ]);

    
        // 現在のアーティストIDを取得
        $existingArtistIds = $post->artists()->pluck('id')->toArray();
        $submittedArtistIds = array_column($request->post['artists'], 'id');
    
        // 削除されるアーティストを削除
        $artistsToDelete = array_diff($existingArtistIds, $submittedArtistIds);
        Artist::whereIn('id', $artistsToDelete)->each(function ($artist) {
            $artist->setlists()->delete();
            $artist->delete();
        });

        // 画像が送信されていれば保存
        if ($request->hasFile('image')) {
            // 画像を storage/app/public ディレクトリに保存
            $imagePath = $request->file('image')->store('images', 'public');
        
            // 画像パスをデータベースに保存
            $post->image_path = $imagePath;
            $post->save();
        }
    
        // アーティストを更新または作成
        foreach ($request->post['artists'] as $artistData) {
            $artist = Artist::updateOrCreate(
                ['id' => $artistData['id'] ?? null], // IDがあれば更新、なければ作成
                [
                    'fes_id' => $post->id,
                    'name' => $artistData['name'],
                    'body' => $artistData['body'],
                ]
            );
    
            // 現在のセットリストIDを取得
            $existingSetlistIds = $artist->setlists()->pluck('id')->toArray();
            $submittedSetlistIds = array_column($artistData['setlists'] ?? [], 'id');
    
            // 削除されるセットリストを削除
            $setlistsToDelete = array_diff($existingSetlistIds, $submittedSetlistIds);
            Setlist::whereIn('id', $setlistsToDelete)->delete();
    
            // セットリストを更新または作成
            foreach ($artistData['setlists'] ?? [] as $setlistData) {
                Setlist::updateOrCreate(
                    ['id' => $setlistData['id'] ?? null], // IDがあれば更新、なければ作成
                    [
                        'artist_id' => $artist->id,
                        'song_name' => $setlistData['song_name'],
                        'position' => $setlistData['position'],
                    ]
                );
            }
        }
    
        return redirect()->route('fes.show', $post->id)->with('success', '投稿を更新しました');
    }
    
    public function store(Request $request)
    {
        // Fes を作成
        $fes = Fes::create(array_merge($request->only(['title', 'body', 'fes_name', 'hashtag', 'date']), [
            'user_id' => Auth::id(),
        ]));

        // アーティストとセットリストを保存
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

        return redirect()->route('fes.index')->with('success', '投稿を作成しました');
    }


    public function delete(Fes $fes)
    {
        $fes->artists()->each(function ($artist) {
            $artist->setlists()->delete();
            $artist->delete();
        });

        $fes->delete();

        return redirect()->route('fes.index');
    }

}