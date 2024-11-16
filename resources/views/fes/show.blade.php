<!-- resources/views/fes/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Fes 投稿一覧</title>
</head>
<body>
    <div class="container">
        <h1>{{ $fes->title }}</h1>
        <p>{{ $fes->body }}</p>
        <p>フェス名: {{ $fes->fes_name }}</p>
        <p>ハッシュタグ: {{ $fes->hashtag }}</p>
        <p>開催日時: {{ $fes->date }}</p>

        <h2>アーティスト一覧</h2>
        @foreach ($fes->artists as $artist)
            <div class="artist">
                <h3>{{ $artist->name }}</h3>
                <p>{{ $artist->body }}</p>

                <h4>セットリスト</h4>
                <ul>
                    @foreach ($artist->setlists as $setlist)
                        <li>{{ $setlist->position }}. {{ $setlist->song_name }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</body>
</html>
