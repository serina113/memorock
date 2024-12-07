<x-app-layout>
    <x-slot name="header">
         <h1 class="title">編集画面</h1>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="content">
        <form action="/fes/{{ $post->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class='content__title'>
                <h2>タイトル</h2>
                <input type='text' name='post[title]' value="{{ $post->title }}">
            </div>

            <div class='content__fes_name'>
                <h2>フェス名</h2>
                <input type='text' name='post[fes_name]' value="{{ $post->fes_name }}">
            </div>

            <div class='content__hashtag'>
                <h2>ハッシュタグ</h2>
                <input type='text' name='post[hashtag]' value="{{ $post->hashtag }}">
            </div>

            <div class='content__date'>
                <h2>開催日時</h2>
                <input type='date' name='post[date]' value="{{ $post->date }}">
            </div>

            <div class='content__body'>
                <h2>フェス全体の感想</h2>
                <input type='text' name='post[body]' value="{{ $post->body }}">
            </div>

            <div class='content__image'>
                <h2>画像</h2>
                <input type="file" name="image" class="form-control">
                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Uploaded Image" class="mt-2" width="150">
                @endif
            </div>

            <div class='content__artist' id="artist-container">
                <h2>アーティスト</h2>
                @if(!empty($post->artists) && $post->artists->count())
                    @foreach($post->artists as $artistIndex => $artist)
                        <div class="artist-block" data-artist-index="{{ $artistIndex }}">
                            <h3>アーティスト {{ $artistIndex + 1 }}</h3>
                            <div>
                                <label>名前</label>
                                <input type="text" name="post[artists][{{ $artistIndex }}][name]" value="{{ $artist->name }}">
                            </div>
                            <div>
                                <label>感想</label>
                                <textarea name="post[artists][{{ $artistIndex }}][body]" rows="3">{{ $artist->body }}</textarea>
                            </div>
                            <h4>セットリスト</h4>
                            <div class="setlist-container">
                                @if(!empty($artist->setlists) && $artist->setlists->count())
                                    @foreach($artist->setlists as $setlistIndex => $setlist)
                                        <div class="setlist-block" data-setlist-index="{{ $setlistIndex }}">
                                            <div>
                                                <label>曲名</label>
                                                <input type="text" name="post[artists][{{ $artistIndex }}][setlists][{{ $setlistIndex }}][song_name]" value="{{ $setlist->song_name }}">
                                            </div>
                                            <div>
                                                <label>曲順</label>
                                                <input type="number" name="post[artists][{{ $artistIndex }}][setlists][{{ $setlistIndex }}][position]" value="{{ $setlist->position }}">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="add-setlist-btn" onclick="addSetlist({{ $artistIndex }})">セットリスト追加</button>
                        </div>
                    @endforeach
                @else
                    <p>アーティストが登録されていません。</p>
                @endif
            </div>

            <button type="button" id="add-artist-btn">アーティスト追加</button>
            <input type="submit" value="保存">
        </form>
    </div>

    <script>
        let artistIndex = {{ $post->artists->count() ?? 0 }};

        function addArtist() {
            const artistContainer = document.getElementById('artist-container');
            const artistHtml = `
                <div class="artist-block" data-artist-index="${artistIndex}">
                    <h3>アーティスト ${artistIndex + 1}</h3>
                    <div>
                        <label>名前</label>
                        <input type="text" name="post[artists][${artistIndex}][name]" value="">
                    </div>
                    <div>
                        <label>感想</label>
                        <textarea name="post[artists][${artistIndex}][body]" rows="3"></textarea>
                    </div>
                    <h4>セットリスト</h4>
                    <div class="setlist-container"></div>
                    <button type="button" class="add-setlist-btn" onclick="addSetlist(${artistIndex})">セットリスト追加</button>
                </div>
            `;
            artistContainer.insertAdjacentHTML('beforeend', artistHtml);
            artistIndex++;
        }

        function addSetlist(artistIndex) {
            const artistBlock = document.querySelector(`.artist-block[data-artist-index="${artistIndex}"] .setlist-container`);
            const setlistIndex = artistBlock.querySelectorAll('.setlist-block').length;
            const setlistHtml = `
                <div class="setlist-block" data-setlist-index="${setlistIndex}">
                    <div>
                        <label>曲名</label>
                        <input type="text" name="post[artists][${artistIndex}][setlists][${setlistIndex}][song_name]" value="">
                    </div>
                    <div>
                        <label>曲順</label>
                        <input type="number" name="post[artists][${artistIndex}][setlists][${setlistIndex}][position]" value="">
                    </div>
                </div>
            `;
            artistBlock.insertAdjacentHTML('beforeend', setlistHtml);
        }

        document.getElementById('add-artist-btn').addEventListener('click', addArtist);
    </script>
</x-app-layout>
