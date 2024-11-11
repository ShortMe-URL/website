@extends('layouts.html')

@section('body')
    <section class="container" id="password-container">
        <form class="card" action="{{ url()->current() }}" method="POST">
            @csrf
            <p>This URL is secured with a password!</p>
            <h2>Enter Your Password:</h2>
            <x-input name="password" showerrors="true" />
            <button type="submit">Submit</button>
        </form>
    </section>
@endsection

@section('head')
    <style>
        #password-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            margin: 0;
        }
        form {
            color: var(--text);
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 600px;
        }
    </style>
@endsection
