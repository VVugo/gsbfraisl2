@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'valideFraisCloture']) !!} 
<div class="container">
    <div class="col-md-8 col-sm-8">
        <div class="blanc">
            <h2>{{$titreVue or ''}}</h2>
        </div>
        <div class="form-group">
        Fiche mois :  <input type="text" readonly class="form-control-static"  name="mois" value={{$mois}}  style="border: 0px;background: none">
           Id visiteur :  <input type="text" readonly class="form-control-static"  name="idVisiteur" value={{$idVisiteur}}  style="border: 0px;background: none">
        </div>
        <h3>Liste des frais forfait</h3>

        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>id</th> 
                    <th>Quantité</th>  
                </tr>
            </thead>
            @foreach($lesFraisForfait as $unFF)
            <tr>   
                <td> {{ $unFF->idfrais }} </td> 
                <td> {{ $unFF->quantite }} </td> 
            </tr>
            @endforeach
        </table>
        <h3>Liste des frais hors forfait</h3>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Libellé</th> 
                    <th>Date</th> 
                    <th>Montant</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            @foreach($lesFraisHorsForfait as $unFHF)
            <tr> 
                <td>{{ $unFHF->libelle }}</td>
                <td>{{ $unFHF->date }}</td>
                <td>{{ $unFHF->montant }}</td>
                <td><a class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" title="Supprimer" href="#"
                       onclick="javascript:if (confirm('Suppression confirmée ?'))
                           { window.location ='{{ url('/supprimerFraisHorsForfait') }}/{{ $unFHF->id }}'; }">
                    </a></td>
            </tr>
            @endforeach
            <tr>
                <td style="text-align: right"> Montant total :</td>
                <td><input type="text" readonly class="form-control-static"  name="montantTotal" value={{$montantTotal}}  style="border: 0px;background: none"></td>
            </tr>
        </table>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                <a href="{{ url($retour)}}" ><button type="button" class="btn btn-default btn-primary" >Retour</button></a>
                <button type="submit" name="submit" id="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
            </div>           
        </div>  
        @if (session('confirmed'))
        <div class="alert alert-success">
         {{ session('confirmed') }}
        </div>
        @endif
    </div>
</div>
{!! Form::close() !!} 
@stop

