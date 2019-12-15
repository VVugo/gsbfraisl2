@extends('layouts.master')
@section('content')
<div class="container">
    <div class="col-md-5">
        <div class="blanc">
            <h2>{{$titreVue or ''}}</h2>
        </div>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th style="width:20%">Nom</th> 
                    <th style="width:20%">Prénom</th> 
                    <th style="width:20%">Rôle</th> 
                    <th style="width:20%">Région d'affectation</th>  
                    <th style="width:20%">Modifier</th>  
                </tr>
            </thead>
            @foreach($mesVisiteursDelegues as $unVisiteurDelegue)
            <tr>   
                <td> {{ $unVisiteurDelegue->nom }} </td> 
                <td> {{ $unVisiteurDelegue->prenom }} </td> 
                <td> {{ $unVisiteurDelegue->role }} </td>
                <td> {{ $unVisiteurDelegue->region }}</td>
            
                <td style="text-align:center;"><a href="{{ url('/detailInfoVisiteurDelegue') }}/{{ $unVisiteurDelegue->id }}">
                        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Modifier"></span></a></td>
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
