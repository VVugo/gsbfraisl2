@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'creerVisiteur']) !!}  
<div class="col-md-12 well well-md">
    <h2>Création d'un visiteur</h2>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Nom : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="nom" ng-model="nom" id="nom" class="form-control" size ="5"  value="{{ isset($errors) && count($errors) > 0 }}" required> 
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
                <input type="text" name="prenom" ng-model="prenom" id="prenom" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
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
                <input type="email" name="email" id="email" ng-model="email" class="form-control" maxlength="30" maxlength="40" pattern ="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$" value="{{isset($errors) && count($errors) > 0}}" required>
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
                <input type="text" name="tel" id="tel" ng-model="tel" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
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
                <input type="text" name="cp" id="cp" ng-model="cp" class="form-control" maxlength="30" maxlength="40" pattern ="[0-9]{5}" value="{{isset($errors) && count($errors) > 0}}" required>
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
                <input type="text" name="ville" id="ville" ng-model="ville" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
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
            <label class="col-md-3 control-label">Login :</label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="login" id="login" ng-model="login" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('login'))
                <div class="alert alert-danger">
                    {{ $errors->first('login') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Mot de passe :</label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="mdp" id="mdp" ng-model="mdp" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('mdp'))
                <div class="alert alert-danger">
                    {{ $errors->first('mdp') }}
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

