@extends('layouts.html')

@section('title', "Register")

@section('body')
    <section class="container">

        <form action="{{ route('register') }}" method="post" class="card">
            @csrf
            <h1>Register</h1>
            <div class="input-group">
                <x-input type="text" name="name" id="name" placeholder="Username" :showerrors="true" required />
                <x-input type="email" name="email" id="email" placeholder="Email" :showerrors="true" required />
                <x-input type="password" name="password" id="password" placeholder="Password" :showerrors="true" required />
                <x-input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" :showerrors="true" required />
            </div>
            <button type="submit"><i class="fa-duotone fa-solid fa-user-plus"></i> Register</button>
            <span class="noacc">Already have an account? <a href="{{ route('login') }}">Login</a></span>
        </form>

    </section>
@endsection

@section('head')
    @vite('resources/css/pages/login-register.css')
@endsection
