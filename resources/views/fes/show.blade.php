<x-app-layout>
    <x-slot name="header">
        <h1>{{ $fes->fes_name }}</h1>
    </x-slot>

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
    <div class="edit">
        <a href="/fes/{{ $fes->id }}/edit">編集</a>
    </div>
</x-app-layout>