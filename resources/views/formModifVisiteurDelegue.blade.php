@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'detailInfoVisiteurDelegue/{id}']) !!}  
<div class="col-md-12 well well-md">
    <h2>{{$titreVue}}</h2>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Identifiant : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" readonly class="form-control-static"  name="idVisiteurDelegue" value="{{$info->id}}"  style="border: 0px;background: none">
            </div> 
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Région d'affectation : </label>
            <div class="col-md-6 col-md-3">
            <select class="form-control" name="region">
                <option value="{{$info->tra_reg}}" >{{$info->reg_nom}}</option> 
                @foreach($regions as $r)
                    @if($info->tra_reg != $r->id)
                        <option value="{{$r->id}}" >{{$r->reg_nom}}</option>
                    @endif
                @endforeach
                </select>
            </div> 
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Rôle : </label>
            <div class="col-md-6 col-md-3">
                <select class="form-control" name="role">
                    <option value="{{$info->tra_role}}" selected>{{$info->tra_role}}</option>
                    @if($info->tra_role == "Visiteur")
                    <option value="Délégué">Délégué</option>
                    @elseif($info->tra_role == "Délégué")
                    <option value="Visiteur">Visiteur</option>
                    @endif
                </select>
            </div>  
        </div>   
        
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <a href="{{ url($retour)}}" ><button type="button" class="btn btn-default btn-primary" >Retour</button></a>
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
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

