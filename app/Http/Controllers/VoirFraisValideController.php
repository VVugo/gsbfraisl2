<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class VoirFraisValideController extends Controller
{
    /**
     * Affiche la liste de toutes les fiches
     * de frais qui  sont  validés
     * @return type Vue listeFraisCloturé
     */
    public function getFraisValider() {

      $unFrais = new GsbFrais();
      $id_visiteur = Session::get('id');
      // On récupère la liste de tous les frais validé
      $info = $unFrais->getInfosPerso($id_visiteur);

      if($info->tra_role == "Délégué"){
        $role = "Visiteur";
        $region = $info->tra_reg;
        $sql = " AND travailler.tra_reg = '".$region."'";
        // return $region.$sql;
        $mesFrais = $unFrais->getFraisValide($role, $sql);
      }
      elseif($info->tra_role == "Responsable"){
        $role = "Délégué";
        $secteur = $info->sec_code;
        $sql = " AND sec_code = '".$secteur."'";
        // return $secteur.$sql;
        $mesFrais = $unFrais->getFraisValide($role, $sql);
      }

      // On affiche la liste de ces frais  
      $titreVue = "Liste des frais validés ou remboursés";     
      return view('listeFraisValide', compact('mesFrais', 'titreVue'));
  }
/**
   * Affiche le détail (frais forfait et hors forfait)
   * @return type Vue detailFrais
   */ 
public function voirDetailFrais($id,$mois){
    $gsbFrais = new GsbFrais();
    $info = $gsbFrais->getInfosPerso($id);
    $nom = $info->nom;
    $prenom = $info->prenom;
    $lesFraisForfait = $gsbFrais->getLesFraisForfait($id, $mois);
    $lesFraisHorsForfait = $gsbFrais->getLesFraisHorsForfait($id, $mois);
    $montantTotal = 0;
    foreach ($lesFraisHorsForfait as $fhf){
          $montantTotal = $montantTotal + $fhf->montant;
    }
    $titreVue = "Détail de la fiche de frais du mois ".$mois." de ".$nom." ".$prenom;
    $retour = "/getListeFraisValide";
    return view('listeDetailFiche', compact('lesFraisForfait', 'lesFraisHorsForfait','idVisiteur', 'mois', 'titreVue','montantTotal', 'retour'));
  }
}