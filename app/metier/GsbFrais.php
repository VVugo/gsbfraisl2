<?php
namespace App\metier;

use Illuminate\Support\Facades\DB;

/** 
 * Classe d'accès aux données. 
 */
class GsbFrais{   		
/**
 * Retourne les informations d'un visiteur 
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un objet 
*/
public function getInfosVisiteur($login, $mdp){
        $req = "select DISTINCT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom,travailler.tra_role as role, travailler.tra_date from visiteur inner join travailler on travailler.idVisiteur = visiteur.id INNER join region on region.id = travailler.tra_reg inner join secteur on secteur.id = region.sec_code where visiteur.login=:login and visiteur.mdp=:mdp ORDER by travailler.tra_date DESC LIMIT 1";
        $ligne = DB::select($req, ['login'=>$login, 'mdp'=>sha1($mdp)]);
        return $ligne;
}
/**
 * Retourne sous forme d'un tableau d'objets toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet avec tous les champs des lignes de frais hors forfait 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur =:idVisiteur 
		and lignefraishorsforfait.mois = :mois ";	
            $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
//            for ($i=0; $i<$nbLignes; $i++){
//                    $date = $lesLignes[$i]['date'];
//                    $lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
//            }
            return $lesLignes; 
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet contenant les frais forfait du mois
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, ligneFraisForfait.mois as mois,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois=:mois
		order by lignefraisforfait.idfraisforfait";	
//                echo $req;
                $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 * @return un objet avec les données de la table frais forfait
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$lesLignes = DB::select($req);
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
    //            print_r($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = :qte
			where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
			and lignefraisforfait.idfraisforfait = :unIdFrais";
                        DB::update($req, ['qte'=>$qte, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'unIdFrais'=>$unIdFrais]);
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = :nbJustificatifs 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		DB::update($req, ['nbJustificatifs'=>$nbJustificatifs, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois]);	
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = :mois and fichefrais.idvisiteur = :idVisiteur";
		$laLigne = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
                $nb = $laLigne[0]->nblignesfrais;
		if($nb == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = :idVisiteur";
		$laLigne = DB::select($req, ['idVisiteur'=>$idVisiteur]);
                $dernierMois = $laLigne[0]->dernierMois;
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche->idEtat=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values(:idVisiteur,:mois,0,0,now(),'CR')";
		DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais->idfrais;
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values(:idVisiteur,:mois,:unIdFrais,0)";
			DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'unIdFrais'=>$unIdFrais]);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
//		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait(idVisiteur, mois, libelle, date, montant) 
		values(:idVisiteur,:mois,:libelle,:date,:montant)";
		DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'libelle'=>$libelle,'date'=>$date,'montant'=>$montant]);
	}

/**
 * Récupère le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
 * @return un objet avec les données du frais hors forfait
*/
	public function getUnFraisHorsForfait($idFrais){
		$req = "select * from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		$fraisHF = DB::select($req, ['idFrais'=>$idFrais]);
//                print_r($unfraisHF);
                $unFraisHF = $fraisHF[0];
                return $unFraisHF;
	}
/**
 * Modifie frais hors forfait à partir de son id
 * à partir des informations fournies en paramètre
 * @param $id 
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function modifierFraisHorsForfait($id, $libelle,$date,$montant){
//		$dateFr = dateFrancaisVersAnglais($date);
		$req = "update lignefraishorsforfait set libelle = :libelle, date = :date, montant = :montant
		where id = :id";
		DB::update($req, ['libelle'=>$libelle,'date'=>$date,'montant'=>$montant, 'id'=>$id]);
	}
        
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		DB::delete($req, ['idFrais'=>$idFrais]);
	}
/**
 * Retourne les fiches de frais d'un visiteur à partir d'un certain mois
 * @param $idVisiteur 
 * @param $mois mois début
 * @return un objet avec les fiches de frais de la dernière année
*/
	public function getLesFrais($idVisiteur, $mois){
		$req = "select * from  fichefrais where idvisiteur = :idVisiteur
                and  mois >= :mois   
		order by fichefrais.mois desc ";
                $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
                return $lesLignes;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur,'mois'=>$mois]);			
		return $lesLignes[0];
	}
