<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Cient;
use Illuminate\Support\Facades\Log;

class TwitterController extends Controller
{
    // ツイート投稿画面にリダイレクトするメソッド
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    // Twitterからのコールバックを受け取り、アクセストークンを取得するメソッド
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('twitter')->user();

        // セッションまたはDBにトークンを保存
        session([
            'twitter_token' => $user->token,
            'twitter_token_secret' => $user->tokenSecret,
            'twitter_user_id' => $user->id,
        ]);

        Log::info('Session Data:', session()->all());

        return redirect()->route('dashboard')->with('success', 'Twitter認証が完了しました！');
    }

    public function postTweet(Request $request)
    {
        $token = session ('twitter_token');
        $tokenSecret = session('twitter_token_secret');
        $status = $request->input('status');

        $client = new Client([
            'base_uri' => 'https://api.twitter.com/2/',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        try {
            $response = $client->post('tweets', [
                'json' => [
                    'text' => $status,
                ],
            ]);

            return back()->with('success', '投稿が成功しました！');
        } catch (\Exception $e) {
            return back()->with('error', '投稿に失敗しました: ' . $e->getMessage());
        }
    }
}
