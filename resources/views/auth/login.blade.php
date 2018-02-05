@extends('layouts.app')

@section('content')
<style>
.form-box{
    margin-right:auto;
    margin-left:auto;
    margin-top:40px;
    padding:40px 20px;
    max-width:500px;
}
</style>
<div class="box form-box">
    <form id="login-form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">Email:</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input id="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <p class="help is-danger">
                            {{ $errors->first('email') }}
                        </p>
                    @endif   
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">Password:</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input id="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" required>
                    </div>
                    @if ($errors->has('password'))
                        <p class="help is-danger">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
        <div class="field-label">
            <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
            <div class="field">
            <div class="control">
                <button class="button is-primary" type="button" onclick="handleLogin()">登陆</button>
            </div>
            </div>
        </div>
        </div>
    </form>
</div>
@endsection
