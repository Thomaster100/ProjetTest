
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Ajout de Cropper.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <title>Créer un Post</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Créer un Post</h2>

        <div class="card">
            <div class="card-body">
                <form id="postForm">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre :</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Titre" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu :</label>
                        <textarea name="content" id="content" class="form-control" rows="5" placeholder="Contenu" required></textarea>
                        <div id="contentWarning" class="text-danger mt-2" style="display: none;">⚠️ Le contenu peut contenir des mots inappropriés.</div>
                    </div>

                    <!-- Gestion du recadrage d'image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Image :</label>
                        <input type="file" name="image" id="imageInput" class="form-control">
                    </div>

                    <div class="text-center">
                        <img id="cropperImage" class="img-fluid" style="max-width: 100%; display: none;">
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" id="saveCroppedImageBtn" class="btn btn-warning">Recadrer & Enregistrer</button>
                    </div>

                    <input type="hidden" name="cropped_image" id="croppedImageInput">

                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier :</label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('postList') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" id="submitPostBtn" class="btn btn-primary">Créer le post</button>
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
            const contentInput = document.getElementById('content');
            const contentWarning = document.getElementById('contentWarning');
            const postForm = document.getElementById('postForm');
    
            if (!postForm) {
                console.error(" Formulaire introuvable !");
                return;
            }
    
            // Vérification du contenu texte SightEngine
            contentInput.addEventListener('input', function () {
                fetch('https://api.sightengine.com/1.0/text/check.json', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        'text': contentInput.value,
                        'lang': 'fr',
                        'mode': 'standard',
                        'api_user': '{{ env("SIGHTENGINE_USER") }}',
                        'api_secret': '{{ env("SIGHTENGINE_SECRET") }}'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.profanity && data.profanity.matches.length > 0) {
                        contentWarning.style.display = 'block';
                    } else {
                        contentWarning.style.display = 'none';
                    }
                })
                .catch(error => console.error(" Erreur API SightEngine:", error));
            });
    
            // Affichage de l'image pour recadrage
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
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
    
            // Recadrage image
            saveCroppedImageBtn.addEventListener('click', function () {
                if (cropper) {
                    const croppedCanvas = cropper.getCroppedCanvas({
                        width: 800,
                        height: 450,
                    });
    
                    croppedImageInput.value = croppedCanvas.toDataURL('image/jpeg');
    
                    alert('L’image a été recadrée.');
                }
            });
    
            // Envoi du formulaire en Fetch 
            postForm.addEventListener('submit', function (e) {

                e.preventDefault();
    
                const formData = new FormData(postForm);
                formData.append('_token', '{{ csrf_token() }}');
    
                console.log("Données envoyées :", [...formData.entries()]);
    
                fetch("{{ route('storePost') }}", {
                    method: "POST",
                    body: formData
                })
                .then(async response => {

                    console.log("HTTP Status:", response.status);
    
                    const contentType = response.headers.get("content-type");
                    console.log("Content-Type:", contentType);
    
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }
    
                    if (contentType && contentType.includes("application/json")) {
                        return response.json();
                    } else {
                        const textResponse = await response.text();
                        console.log("Réponse serveur (HTML probable):", textResponse);
                        throw new Error("Le serveur n'a pas retourné du JSON.");
                    }
                })
                .then(data => {

                    console.log("Réponse JSON:", data);

                    if (data.success) {

                        alert('Post créé avec succès !');
                        window.location.href = "{{ route('postList') }}";

                    } else {

                        alert(' Erreur lors de la création du post.');
                    }
                })
                .catch(error => {
                    console.error('Erreur Fetch:', error);
                    alert("Une erreur s'est produite. Vérifie la console pour plus de détails.");
                });
            });
        });
    </script>
    
    
</body>
</html>
