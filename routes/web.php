<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// Afficher le formulaire d'authentification 
//Route::get('/getLogin', 'ConnexionController@getLogin');
Route::get('/getLogin', function () {
   return view ('formLogin');
});
// Authentifie le visiteur à partir du login et mdp saisis
Route::post('/login', 'ConnexionController@logIn');

// Déloguer le visiteur
Route::get('/Logout', 'ConnexionController@logOut');

//saisirFrais
Route::get('/saisirFraisForfait', 'FraisForfaitController@saisirFraisForfait');

//saisirFrais
Route::post('/saisirFraisForfait', 'FraisForfaitController@validerFraisForfait');

// Afficher la liste des fiches de Frais du visiteur connecté
Route::get('/getListeFrais', 'VoirFraisController@getFraisVisiteur');

// Afficher le détail de la fiche de frais pour le mois sélectionné
Route::get('/voirDetailFrais/{mois}', 'VoirFraisController@voirDetailFrais');

// Afficher la liste des frais hors forfait d'une fiche de Frais
Route::get('/getListeFraisHorsForfait/{mois}', 'FraisHorsForfaitController@getFraisHorsForfait');

// Afficher le formulaire d'un Frais Hors Forfait pour une modification
Route::get('/modifierFraisHorsForfait/{idFrais}', 'FraisHorsForfaitController@modifierFraisHorsForfait');

// Afficher le formulaire d'un Frais Hors Forfait pour un ajout
Route::get('/ajouterFraisHorsForfait/{mois}', 'FraisHorsForfaitController@saisirFraisHorsForfait');

// Enregistrer une modification ou un ajout d'un Frais Hors Forfait
Route::post('/validerFraisHorsForfait', 'FraisHorsForfaitController@validerFraisHorsForfait');

// Supprimer un Frais Hors Forfait
Route::get('/supprimerFraisHorsForfait/{idFrais}', 'FraisHorsForfaitController@supprimmerFraisHorsForfait');

// Retourner à une vue dont on passe le nom en paramètre
Route::get('getRetour/{retour}', function($retour){
    return redirect("/".$retour);
});

//modifierInfos
Route::get('/modifInfos', 'modifInfosController@affFormModifInfos');

//modifierInfos
Route::post('/modifInfos', 'modifInfosController@verifInfos');

//modifierMdp
Route::get('/modifMdp', 'modifMdpController@affFormModifMdp');

//modifierMdp
Route::post('/modifMdp', 'modifMdpController@verifMdp');

//creerVisiteur
Route::get('/creerVisiteur', 'creerVisiteurController@affFormCreerVisiteur');

//creerVisiteur
Route::post('/creerVisiteur', 'creerVisiteurController@verifVisiteur');

//gerer les visiteurs ou les delegues
Route::get('/listVisiteurDelegue', 'VoirVisiteurDelegueController@getVisiteurDelegue');

Route::get('/detailInfoVisiteurDelegue/{id}', 'VoirVisiteurDelegueController@detailInfoVisiteurDelegue');

Route::post('/detailInfoVisiteurDelegue/{id}', 'VoirVisiteurDelegueController@modifVisiteurDelegue');

//info Utilisateur
Route::get('/infosUtilisateur', 'listeInfosController@affListeInfos');
//page de présentation 
Route::get('/home', 'listeInfosController@affListeInfos');

// Afficher la liste des fiches de Frais cloturé
Route::get('/getListeFraisCloture', 'VoirFraisClotureController@getFraisCloture');

// Afficher le détail de la fiche de frais pour le mois sélectionné
Route::get('/voirDetailFraisCloture/{mois}', 'VoirFraisClotureController@voirDetailFrais');

//Valide la fiche de frais
Route::post('/valideFraisCloture', 'VoirFraisClotureController@valideFraisCloture');

// Afficher la liste des fiches de Frais validé
Route::get('/getListeFraisValide', 'VoirFraisValideController@getFraisValider');
// Afficher le détail de la fiche de frais pour l'id et le mois sélectionné
Route::get('/voirDetailFrais/{id}/{mois}', 'VoirFraisValideController@voirDetailFrais');