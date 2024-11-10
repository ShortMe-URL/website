@extends('layouts.html')

@section('title', 'Your URLs')

@section('body')
    <div class="container" id="shorter">
        <div class="machine" style="--image-illu: url({{ Vite::asset('resources/images/illu.svg') }});">
            <h1>Short Your Link:</h1>
            <form action="{{ route('shorturl.short') }}" method="POST">
                @csrf
                <div class="url-sub">
                    <input type="url" name="url" id="url" placeholder="Insert your awesome url" class="url"
                        required value="{{ old('url') }}" />
                    <input type="submit" id="submit" value="Short it!">
                </div>
                <p id="advopt"><i class="fas fa-plus"></i> Advanced Options</p>
                <div class="advopt-inputs row">
                    <div class="input-content-group col-sm-6 col-12">
                        <label for="delete_at">Delete After:</label>
                        <x-select name="delete_at">
                            <option value="1day" {{ old('delete_at') === '1day' ? 'selected' : '' }}>After 1 Day</option>
                            <option value="3day" {{ old('delete_at') === '3day' ? 'selected' : '' }}>After 3 Day</option>
                            <option value="7day" {{ old('delete_at') === '7day' ? 'selected' : '' }}>After 7 Day</option>
                            <option value="1month"
                                {{ old('delete_at') === '1month' ? 'selected' : (old('delete_at') ? '' : 'selected') }}>
                                After a Month</option>
                            <option value="1year" {{ old('delete_at') === '1year' ? 'selected' : '' }}>After a Year
                            </option>
                        </x-select>
                    </div>
                    <div class="input-content-group col-sm-6 col-12">
                        <label for="password">Password</label>
                        <x-input name="password" />
                    </div>
                    @if (auth()->user()->premium === true)
                        <div class="input-content-group col-12">
                            <label for="shortpath">Custom URL</label>
                            <x-input name="shortpath" placeholder="{{ env('PREMIUM_LINKS_URL') . '/CUSTOM-ID' }}" />
                        </div>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif
            </form>
        </div>

        @if (session('shorturl_created'))
            <div class="shorted">
                <div class="url">
                    {{-- <div class="long">{{ session('shorturl_data')->tourl }}</div> --}}
                    <div class="short">{{ session('shorturl_data')->getFullURL() }}</div>
                </div>
                <button
                    onclick="(navigator.clipboard.writeText(this.parentElement.querySelector('.url .short')?.innerText),document.execCommand('copy'),this.classList.add('copied'),this.innerText = 'Copied', window.setTimeout(() => (this.innerText = 'Copy', this.classList.remove('copied')), 2000))">
                    Copy
                </button>
            </div>
        @endif
    </div>
    <section class="container">
        @if ($userLinks->count() > 0)
            <form id="optionsForm" action="{{ route('dashboard.myurls') }}" method="get">
                <x-select name="sort">
                    <option value="newtoold" {{ request('sort') === 'newtoold' ? 'selected' : '' }}>Newest to Oldest
                    </option>
                    <option value="oldtonew" {{ request('sort') === 'oldtonew' ? 'selected' : '' }}>Oldest to Newest
                    </option>
                    <option value="mostclicks" {{ request('sort') === 'mostclicks' ? 'selected' : '' }}>Most Clicks
                    </option>
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
                            <th><button onclick="deleteLink(this);" data-deleteURL="{{ route('dashboard.myurls.delete', $link->id) }}">Delete</button>
                            </th>
                        </tr>
                    @endforeach
                </table>
            </div>
            
        @else
            <h2 style="color: var(--nav-text);">You didn't short any link yet!</h2>
        @endif

    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/myurls.js')
    <script>
        /**
         * @param {HTMLButtonElement} button 
         */
        function deleteLink(button) {
            Swal.fire({
                title: "Are you sure you want to delete the URL?",
                showCancelButton: true,
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(button.getAttribute('data-deleteURL'), {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.ok ? button.closest('tr').remove() : Promise.reject())
                        .then(() => Swal.fire("Deleted!", "The URL has been deleted.", "success"))
                        .catch(() => Swal.fire("Error!", "An error occurred while trying to delete the URL.",
                            "error"));
                }
            });
        }
    </script>
@endsection

@section('head')
    @vite('resources/css/pages/dashboard/myurls.css')
    @vite('resources/css/bootstrap-grid.min.css')
@endsection
