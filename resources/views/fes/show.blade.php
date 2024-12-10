<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">{{ $fes->title }}</h1>
    </x-slot>

    <!-- Twitter共有ボタン -->
    <div class="mt-8 text-center">
    <form method="GET" action="{{ route('twitter.redirect') }}">
        <input type="hidden" name="redirect_url" value="{{ route('fes.show', $fes->id) }}">
        <button type="submit">Twitterで共有</button>
    </form>

    <form action="{{ route('twitter.post') }}" method="POST">
            @csrf
            <textarea name="text" placeholder="ツイート内容を入力"></textarea>
            <button type="submit">投稿</button>
    </form>

    </div>
    
    <div class="content">
        <h2>フェス名: {{ $fes->fes_name }}</h2>
        <p>ハッシュタグ: {{ $fes->hashtag }}</p>
        <p>開催日: {{ $fes->date }}</p>
        <p>感想: {{ $fes->body }}</p>

        <!-- 画像表示 -->
        @if ($fes->image_path)
            <div class="mt-4">
                <h3>投稿画像:</h3>
                <img src="{{ asset('storage/' . $fes->image_path) }}" alt="フェスの画像" class="mt-2 w-full max-w-xl">
            </div>
        @endif

        <h3 class="mt-8">アーティスト一覧</h3>
        @foreach($fes->artists as $artist)
            <div>
                <h4>{{ $artist->name }}</h4>
                <p>{{ $artist->body }}</p>

                <h5>セットリスト</h5>
                <ul>
                    @foreach($artist->setlists as $setlist)
                        <li>{{ $setlist->position }}. {{ $setlist->song_name }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <!-- 編集ボタン -->
        <div class="mt-8 text-center">
            <a href="{{ route('fes.edit', $fes->id) }}"
               class="bg-blue-500 text-black font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-blue-600 hover:shadow-xl transition duration-300">
                編集
            </a>
        </div>

        <!-- 投稿一覧に戻るボタン -->
        <div class="mt-4 text-center">
            <a href="{{ route('fes.index') }}"
               class="bg-yellow-500 text-black font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-yellow-600 hover:shadow-xl transition duration-300 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                投稿一覧に戻る
            </a>
        </div>
    </div>
</x-app-layout>
