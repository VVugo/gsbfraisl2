<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class VoirVisiteurDelegueController extends Controller
{
     /**
     * Affiche tous les visiteurs et les délégués du même secteur que le responsable
     * Si une erreur a été stockée dans la Session
     * on la récupère, on l'efface de la Session
     * et la passe au formulaire
     * @return type Vue listeVisiteurDelegue
     */
    public function getVisiteurDelegue() {
        //$erreur = Session::get('erreur');
        //Session::forget('erreur');
        
        $unVisiteurDelegue = new GsbFrais();
        $id_visiteur = Session::get('id');
        // On récupère la liste de tous les visiteurs et délégués
        $mesVisiteursDelegues = $unVisiteurDelegue->getVisiteurDelegue($id_visiteur);
        // On affiche la liste 
        $titreVue = "Liste des visiteurs et délégués dans le secteur";     
        return view('listeVisiteurDelegue', compact('mesVisiteursDelegues', 'titreVue'));
    }
  /**
     * Affiche le visiteur ou délégué pour les modifications
     * @return type Vue detailFrais
     */ 
  public function detailInfoVisiteurDelegue($id){
      $gsbFrais = new GsbFrais();
      $info = $gsbFrais->getInfosPerso($id);
      $regions = $gsbFrais->getRegions($id);
      $titreVue = "Information de  ".$info->nom." ".$info->prenom;
      $retour = "/listVisiteurDelegue";
      return view('formModifVisiteurDelegue', compact('info','regions', 'id', 'titreVue', 'retour'));
  }
  public function modifVisiteurDelegue(Request $request){

    // récuperer les données du formulaire
    $region = $request->input('region');
    $role = $request->input('role');
    $id = $request->input('idVisiteurDelegue');
    $gsbFrais = new GsbFrais();
    //Mise à jour des informations dans la base de données
    $modif = $gsbFrais->modifierVisiteurDelegue($id,$region,$role);
    //$confirmed = 'id : '.$id.' region : '.$region. ' role : '.$role;
    $confirmed = "Les informations ont bien été modifié !";
    return back()->with('confirmed', $confirmed);
    
  }

}
