@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'creerVisiteur']) !!}  
<div class="col-md-12 well well-md">
    <h2>Création d'un visiteur</h2>
    <div class="form-horizontal"> 
    <div class="form-group">
            <label class="col-md-3 control-label">ID : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="id" ng-model="id" id="id" class="form-control" pattern="[a-zA-Z0-9]{3,40}" value="{{ isset($errors) && count($errors) > 0 }}" required> 
                 @if($errors->has('id'))
                 <div class="alert alert-danger">
                     {{ $errors->first('id') }}
                 </div>
                  @endif
                 </div> 
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Nom : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="nom" ng-model="nom" id="nom" class="form-control" pattern="[a-zA-ZÀ-ÿ]{3,40}" value="{{ isset($errors) && count($errors) > 0 }}" required> 
                 @if($errors->has('nom'))
                 <div class="alert alert-danger">
                     {{ $errors->first('nom') }}
                 </div>
                  @endif
                 </div> 
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Prénom :</label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="prenom" ng-model="prenom" id="prenom" class="form-control" pattern="[a-zA-ZÀ-ÿ]{3,40}" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('prenom'))
                <div class="alert alert-danger">
                    {{ $errors->first('prenom') }}
                </div>
                @endif
            </div>  
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Email :</label>
            <div class="col-md-6 col-md-3">
                <input type="email" name="email" id="email" ng-model="email" class="form-control" pattern ="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Tel :</label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="tel" id="tel" ng-model="tel" class="form-control" pattern="[0-9]{10}" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('tel'))
                <div class="alert alert-danger">
                    {{ $errors->first('tel') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code postal :</label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="cp" id="cp" ng-model="cp" class="form-control" pattern ="[0-9]{5}" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('cp'))
                <div class="alert alert-danger">
                    {{ $errors->first('cp') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Ville :</label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="ville" id="ville" ng-model="ville" class="form-control" pattern="[a-zA-ZÀ-ÿ -]{3,40}" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('ville'))
                <div class="alert alert-danger">
                    {{ $errors->first('ville') }}
                </div>
                @endif
            </div>  
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">Date d'embauche :</label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="dateEmbauche" id="dateEmbauche" ng-model="dateEmbauche" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('dateEmbauche'))
                <div class="alert alert-danger">
                    {{ $errors->first('dateEmbauche') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" name="submit" id="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
            </div>
        </div>
  @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
  @endif
  @if (session('confirmed'))
        <div class="alert alert-success">
         {{ session('confirmed') }}
        </div>
  @endif
    </div>
</div>
{!! Form::close() !!}
@stop

