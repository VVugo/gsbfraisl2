@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Modification de mes informations personnelles</h2>
    <div class="alert alert-success">
        Vos informations ont été mises à jour.        
    </div>
    <a href="{{ url('modifInfos')}}" ><button type="button" class="btn btn-default btn-primary" ><span class="glyphicon glyphicon-remove"></span> Retour</button></a>  
</div>
{!! Form::close() !!}
@stop