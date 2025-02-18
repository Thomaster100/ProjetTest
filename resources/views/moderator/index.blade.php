@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modération des Posts et Commentaires</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h3>Posts en attente d’approbation</h3>
    <ul>
        @foreach($posts as $post)
            @if(!$post->approved)
                <li>
                    {{ $post->title }} - <form method="POST" action="{{ route('moderator.approve_post', $post->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Approuver</button>
                    </form>
                </li>
            @endif
        @endforeach
    </ul>

    <h3>Commentaires</h3>
    <ul>
        @foreach($comments as $comment)
            <li>
                {{ $comment->content }}
                <form method="POST" action="{{ route('moderator.delete_comment', $comment->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
