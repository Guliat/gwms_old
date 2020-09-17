@extends('layouts.app')
@section('content')
<div class="container" id="signin">
    <div class="row">
        <div class="col-lg-12 col-xs-12" style="padding-top: 10%;">
            <div class="panel panel-default shadow-all">
                <div class="panel-heading text-center calibri20">Guliat's Work Management System</div>
                <div class="panel-body text-center">
                    <span class="loginlogo">GWMS</span>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                <div class="col-lg-6 col-sm-6 col-sm-offset-3 col-lg-offset-3">
                                    <input type="text" class="form-control signin" name="login" placeholder="ПОТРЕБИТЕЛСКО ИМЕ" value="{{ old('login') }}">
                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('login') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-lg-6 col-sm-6 col-sm-offset-3 col-lg-offset-3">
                                    <input type="password" class="form-control signin" name="password" placeholder="ПАРОЛА">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- login button -->
                            <div class="form-group">
                                <div class="col-lg-6 col-sm-6 col-sm-offset-3 col-lg-offset-3">
                                    <button type="submit" class="btn btn-gwms btn-lg ladda-button" data-style="expand-left">
                                        {!! Lang::get('general.button_signin') !!}
                                    </button>
                                    <br />
                                </div>
                            </div>
                            <!-- remember me -->
                            <div class="form-group">
                                <div class="col-lg-6 col-sm-6 col-sm-offset-3 col-lg-offset-3">
                                    <div class="checkbox">
                                        <label for="remember">
                                            <input type="checkbox" name="remember" id="remember" />
                                            <i></i><span> ЗАПОМНИ МЕ </span>
                                        </label>
                                    </div>
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Забравена парола?</a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
