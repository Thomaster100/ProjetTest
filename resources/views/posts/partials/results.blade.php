<div class="container-fluid mx-auto">

    @if($postList->isEmpty())
        <p class="text-center">Aucun résultat trouvé.</p>
    @else
        <div id="search-results">

            {{-- SPINNER --}}
            <div id="loading-spinner" class="text-center my-4" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>

            @foreach($postList as $post)
                <div class="row mb-3">
                    <div class="col-md-8 m-1 p-1 post-container card">
                        <div class="card-body">
                            <p class="h5 card-title">{{ $post->title }}</p>
                            <p class="card-text">{{ $post->content }}</p>
                            <p class="card-text">Auteur : {{ $post->author }}</p>
                            <p class="card-text">Valeur : {{ $post->value }}</p>

                            <div class="d-flex justify-content-end">
                                <!-- Bouton Modifier -->
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor'))
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary me-2">Modifier</a>
                                @else
                                    <a href="#" class="btn btn-secondary me-2 disabled" aria-disabled="true">Modifier</a>
                                @endif

                                <!-- Bouton Supprimer -->
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('moderator'))
                                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"
                                            type="submit"
                                            onclick="return confirm('Voulez-vous vraiment supprimer ce post ?');"
                                        >Supprimer</button>
                                    </form>
                                @else
                                    <button class="btn btn-danger disabled" aria-disabled="true">Supprimer</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    @endif
</div>
