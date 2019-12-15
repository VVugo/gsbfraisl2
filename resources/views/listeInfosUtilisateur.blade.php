@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Bienvenue sur GSB {{ $info->prenom}} {{ $info->nom}}</h2>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-2 control">Rôle : </label> {{$info->tra_role}}
        </div>
        <div class="form-group">
        <label class="col-md-2 control">Adresse : </label>{{$info->adresse}} {{$info->cp}} {{$info->ville}} {{$info->reg_nom}}
        </div>
        <div class="form-group">
        <label class="col-md-2 control">Région d'affectation : </label>{{$info->reg_nom}}, secteur {{$info->sec_nom}}
        </div>
        <div class="form-group">
        <label class="col-md-2 control">Date d'embauche : </label>{{$info->dateEmbauche}}
        </div>
        <div class="form-group">
        <label class="col-md-2 control">Email : </label>{{$info->email}}<label class="col-md-2 control">Téléphone : </label> {{$info->tel}}
        </div>
        
    </div>
@stop