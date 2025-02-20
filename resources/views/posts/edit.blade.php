<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <title>Modifier un Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Modifier le Post</h2>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du Post</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $post->content) }}</textarea>
                    </div>

                    <!-- Zone de recadrage d'image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Image du post :</label>
                        <input type="file" name="image" id="imageInput" class="form-control">
                        @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="text-center">
                        <img id="cropperImage" class="img-fluid" style="max-width: 100%; display: none;">
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" id="saveCroppedImageBtn" class="btn btn-success">Recadrer & Enregistrer</button>
                    </div>

                    <!-- Champ caché pour l'image recadrée -->
                    <input type="hidden" name="cropped_image" id="croppedImageInput">

                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier :</label>
                        @if($post->file)
                            <div class="mb-2">
                                <a href="{{ asset('storage/posts/' . $post->user_folder . '/' . basename($post->file)) }}" class="btn btn-outline-primary" download>
                                    Télécharger le fichier actuel
                                </a>
                            </div>
                        @endif
                        <input type="file" name="file" class="form-control">
                        @error('file') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('postList') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer le post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let cropper;
            const imageInput = document.getElementById('imageInput');
            const cropperImage = document.getElementById('cropperImage');
            const saveCroppedImageBtn = document.getElementById('saveCroppedImageBtn');
            const croppedImageInput = document.getElementById('croppedImageInput');

            // Charger l'image existante dans Cropper.js
            @if($post->image)
                cropperImage.src = "{{ asset('storage/posts/' . $post->user_folder . '/' . basename($post->image)) }}";
                cropperImage.style.display = 'block';

                cropper = new Cropper(cropperImage, {
                    aspectRatio: 16 / 9,
                    viewMode: 2,
                    autoCropArea: 1,
                });
            @endif

            // Détecte le changement d'image
            imageInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        cropperImage.src = e.target.result;
                        cropperImage.style.display = 'block';

                        if (cropper) {
                            cropper.destroy();
                        }

                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 16 / 9,
                            viewMode: 2,
                            autoCropArea: 1,
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Enregistrer l'image recadrée et l'envoyer en AJAX
            saveCroppedImageBtn.addEventListener('click', function () {
                if (cropper) {
                    const croppedCanvas = cropper.getCroppedCanvas({
                        width: 800,
                        height: 450,
                    });

                    const croppedImageData = croppedCanvas.toDataURL('image/jpeg');

                    fetch("{{ route('edit.image', ['id' => $post->id]) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ cropped_image: croppedImageData }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("L’image a été mise à jour avec succès !");
                            location.reload();
                        } else {
                            alert("Erreur lors de l’enregistrement de l’image.");
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
