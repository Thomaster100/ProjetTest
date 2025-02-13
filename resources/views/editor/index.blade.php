@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des Posts</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('editor.create_post') }}" class="btn btn-primary">Créer un Post</a>

    <h3>Vos Posts</h3>
    <ul>
        @foreach($posts as $post)
            <li>
                {{ $post->title }}
                <a href="{{ route('editor.edit_post', $post->id) }}" class="btn btn-warning">Modifier</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