/** 
 * Modifie l'état et la date de modification d'une fiche de frais
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = :etat, dateModif = now() 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		DB::update($req, ['etat'=>$etat, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
	}

	/**
 * Retourne les informations personnelles d'un visiteur ou d'un délégué, en fonction de son id
 
 * @param $id 
 * @return la ville et le cp sous la forme d'un objet 
 */
	public function getInfosPerso($id){
		$req = "select v.id, v.nom, v.prenom, v.login, v.mdp, v.adresse, v.cp, v.ville, v.dateEmbauche,v.email,v.tel, t.tra_date,t.tra_role, t.tra_reg, r.sec_code, r.reg_nom, s.sec_nom from visiteur as v inner join travailler as t on t.idVisiteur = v.id INNER join region as r on r.id = t.tra_reg inner join secteur as s on s.id = r.sec_code where v.id =:id ORDER by t.tra_date desc limit 1";
		$ligne = DB::select($req, ['id'=>$id]);
		return $ligne[0];
	}
	/**
	 * Récupère les visiteurs et les délégués du même secteur que le responsable connecté
	 */
	public function getVisiteurDelegue($id){
		$req = "select t1.idVisiteur as id, t1.tra_date, nom,prenom,t1.tra_role as role, r.reg_nom as region, tra_reg FROM travailler t1 inner join visiteur v on t1.idVisiteur = v.id inner join region r on r.id = t1.tra_reg WHERE t1.tra_date IN (SELECT max(t2.tra_date) FROM travailler t2 WHERE t2.idVisiteur = t1.idVisiteur)AND t1.tra_role != 'Responsable' AND r.sec_code = (SELECT sec_code from region inner join travailler on travailler.tra_reg = region.id WHERE travailler.idVisiteur =:id order by travailler.tra_date desc limit 1) ORDER BY t1.idVisiteur, t1.tra_date, nom,prenom,role, region";
		$lignes = DB::select($req, ['id'=>$id]);
		return $lignes;
	}

	/**
	 * Récupère les regions qui sont du même secteur que le visiteur / délégué à l'aide de son id
	 * Région du même secteur que le visiteur / délégué
	 */
	public function getRegions($id){
		$req = "select * from region where sec_code = (SELECT DISTINCT sec_code from travailler inner join region on region.id = travailler.tra_reg WHERE travailler.idVisiteur = :id order by tra_date DESC LIMIT 1)";
		$lignes = DB::select($req, ['id'=>$id]);
		return $lignes;
	}

	/**
	 * Met a jour la base de données du visiteur ou délégué avec les infos passés en paramètre en fonction de son id
	 */
	public function modifierVisiteurDelegue($id,$region,$role){
		$req = "update travailler set tra_reg = :region, tra_role = :role, tra_date = Date(now()) where idvisiteur = :id";

		//$req = "insert into travailler(idVisiteur, tra_date,tra_reg,tra_role) VALUES (:id,Date(now()),:region,:role) ON DUPLICATE KEY UPDATE tra_reg =:region , tra_role=:role";

		DB::update($req,['id'=>$id, 'region'=>$region,'role'=>$role]);
	}


	/**
	 * Mise à jour des informations dans la base de données à partir de l'id
	*/
	public function modifInfos($idVisiteur,$adresse, $cp, $ville){
		$req = "update visiteur set adresse = :adresse, cp = :cp, ville = :ville where visiteur.id = :id";
		DB::update($req, ['id'=>$idVisiteur, 'adresse'=>$adresse, 'cp'=>$cp, 'ville'=>$ville]);
	}

	/**
	*	Mise à jour du mot de passe dans la base de données à partir de l'id
	*/
	public function modifMdp($idVisiteur,$newMdp){
		$req = "update visiteur set mdp = :mdp where visiteur.id = :id";
		DB::update($req, ['id'=>$idVisiteur, 'mdp'=>sha1($newMdp)]);
	}

	public function creerVisiteur($nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $dateEmbauche, $tel, $email)
	{
		$req = "INSERT INTO visiteur VALUES ('0', :nom, :prenom, :login, :mdp, :adresse, :cp, :ville, :dateEmbauche, :tel, :email)";
		DB::select($req, ['nom'=>$nom, 'prenom'=>$prenom, 'login'=>$login, 'mdp'=>$mdp, 'adresse'=>$adresse, 'cp'=>$cp, 'ville'=>$ville, 'dateEmbauche'=>$dateEmbauche, 'tel'=>$tel, 'email'=>$email,]);
	}
	/**
	 * Récupere la liste des frais forfaits cloturés des visiteurs de la région du délégué
	 */
	public function getFraisCloture($role, $sql){
		$req = "Select * from fichefrais INNER JOIN travailler on travailler.idVisiteur = fichefrais.idVisiteur INNER JOIN region on travailler.tra_reg = region.id inner join visiteur on visiteur.id = travailler.idVisiteur where idEtat = 'CL' AND travailler.tra_role = :role ".$sql." ORDER BY travailler.idVisiteur, mois ASC";
		$lignes = DB::select($req,['role'=>$role]);
		return $lignes;
	}

	/**
	 * Valide une fiche frais forfait cloture
	 */
	public function valideFraisCloture($idVisiteur,$mois,$montanValide){
		$req = "update fichefrais set idEtat = 'VA', dateModif= Date(now()), montantValide= :montantValide where idVisiteur = :idVisiteur AND mois = :mois";
		DB::update($req,['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'montantValide'=>$montanValide]);
	}

	/**
	 * Récupere la liste des frais forfaits des visiteurs de la région du délégué
	 */
	public function getFraisValide($role, $sql){
		
		$req = "Select DISTINCT * from fichefrais INNER JOIN travailler on travailler.idVisiteur = fichefrais.idVisiteur INNER JOIN region on travailler.tra_reg = region.id inner join visiteur on visiteur.id = travailler.idVisiteur where idEtat = 'VA' OR idEtat = 'RB' AND travailler.tra_role = :role ".$sql." and travailler.tra_date IN (SELECT max(t2.tra_date) FROM travailler t2 WHERE t2.idVisiteur = travailler.idVisiteur) order by fichefrais.idVisiteur asc, mois asc";

		$lignes = DB::select($req,['role'=>$role]);
		return $lignes;
	}

}



?>