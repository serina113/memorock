<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">新規フェス投稿作成</h1>
    </x-slot>

    <form action="{{ route('fes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" class="form-control" placeholder="タイトルを入力" required>
        </div>

        <div class="form-group">
            <label for="image">画像登録</label>
            <input type="file" class="form-control-file" name="image" id="image">
        </div>

        <div class="form-group">
            <label for="fes_name">フェスの名前</label>
            <input type="text" name="fes_name" class="form-control" placeholder="フェスの名前を入力" required>
        </div>

        <div class="form-group">
            <label for="hashtag">ハッシュタグ</label>
            <input type="text" name="hashtag" class="form-control">
        </div>

        <div class="form-group">
            <label for="date">開催日時</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="body">全体の感想</label>
            <textarea name="body" class="form-control" rows="5" placeholder="フェス全体の感想を入力してください" required></textarea>
        </div>

        <h3 class="text-2xl font-bold">アーティスト情報</h3>
        <div id="artist-container">
            <button type="button" class="btn btn-success mb-3" onclick="addArtist()">
                アーティスト追加
            </button> 
        </div>

        <button type="submit" class="btn btn-primary mt-3">投稿する</button>
    </form>

    <script>
        let artistIndex = 0;

        function addArtist() {
            const artistContainer = document.getElementById('artist-container');
            const artistHtml = `
                <div class="artist-block mb-4">
                    <h4>アーティスト ${artistIndex + 1}</h4>
                    <div class="form-group">
                        <label for="artists[${artistIndex}][name]">名前</label>
                        <input type="text" name="artists[${artistIndex}][name]" class="form-control" placeholder="アーティスト名を入力" required>
                    </div>
                    <div class="form-group">
                        <label for="artists[${artistIndex}][body]">感想</label>
                        <textarea name="artists[${artistIndex}][body]" class="form-control" rows="3" placeholder="感想を入力"></textarea>
                    </div>

                    <h5>セットリスト登録</h5>
                    <div class="setlist-container" data-index="${artistIndex}">
                        <button type="button" class="btn btn-secondary mb-2" onclick="addSetlist(${artistIndex})">
                            セットリスト追加
                        </button>
                    </div>
                </div>
            `;
            artistContainer.insertAdjacentHTML('beforeend', artistHtml);
            artistIndex++;
        }

        function addSetlist(artistIndex) {
            const setlistContainer = document.querySelector(`.setlist-container[data-index='${artistIndex}']`);
            const setlistCount = setlistContainer.querySelectorAll('.form-group').length / 2;
            const setlistHtml = `
                <div class="form-group mb-2">
                    <label for="artists[${artistIndex}][setlists][${setlistCount}][song_name]">曲名</label>
                    <input type="text" name="artists[${artistIndex}][setlists][${setlistCount}][song_name]" class="form-control" placeholder="曲名を入力" required>
                </div>
                <div class="form-group mb-2">
                    <label for="artists[${artistIndex}][setlists][${setlistCount}][position]">曲順</label>
                    <input type="number" name="artists[${artistIndex}][setlists][${setlistCount}][position]" class="form-control" placeholder="曲順を入力" required>
                </div>
            `;
            setlistContainer.insertAdjacentHTML('beforeend', setlistHtml);
        }
    </script>
</x-app-layout>
