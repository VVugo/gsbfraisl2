<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class listeInfosController extends Controller
{
    /**
     * Initialise le formulaire avec les infos personnelles
     * 
     * @return type Vue formModifInfos
     */
    public function affListeInfos() {
        $erreur = "";
        $id= Session::get('id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->getInfosPerso($id);
        // Affiche la page en lui fournissant les données à afficher
        // la fonction compact équivaut à array('lesFrais' => $lesFrais, ...) 
        return view('listeInfosUtilisateur', compact('info', 'erreur'));
    }
    
}