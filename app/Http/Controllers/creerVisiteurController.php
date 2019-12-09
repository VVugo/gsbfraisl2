<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class creerVisiteurController extends Controller
{
    /**
     * Initialise le formulaire avec les infos personnelles
     * 
     * @return type Vue formModifInfos
     */
    public function affFormCreerVisiteur() {
        $erreur = "";
        $gsbFrais = new GsbFrais();
        // Affiche le formulaire en lui fournissant les données à afficher
        // la fonction compact équivaut à array('lesFrais' => $lesFrais, ...) 
        return view('creerVisiteur', compact('info', 'erreur'));
    }
    /**
     * Enregistre les modifications des informations personnelles
     */
    public function verifVisiteur(Request $request){
        $this->validate($request,[
            'adresse'=>'bail|required',
            'cp'=>'bail|required|digits:5',
            'ville'=>'bail|required|between:2,30|alpha',
            'email'=>'bail|required',
            'prenom'=>'bail|required',
            'nom'=>'bail|required',
            'tel'=>'bail|required|digits:10',
            'login'=>'bail|required',
            'mdp'=>'bail|required',
            'dateEmbauche'=>'bail|required',

        ]);
        // récuperer les données pour mettre à jour la base
        $email = $request->input('email');
        $tel = $request->input('tel');
        $dateEmbauche = $request->input('dateEmbauche');
        $login = $request->input('login');
        $mdp = $request->input('mdp');
        $prenom = $request->input('prenom');
        $nom = $request->input('nom');
        $adresse = $request->input('adresse');
        $cp = $request->input('cp');
        $ville = $request->input('ville');
        $idVisiteur = Session::get('id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->creerVisiteur($nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche, $tel, $email);
        //confirmer la mise à jour
        return view ('creerVisiteur');

    }
}