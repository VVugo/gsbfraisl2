@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Modification du mot de passe</h2>
    <div class="alert alert-success">
        Mot de passe mis à jour.        
    </div>
    <a href="{{ url('modifMdp')}}" ><button type="button" class="btn btn-default btn-primary" ><span class="glyphicon glyphicon-remove"></span> Retour</button></a>  
</div>
{!! Form::close() !!}
@stop