<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider - Gestion des Images</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Container du slider */
        #slider-container {
            max-width: 600px;
            height: 300px;
            margin: auto;
            overflow: hidden;
            position: relative;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Images en ligne (AFFICHAGE CORRIGÉ : 1 IMAGE À LA FOIS) */
        .slider {
            display: flex;
            width: 100%;
            transition: transform 0.5s ease-in-out;
        }

        .slider img {
            width: 100%; /* Ajuste à la largeur du conteneur */
            height: 100%; /* Ajuste à la hauteur du conteneur */
            object-fit: cover; /* Remplit le conteneur sans être déformé */
            flex: 0 0 100%; /* Une seule image visible à la fois */
        }

        /* Boutons de navigation */
        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 50%;
        }

        .prev { left: 10px; }
        .next { right: 10px; }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center">Gestion du Slider</h1>

        <!-- Slider avec boutons de navigation -->
        <div id="slider-container" class="my-4">
            <button class="slider-btn prev" onclick="prevSlide()">❮</button>
            <div class="slider" id="slider">
                @foreach ($images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Slide">
                @endforeach
            </div>
            <button class="slider-btn next" onclick="nextSlide()">❯</button>
        </div>

        <!-- Formulaire d'upload -->
        <div class="card p-4">
            <h3>Ajouter une image</h3>
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <input type="file" id="image" name="image" class="form-control mb-2" required>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

        <!-- Liste des images existantes -->
        <h3 class="mt-4">Images actuelles</h3>
        <div id="imageList" class="d-flex flex-wrap">
            @foreach ($images as $image)
                <div class="p-2 text-center">
                    <img src="{{ asset('storage/' . $image->path) }}" class="img-thumbnail" width="100">
                    <button class="btn btn-danger btn-sm mt-2" onclick="deleteImage({{ $image->id }})">Supprimer</button>
                </div>
            @endforeach
        </div>

    </div>

    <!-- JAVASCRIPT POUR LE SLIDER -->
    <script>
        let currentIndex = 0;

        function updateSlider() {
            const slider = document.getElementById("slider");
            const slides = document.querySelectorAll(".slider img");
            const totalSlides = slides.length;

            if (currentIndex >= totalSlides) currentIndex = 0;
            if (currentIndex < 0) currentIndex = totalSlides - 1;

            // Ajustement du translateX pour ne montrer qu'une seule image à la fois
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function nextSlide() {
            currentIndex++;
            updateSlider();
        }

        function prevSlide() {
            currentIndex--;
            updateSlider();
        }

        // Auto-défilement toutes les 5s
        setInterval(() => {
            nextSlide();
        }, 5000);

        // Gestion du formulaire d'upload
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("uploadForm");
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(form);

                fetch("{{ route('slider.upload') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert("Erreur lors de l'upload");
                    }
                });
            });
        });

        function deleteImage(id) {
            fetch("{{ url('/slider') }}/" + id, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Erreur lors de la suppression");
                }
            });
        }
    </script>

</body>
</html>
