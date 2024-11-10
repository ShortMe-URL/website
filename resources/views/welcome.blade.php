@extends('layouts.html')

@section('body')
    <section class="landing">
        <div class="container">
            <div class="col1">
                <h1>More than just shorter links</h1>
                <p>
                    Build your brand's recognition and get detailed insights on how your
                    links are performing!
                </p>
                <a href="{{ route('login') }}">Get Started</a>
            </div>
            <div class="col2">
                <img src="{{ Vite::asset('resources/images/landing.svg') }}">
            </div>
        </div>
    </section>
    <section class="shorter">
        <div class="machine" style="--image-illu: url({{ Vite::asset('resources/images/illu.svg') }});">
            <div class="container">
                <form action="{{ route('shorturl.short') }}" method="POST">
                    @csrf
                    <input type="url" name="url" id="url" placeholder="Insert your awesome url" class="url"
                        required>
                    <input type="submit" value="Short it!" id="submit">
                </form>

                @if ($errors->any())
                    <div class="error_message error">{{ $errors->first() }}</div>
                @endif
            </div>
        </div>
        <div class="container">
            @if (session('shorturl_created'))
                <div class="shorted">
                    <div class="url">
                        <div class="long">{{ session('shorturl_data')->tourl }}</div>
                        <div class="short">{{ session('shorturl_data')->getFullURL() }}</div>
                    </div>
                    <button
                        onclick="(navigator.clipboard.writeText(this.parentElement.querySelector('.url .short')?.innerText),document.execCommand('copy'),this.classList.add('copied'),this.innerText = 'Copied', window.setTimeout(() => (this.innerText = 'Copy', this.classList.remove('copied')), 2000))">
                        Copy
                    </button>
                </div>
            @endif

            <div class="features">
                <h6>Control and Manage Everything</h6>
                <h2>Advanced Statistics</h2>
                <div class="_features">
                    <div class="feature">
                        <span class="i"><i class="fad fa-pencil-paintbrush"></i></span>
                        <h3>Fully Customizable</h3>
                    </div>
                    <div class="feature">
                        <span class="i"><i class="fas fa-tachometer-alt-slow"></i></span>
                        <h3>Powerful Dashboard</h3>
                    </div>
                    <div class="feature">
                        <span class="i"><i class="fas fa-analytics"></i></span>
                        <h3>Statistics</h3>
                    </div>
                </div>
                <p>
                    Track how your links are performing across the web with our advanced
                    statistics dashboard
                </p>
            </div>
        </div>
    </section>
    <section class="stats">
        <div class="container">
            <h1>Marketing with confidence.</h1>
            <div class="stats">
                <div class="col">
                    <h3>Powering</h3>
                    <h2>{{ $linksCount }}<span>Links</span></h2>
                </div>
                <div class="col">
                    <h3>Serving</h3>
                    <h2>{{ $clicksCount }}<span>Clicks</span></h2>
                </div>
                <div class="col">
                    <h3>Trusted By</h3>
                    <h2>{{ $usersCount }}<span>Customers</span></h2>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('head')
    @vite('resources/css/pages/welcome.css')
@endsection
