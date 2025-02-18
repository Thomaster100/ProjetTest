@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un Nouveau Post</h2>

    <form method="POST" action="{{ route('editor.store_post') }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
    </form>
</div>
@endsection
