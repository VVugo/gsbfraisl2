<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class modifInfosController extends Controller
{
    /**
     * Initialise le formulaire avec les infos personnelles
     * 
     * @return type Vue formModifInfos
     */
    public function affFormModifInfos() {
        $erreur = "";
        $idVisiteur = Session::get('id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->getInfosPerso($idVisiteur);
        // Affiche le formulaire en lui fournissant les données à afficher
        // la fonction compact équivaut à array('lesFrais' => $lesFrais, ...) 
        return view('formModifInfos', compact('info', 'erreur'));
    }
    /**
     * Enregistre les modifications des informations personnelles
     */
    public function verifInfos(Request $request){
        $this->validate($request,[
            'adresse'=>'bail|required',
            'cp'=>'bail|required|digits:5',
            'ville'=>'bail|required|between:2,30|alpha'
        ]);
        // récuperer les données pour mettre à jour la base
        $adresse = $request->input('adresse');
        $cp = $request->input('cp');
        $ville = $request->input('ville');
        $idVisiteur = Session::get('id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->modifInfos($idVisiteur, $adresse, $cp, $ville);
        //confirmmer la mise à jour
        return view ('confirmModifInfos');

    }
}