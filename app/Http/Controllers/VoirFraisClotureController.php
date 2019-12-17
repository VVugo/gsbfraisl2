<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class VoirFraisClotureController extends Controller
{
     /**
     * Affiche la liste de toutes les fiches
     * de frais qui  sont  cloturées
     * @return type Vue listeFraisCloturé
     */
    public function getFraisCloture() {

        $unFrais = new GsbFrais();
        $id_visiteur = Session::get('id');
        // On récupère la liste de tous les frais cloturé
        $info = $unFrais->getInfosPerso($id_visiteur);

        if($info->tra_role == "Délégué"){
          $role = "Visiteur";
          $region = $info->tra_reg;
          $sql = " AND travailler.tra_reg = '".$region."'";
          // return $region.$sql;
          $lesFraisCloture = $unFrais->getFraisCloture($role, $sql);
        }
        elseif($info->tra_role == "Responsable"){
          $role = "Délégué";
          $secteur = $info->sec_code;
          $sql = " AND sec_code = '".$secteur."'";
          // return $secteur.$sql;
          $lesFraisCloture = $unFrais->getFraisCloture($role, $sql);
        }

        // On affiche la liste de ces frais  
        $titreVue = "Liste des frais cloturés";     
        return view('listeFraisCloture', compact('lesFraisCloture', 'titreVue'));
    }
  /**
     * Affiche le détail (frais forfait et hors forfait)
     * @return type Vue detailFrais
     */ 
  public function voirDetailFrais($mois){
      $gsbFrais = new GsbFrais();
      $idVisiteur = Session::get('id');
      $lesFraisForfait = $gsbFrais->getLesFraisForfait($idVisiteur, $mois);
      $lesFraisHorsForfait = $gsbFrais->getLesFraisHorsForfait($idVisiteur, $mois);
      $montantTotal = 0;
      foreach ($lesFraisHorsForfait as $fhf){
            $montantTotal = $montantTotal + $fhf->montant;
      }
      $titreVue = "Détail de la fiche de frais du mois ".$mois;
      $retour = "/getListeFraisCloture";
      return view('listeDetailFicheCloture', compact('lesFraisForfait', 'lesFraisHorsForfait','idVisiteur', 'mois', 'titreVue','montantTotal', 'retour'));
  }
  public function valideFraisCloture(Request $request){
    $idVisiteur = $request->input('idVisiteur');
    $mois = $request->input('mois');
    $montantValide = $request->input('montantTotal');
    $gsbFrais = new GsbFrais();
    //MàJ de la fiche frais
    $update = $gsbFrais->valideFraisCloture($idVisiteur,$mois,$montantValide);
    //Affiche la confirmation
    $confirmed = "La fiche frais à bien été validé !";
    return back()->with('confirmed', $confirmed);
  }

}