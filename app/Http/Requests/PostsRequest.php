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
            'author' => 'required|string|max:255',
            'value' => 'required|numeric|min:0|max:5',  // Exemple de valeur entre 0 et 5
        ];
    }

    public function messages() {

        return [
            'title.required' => 'le titre est obligatoire.'
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