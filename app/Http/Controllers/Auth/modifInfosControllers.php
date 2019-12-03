<?php

namespace App\Http\Controllers;

use illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;
class ModifInfosController extends Controller
{
    /**
     * initialise le form avec les infos personnelles
    *@return vue formModifInfos;
    */
    public function affFormModifInfos()
    {
        $erreur ="";
        $idVisiteur =Session :: get('id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais -> getInfosPerso($idVisiteur);
        return view('formModifInfos', compact('info', 'erreur'));
    }
}