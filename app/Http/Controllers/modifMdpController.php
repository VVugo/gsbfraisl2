<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class modifMdpController extends Controller
{
    /**
     * Initialise le formulaire de changement de mdp
     * 
     * @return type Vue formModifMdp
     */
    public function affFormModifMdp() {
        $erreur = "";
        return view('formModifMdp', compact('erreur'));
    }
    /**
     * Enregistre les modifications des informations personnelles
     */
    public function verifMdp(Request $request){
        $this->validate($request,[
            'login'=>'',
            'mdp'=>'required',
            
        ]);
        // récuperer les données pour vérifier si ils existent
        $login = $request->input('login');
        $mdp = $request->input('mdp');
        $newMdp = $request->input('newMdp');
        $confirmNewMdp = $request->input('confirmNewMdp');

        $idVisiteur = Session::get('id');
        $gsbFrais = new GsbFrais();

        //Récupère les logs de l'utilisateur
        $log = $gsbFrais->getInfosPerso($idVisiteur);

        //Si le login et le mdp du formulaire corresponde au log de l'utilisateur, alors change le mot de  passe
        if($log->login == $login && $log->mdp == sha1($mdp)){
            if($confirmNewMdp == $newMdp){
                //MàJ du mot de passe dans la base de données
                $info = $gsbFrais->modifMdp($idVisiteur, $confirmNewMdp);
                //confirme la mise à jour
                $confirmed = "Le mot de passe à bien été modifié !";
                return back()->with('confirmed', $confirmed);
            }
            else{
                //le mot de passe confirmé ne correspond pas au nouveau mot de passe
                $erreur = "le mot de passe confirmé ne correspond pas au nouveau mot de passe";
                return back()->with('erreur',$erreur);
            }
        }
        else{
            //erreur de la mise à jour
            $erreur = "Login ou mot de passe inconnu !";
            return back()->with('erreur', $erreur);
        }
    }
}




