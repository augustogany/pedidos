@extends('layouts.auth')

@section('content')
<div class="form-content">
    <h1 class="">Login en <a href="/"><span class="brand-name">{{env('APP_NAME','LARAVEL')}}</span></a></h1>
    <form class="text-left" action="{{ route('login') }}" method="post">
        @csrf
        <div class="form">
            <div id="email-field" class="field-wrapper input">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    placeholder="Email" 
                    class="@error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" 
                    required autocomplete="email" 
                    autofocus
                >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div id="password-field" class="field-wrapper input mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="Password"
                    required autocomplete="current-password"
                >
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper toggle-pass">
                    <p class="d-inline-block">Mostrar Password</p>
                    <label class="switch s-primary">
                        <input type="checkbox" id="toggle-password" class="d-none">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value="">Login</button>
                </div>
            </div>
            <div class="field-wrapper text-center keep-logged-in">
                <div class="n-chk new-checkbox checkbox-outline-primary">
                    <label class="new-control new-checkbox checkbox-outline-primary">
                    <input class="new-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="new-control-indicator"></span>Recordarme
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
