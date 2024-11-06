@extends('layouts.html')

@section('body')
    <section class="container">

        <form action="{{ route('login') }}" method="post" class="card">
            @csrf
            <h1>Login</h1>
            @if ($errors->any())
                <p class="alert-danger">{{ $errors->first() }}</p>
            @endif
            <div class="input-group">
                <x-input type="email" name="email" id="email" placeholder="Email" />
                <x-input type="password" name="password" id="password" placeholder="Password" />
            </div>
            <button type="submit"><i class="fa-duotone fa-solid fa-right-to-bracket"></i> Login</button>
            <span class="noacc">Don't have an account? <a href="{{ route('register') }}">Register</a></span>
        </form>

    </section>
@endsection

@section('head')
    @vite('resources/css/pages/login.css')
@endsection
