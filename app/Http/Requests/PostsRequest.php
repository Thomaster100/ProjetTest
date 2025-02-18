<?php

/*
    La classe PostsRequest est une classe dédiée à la validation des données entrantes
    provenant du formulaire. Elle agit comme un filtre avant que les données ne soient
    traitées dans le contrôleur.

    Lorsqu'un utilisateur soumet un formulaire (via un POST par ex.),
    les données sont envoyées au serveur. Le rôle de PostsRequest est de vérifier 
    que ces données sont conformes aux règles définies avant qu'elles ne soient utilisées 
    pour créer ou mettre à jour un enregistrement dans la base de données.

    Concrètement, elle valide les données du formulaire ($_POST) ou $request avant 
    que le contrôleur ne traite les informations. Elle permet également de 
    retourner des messages d'erreur détaillés en cas de validation échouée.

    Et $POST dans tout ca ?

    - Le formulaire envoie les données via POST.
    - Laravel collecte ces données dans une INSTANCE de Request.
    - PostsRequest utilise ces données pour les valider.
    - Si les données sont validées avec succès, elles sont récupérées via
      $request->validated(), ce qui assure qu'on manipule uniquement des données
      valides et sécurisées.
*/


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Bonne pratique : valider les champs avec des règles personnalisées
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string',
            'value' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096', // max 4mb
            'file' => 'nullable|mimes:pdf,doc,docx,txt|max:5120', // max 5mb
        ];
    }

    public function messages() {

        return [
            
            // Validations pour le titre
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
    
            // Validations pour le contenu
            'content.required' => 'Le contenu est obligatoire.',
            'content.string' => 'Le contenu doit être une chaîne de caractères.',
    
            // Validations pour l’auteur
            'author.required' => 'Le champ auteur est obligatoire.',
            'author.string' => 'Le champ auteur doit être une chaîne de caractères.',
    
            // Validations pour la notation
            'value.required' => 'La valeur est obligatoire.',
            'value.numeric' => 'La valeur doit être un nombre.',
            'value.min' => 'La valeur minimale autorisée est 0.',
            'value.max' => 'La valeur maximale autorisée est 5.',
    
            // Validations pour l’image
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L’image doit être au format jpeg, png, jpg ou gif.',
            'image.max' => 'L’image ne doit pas dépasser 2 Mo.',
    
            // Validations pour le fichier joint
            'file.mimes' => 'Le fichier doit être au format pdf, doc, docx ou txt.',
            'file.max' => 'Le fichier ne doit pas dépasser 5 Mo.',
        ];
        
    }

    // Méthode qui permet de modifier les données avant validation
    protected function prepareForValidation()
    {
        $this->merge([
            'value' => (float) $this->value, // Exemple : Convertir la valeur en float avant validation (voir le fichier modèle Posts)
        ]);

        // On pourrait aussi l'utiliser pour ajouter des vérification supplémentaires...

        // On pourrait tres bien aussi utiliser un middleware (sera vu plus tard dans le cours)
    }
}