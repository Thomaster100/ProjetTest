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
                            <p class="h5 card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->content }}</p>
                            <p class="card-text">Auteur : {{ $post->author }}</p>
                            <p class="card-text">Valeur : {{ $post->value }}</p>
        
                            <div class="d-flex justify-content-end">
                                <!-- Bouton Modifier -->
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary me-2"
                                    @if(auth()->user()->role->name !== 'admin' || !auth()->user()->hasPermission('modify-todos'))
                                        style="pointer-events: none; opacity: 0.5;"
                                    @endif
                                >Modifier</a>
        
                                <!-- Bouton Supprimer -->
                                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary"
                                        type="submit"
                                        @if(auth()->user()->role->name !== 'admin' || !auth()->user()->hasPermission('modify-todos'))
                                            disabled
                                        @endif
                                        onclick="return confirm('Voulez-vous vraiment supprimer ce post ?');"
                                    >Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
    @endif
</div>

