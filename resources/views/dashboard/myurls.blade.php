@extends('layouts.html')

@section('title', 'Your URLs')

@section('body')
    <div class="container" id="shorter">
        <div class="machine" style="--image-illu: url({{ Vite::asset('resources/images/illu.svg') }});">
                <h1>Short Your Link:</h1>
                <form action="{{ route('shorturl.short') }}" method="POST">
                    @csrf
                    <input type="url" name="url" id="url" placeholder="Insert your awesome url" class="url"
                        required>
                    <input type="submit" id="submit" value="Short it!">
                </form>
        </div>

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

        @if ($errors->any())
            <div class="error_message error">{{ $errors->first() }}</div>
        @endif
    </div>
    <section class="container">
        @if ($userLinks->count() > 0)
            <form id="optionsForm" action="{{ route('dashboard.myurls') }}" method="get">
                <x-select name="sort">
                    <option value="newtoold">Newest to Oldest</option>
                    <option value="oldtonew">Oldest to Newest</option>
                    <option value="mostclicks">Most Clicks</option>
                </x-select>
                <button type="submit">Filter</button>
            </form>

            <div style="overflow-x: auto;border-radius: 15px;">
                <table>
                    <tr>
                        <th>Link</th>
                        <th>Password</th>
                        <th>Clicks</th>
                        <th>Created At</th>
                        <th>Deletes At</th>
                        <th></th>
                    </tr>
                    @foreach ($userLinks as $link)
                        <tr>
                            <th>{{ $link->getFullURL() }}</th>
                            <th>{{ $link->password ? 'Yes' : 'No' }}</th>
                            <th>{{ $link->clicks()->count() }}</th>
                            <th>{{ $link->created_at->format('Y-m-d') }}</th>
                            <th>{{ $link->delete_at ? \Carbon\Carbon::parse($link->delete_at)->format('Y-m-d') : 'Never' }}
                            </th>
                            <th><button type="submit">Delete</button></th>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <h2 style="color: var(--nav-text);">You didn't short any link yet!</h2>
        @endif

    </section>

    @vite('resources/js/myurls.js')
@endsection

@section('head')
    @vite('resources/css/pages/dashboard/myurls.css')
    @vite('resources/css/bootstrap-grid.min.css')
@endsection
