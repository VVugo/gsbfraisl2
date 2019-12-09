@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Bienvenue sur GSB {{ $info->prenom}} {{ $info->nom}}</h2>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Rôle : </label>
            <div class="col-md-6 col-md-3">
                <p>{{$info->tra_role}}</p> 
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Adresse : </label>
            <div class="col-md-6 col-md-3">
                <p>{{$info->adresse}} {{$info->cp}} {{$info->ville}} {{$info->reg_nom}}</p> 
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Secteur d'affectation : </label>
            <div class="col-md-6 col-md-3">
                <p>{{$info->sec_nom}}</p> 
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Date embauche : </label>
            <div class="col-md-6 col-md-3">
                <p>{{$info->sec_nom}}</p> 
            </div>
        </div>
    </div>
@stop

