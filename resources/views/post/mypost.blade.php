<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{$user->name??''}}さんの投稿一覧
    </h2>
  </x-slot>
  <div class="mx-auto px-6">
    @if (session('message'))
        <div class="text-red-600 font-bold">
          {{session('message')}}
        </div>
    @endif
    @if (count($posts) == 0)
      <p class="mt-4">
        あなたはまだ投稿していません。
      </p>
    @else
      @foreach ($posts as $post)
      <div class="mt-4 p-8 bg-white w-full rounded-2xl">
        <h1 class="p-4 text-lg font-semibold">
          <a href="{{route('post.show', $post)}}" class="text-blue-600">
            {{$post->title}}
          </a>
        </h1>
        <hr class="w-full">
        @if($post->image)
          <img src="/storage/images/{{$post->image}}" alt="投稿画像" width="500">
        @endif
        <p class="mt-4 p-4">
          {{Str::limit($post->body, 100, '...')}} 
        </p>
        <div class="p-4 text-sm font-semibold">
          <p>
            {{$post->created_at}}/{{$post->user->name??'匿名'}}
          </p>
          <hr class="w-full mb-2">
          @if ($post->comments->count())
            <span class="comment_badge">
                返信 {{$post->comments->count()}}件
            </span>
          @else
            <span>コメントはまだありません。</span>
          @endif
          <a href="{{route('post.show', $post)}}" style="color:white;">
            <x-primary-button class="float-right">コメントする</x-primary-button>
          </a> 
        </div>
      </div>
      @endforeach
    @endif
  </div>
</x-app-layout>