<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TwitterController extends Controller
{
    // ツイート投稿画面にリダイレクトするメソッド
    public function redirectToProvider(Request $request)
    {
        $redirectUrlToLaravel = $request->input('redirect_url', route('fes.index'));
        session(['redirect_url_to_Laravel' => $redirectUrlToLaravel]);
        
        $url = 'https://twitter.com/i/oauth2/authorize';
        $params = http_build_query([
            'response_type' => 'code',
            'client_id' => env('TWITTER_CLIENT_ID'),
            'redirect_uri' => env('TWITTER_REDIRECT_URI'),
            'scope' => 'tweet.read tweet.write users.read offline.access',
            'state' => 'state',
            'code_challenge' => 'challenge',
            'code_challenge_method' => 'plain',
        ]);

        return redirect($url . '?' . $params);
    }

    // Twitterからのコールバックを受け取り、アクセストークンを取得するメソッド
    /**
     * 認可コードを受け取り処理
     */
    public function handleProviderCallback(Request $request)
    {
        $client = new Client();
        
        $code = $request->input('code');
        $state = $request->input('state');

        if (!$code || !$state) {
            dd(1);
            return redirect('/')->with('error', '認可コードまたはstateが取得できませんでした。');
        }
    
        // アクセストークン取得用のリクエストデータ
        $tokenEndpoint = 'https://api.twitter.com/2/oauth2/token';
        $clientId = env('TWITTER_CLIENT_ID');
        $clientSecret = env('TWITTER_CLIENT_SECRET');
        $redirectUri = env('TWITTER_REDIRECT_URI');
        $basicAuthHeader = base64_encode($clientId . ':' . $clientSecret);
    
        try {
            // アクセストークンリクエスト
            $response = $client->post($tokenEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . $basicAuthHeader,
                ],
                'form_params' => [
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                    'code_verifier' => 'challenge',
                    'client_id' => $clientId,
                ],
            ]);

            // レスポンスをJSON形式で取得
            $tokenData = json_decode($response->getBody()->getContents(), true);

            // 必要なトークン情報をセッションに保存
            Session([
                'access_token' => $tokenData['access_token'],
                'refresh_token' => $tokenData['refresh_token'],
                'expires_in' => $tokenData['expires_in'],
                'token_type' => $tokenData['token_type'],
                'scope' => $tokenData['scope'],
            ]);

            $redirectUrlToLaravel = session('redirect_url_to_Laravel', route('fes.index'));
            
            return redirect($redirectUrlToLaravel)->with('success', 'Twitter認証が成功しました。');
        } catch (\Exception $e) {
            dd($e);
            return redirect('/')->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }

     /**
     * アクセストークンを取得
     */
    public function postTweet(Request $request)
    {
        $client = new Client();
        $clientId = env('TWITTER_CLIENT_ID');
        $clientSecret = env('TWITTER_CLIENT_SECRET');
        $access_token = session('access_token');

        if (!$access_token) {
            return response()->json(['error' => 'Access token not found'], 400);
        }

        $tokenEndpoint = 'https://api.twitter.com/2/tweets';
        $text = $request->input('text'); 

        try {
            $response = $client->post($tokenEndpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'text' => $text,
                ],
            ]);

            return redirect('/')->with('success', 'ツイートが成功しました。');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect('/')->with('success', 'ツイートが失敗しました。');
        }
    }
}
