@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'modifMdp']) !!}  
<div class="col-md-12 well well-md">
    <h2>Modification du mot de passe</h2>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Login : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="login" ng-model="login" id="login" class="form-control" size ="5"  value="{{ isset($errors) && count($errors) > 0 }}" required> 
                 @if($errors->has('login'))
                 <div class="alert alert-danger">
                     {{ $errors->first('login') }}
                 </div>
                  @endif
                 </div> 
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Mot de passe actuel :</label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="mdp" ng-model="mdp" id="mdp" class="form-control" maxlength="30" maxlength="40" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('mdp'))
                <div class="alert alert-danger">
                    {{ $errors->first('mdp') }}
                </div>
                @endif
            </div>  
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Nouveau mot de passe :</label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="newMdp" id="newMdp" ng-model="newMdp" class="form-control" maxlength="30" maxlength="40" pattern ="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('newMdp'))
                <div class="alert alert-danger">
                    {{ $errors->first('newMdp') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Confirmer le nouveau mot de passe :</label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="confirmNewMdp" id="confirmNewMdp" ng-model="confirmNewMdp" class="form-control" maxlength="30" maxlength="40" pattern ="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" value="{{isset($errors) && count($errors) > 0}}" required>
                @if($errors->has('confirmNewMdp'))
                <div class="alert alert-danger">
                    {{ $errors->first('confirmNewMdp') }}
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

