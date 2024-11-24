<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('memorock 投稿一覧') }}</h2>
        <p>{{ Auth::user()->name }}</p>
    </x-slot>

    <a href='/fes/create' style="
        display: inline-block;
        background-color: #A8D5BA;
        color: black;
        padding: 6px 16px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
    ">
        新規フェス投稿作成
    </a>

    <h1>Fes 投稿一覧</h1>
    <ul>
        @foreach($fesPosts as $post)
            <li>
                <h2 class='title'>
                    <a href="/fes/{{ $post->id }}">{{ $post->title }}</a>
                </h2>
                <p>{{ $post->body }}</p>
                <p>フェス名: {{ $post->fes_name }}</p>
                <p>ハッシュタグ: {{ $post->hashtag }}</p>
                
                <form action="{{ route('fes.delete', ['fes' => $post->id]) }}" method="POST" id="{{ 'form_' . $post->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="{{ 'deletePost(' . $post->id . ')' }}">削除</button>
                </form>

            </li>
        @endforeach
    </ul>

    <script>
        function deletePost(postId) {
            if (confirm('本当に削除しますか？')) {
                document.getElementById(`form_${postId}`).submit();
            }
        }
    </script>
</x-app-layout>