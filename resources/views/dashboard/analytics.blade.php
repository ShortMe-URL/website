@extends('layouts.html')

@section('title', 'Analytics')

@section('body')
    <section class="container">
        <div class="row">
            {{-- Small Inofrmation Cards --}}
            <div class="col-md-4 col-sm-6 col-12">
                <div class="sic">
                    <h2>Links Count</h2>
                    <span>{{ $linksCount }}</span>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="sic">
                    <h2>Clicks Count</h2>
                    <span>{{ $clicksCount }}</span>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="sic">
                    <h2>Something</h2>
                    <span>?</span>
                </div>
            </div>

            {{-- Other Informations --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Clicks</h3><span>(This year)</span>
                    </div>
                    <div class="card-content">
                        <canvas id="clicksChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @vite('node_modules/chart.js/dist/chart.umd.js')
    @vite('resources/js/analytics.js')
@endsection

@section('head')
    @vite('resources/css/pages/dashboard/analytics.css')
    @vite('resources/css/bootstrap-grid.min.css')
@endsection
