<!-- resources/views/fes/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Fes 投稿一覧</title>
</head>
<body>
    <h1>Fes 投稿一覧</h1>
    <ul>
        @foreach($fesPosts as $post)
            <li>
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                <p>フェス名: {{ $post->fes_name }}</p>
                <p>ハッシュタグ: {{ $post->hashtag }}</p>
            </li>
        @endforeach
    </ul>
</body>
</html>
