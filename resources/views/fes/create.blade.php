<!-- resources/views/fes/create.blade.php --> 
@extends('layouts.app')

@section('content') 
<div class="container">
    <h1>新規フェス投稿作成</h1>

    <form action="{{ route('fes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="body">全体の感想</label>
            <textarea name="body" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="fes_name">フェスの名前</label>
            <input type="text" name="fes_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="hashtag">ハッシュタグ</label>
            <input type="text" name="hashtag" class="form-control">
        </div>

        <div class="form-group">
            <label for="date">開催日時</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <h3>アーティスト情報</h3>
        <div id="artist-container">
            <button type="button" class="btn btn-secondary mb-3" onclick="addArtist()">アーティスト追加</button> 
        </div>

        <button type="submit" class="btn btn-primary mt-3">投稿する</button>
    </form>
</div>

<script>
    let artistIndex = 0;

    function addArtist() {
        let artistContainer = document.getElementById('artist-container');
        let artistHtml = `
            <div class="artist-block mb-4">
                <h4>アーティスト ${artistIndex + 1}</h4>
                <div class="form-group">
                    <label for="artists[${artistIndex}][name]">名前</label>
                    <input type="text" name="artists[${artistIndex}][name]" class="form-control" required>
                </div>
            <div class="form-group">
                <label for="artists[${artistIndex}][body]">感想</label>
                <textarea name="artists[${artistIndex}][body]" class="form-control"></textarea>
            </div>

            <h5>セットリスト</h5>
            <div class="setlist-container" data-index="${artistIndex}">
                <button type="button" class="btn btn-secondary mb-2" onclick="addSetlist(${artistIndex})">セットリスト</button>
            </div>
        </div>
    `;
    artistContainer.insertAdjacentHTML('beforeend', artistHtml);
    artistIndex++;
}

function addSetlist(artistIndex) {
    let setlistContainer = document.querySelector(`.setlist-container[data-index='${artistIndex}']`);
    let setlistCount = setlistContainer.childElementCount - 1;
    let setlistHtml = `
        <div class="form-group mb-2">
            <label for="artists[${artistIndex}][setlists][${setlistCount}][song_name]">曲名</label>
            <input type="text" name="artists[${artistIndex}][setlists][${setlistCount}][song_name]" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label for="artists[${artistIndex}][setlists][${setlistCount}][position]">曲順</label>
            <input type="number" name="artists[${artistIndex}][setlists][${setlistCount}][position]" class="form-control" required>
        </div>
    `;
    setlistContainer.insertAdjacentHTML('beforeend', setlistHtml);
    }
</script>
@endsection