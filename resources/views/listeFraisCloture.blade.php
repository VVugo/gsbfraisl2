@extends('layouts.master')
@section('content')
<div class="container">
    <div class="col-md-5">
        <div class="blanc">
            <h2>{{$titreVue or ''}}</h2>
        </div>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
            @if(!empty($lesFraisCloture))
                <tr>
                    <th style="width:20%">Nom et prénom</th> 
                    <th style="width:20%">Période</th> 
                    <th style="width:20%">Nb justificatifs</th> 
                    <th style="width:20%">Montant valide</th> 
                    <th style="width:20%">Etat</th>  
                    <th style="width:20%">Date de modification</th> 
                    <th style="width:20%">Détails</th>  
                </tr>
            @else
                <div class="alert alert-danger"><p> Aucune fiche de frais n'existe à l'état "cloturée"</p></div>
            @endif
            

            </thead>
            @foreach($lesFraisCloture as $unFrais)
            
            <tr>
                <td> {{ $unFrais->nom }} {{ $unFrais->prenom }} </td> 
                <td> {{ $unFrais->mois }} </td> 
                <td> {{ $unFrais->nbJustificatifs }} </td> 
                <td> {{ $unFrais->montantValide }} </td> 
                <td> {{ $unFrais->idEtat }} </td> 
                <td> {{ $unFrais->dateModif}} </td> 
                <td style="text-align:center;"><a href="{{ url('/voirDetailFraisCloture') }}/{{ $unFrais->mois }}">
                        <span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Voir"></span></a></td>
            </tr>
            @endforeach
        </table>
    @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
    @endif
    </div>
</div>
@stop
