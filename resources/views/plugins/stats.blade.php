@extends('layouts.app_plugins')
@section('content')

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/scss/style.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    .ui.menu {
        margin: 0px !important;
    }
</style>

<script>
    $(document).ready(function(){

        var options = {
                chart: {
                    height: 600,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                series: [{
                    name: "Plugin/Script count",
                    data: {{ $count['categories']['count'] }}
                }],
                xaxis: {
                    categories: {!! $count['categories']['name'] !!},
                },
                yaxis: {
                    max: 130,
                },
        }

        var options_pie = {
            chart: {
                width: 380,
                type: 'pie',
            },
            legend: {
                show: true,
                position: 'bottom'
            },
            series: [{{ $count['type_plugin'] }}, {{ $count['type_script'] }}],
            labels: ['Plugins', 'Scripts'],
            colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800'],
        }


        var chart = new ApexCharts(
            document.querySelector("#chart"), options
        );
        var piechart = new ApexCharts(
            document.querySelector("#piechart"), options_pie
        );
        chart.render();
        piechart.render();

    });
</script>

@include('partials.fe_nav')

<div class="col-md-12 col-lg-11" style="float:none; margin: 0 auto;">
    <h1 class="heading-title mt-4 mb-3">Statistics</h1>
    <div class="row">


        <div class="col-md-6 col-lg-3">
                <div class="card bg-flat-color-5 text-light">
                    <div class="card-body">
                        <div class="h4 m-0">{{ $count['plugins'] }}</div>
                        <div>Plugins & Scripts</div>
                        <div class="progress-bar bg-light mt-2 mb-2" role="progressbar" style="width: @php echo $count['plugins'] / $count['plugins_and_col_functions'] * 100  @endphp%; height: 5px;"></div>
                        <small class="text-light">Equal to file count</small>
                    </div>
                </div>
            </div><!--/.col-->

            <div class="col-md-6 col-lg-3">
                <div class="card bg-flat-color-1 text-light">
                    <div class="card-body">
                        <div class="h4 m-0">{{ $count['plugins_and_col_functions'] }}</div>
                        <div>Plugins & Scripts</div>
                        <div class="progress-bar bg-light mt-2 mb-2" role="progressbar" style="width: 100%; height: 5px;"></div>
                        <small class="text-light">Plugins and all "plugins" inside a Script like havsfunc</small>
                    </div>
                </div>
            </div><!--/.col-->

            <div class="col-md-6 col-lg-3">
                <div class="card bg-flat-color-2 text-light">
                    <div class="card-body">
                        <div class="h4 m-0">{{ $count['vsrepo'] }}</div>
                        <div>VSRepo</div>
                        <div class="progress-bar bg-light mt-2 mb-2" role="progressbar" style="width: @php echo $count['vsrepo'] / $count['plugins_and_col_functions'] * 100  @endphp%; height: 5px;"></div>
                        <small class="text-light">Packages without external dependencies like FFTW3</small>
                    </div>
                </div>
            </div><!--/.col-->

            <div class="col-md-6 col-lg-3">
                <div class="card bg-flat-color-4 text-light">
                    <div class="card-body">
                        <div class="h4 m-0">{{ $count['pfunctions'] }}</div>
                        <div>Plugin-Functions</div>
                        <div class="progress-bar bg-light mt-2 mb-2" role="progressbar" style="width: 100%; height: 5px;"></div>
                        <small class="text-light">Number of all Plugin-Functions in all Plugins</small>
                    </div>
                </div>
        </div><!--/.col-->

    </div>


    <div class="row mt-4">
        <div class="col-md-5 col-lg-3">
            <div id="piechart"></div>
        </div>
        <div class="col-md-7 col-lg-9">
            <div id="chart"></div>
        </div>
    </div>


    <h2 class="heading-title mt-4 mb-3">Potential namespace conflicts</h1>
    <div class="row">
        <div class="col-md-12 col-lg-12 mb-4">


            <table class="ui celled compact padded striped green table selectable ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="center aligned">type</th>
                        <th class="two wide">Namespace</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Links</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dupes as $key => $plugins)
                        @foreach($plugins as $plugin)
                        <tr>
                            <td>{{ $plugin->name }}</td>
                            <td class="center aligned">
                                @if ($plugin->type == "PyScript")
                                    <img width=20 height=20 alt='{{ $plugin->type }}' src='https://png.icons8.com/metro/50/000000/source-code.png'>
                                @else
                                    <img width=20 height=20 alt='{{ $plugin->type }}' src='https://png.icons8.com/metro/50/000000/dll.png'>
                                @endif
                            </td>
                            <td>@if(empty($plugin->shortalias))
                                    <a href="/plugins/{{ $plugin->namespace }}" target="_blank">{{ $plugin->namespace }}</a>
                                @else
                                    <small>import</small> <a href="/plugins/{{ $plugin->namespace }}" target="_blank">{{ $plugin->namespace }}</a> <small>as {{ $plugin->shortalias }}</small>
                                @endif
                            </td>
                            <td>{{ $plugin->description }}</td>
                            <td><small>{{ $plugin->categories['name'] ?? 'unknown' }}</small></td>
                            <td>
                                @php
                                    $urls = "";
                                    if(!empty($plugin->url_website) && $plugin->url_github != $plugin->url_website) $urls .= '<a href="'.$plugin->url_website.'" target="_blank">Website</a> | ';
                                    if(!empty($plugin->url_github)) 	$urls .= '<a href="'.$plugin->url_github.'" target="_blank">Github</a> | ';
                                    if(!empty($plugin->url_doom9)) 	$urls .= '<a href="'.$plugin->url_doom9.'"target="_blank">Doom9</a> | ';
                                    if(!empty($plugin->url_avswiki)) 	$urls .= '<a href="'.$plugin->url_avswiki.'" target="_blank">AvsWiki</a>';
                                    $urls = trim(trim(trim($urls), "|"));
                                @endphp
                                {!! $urls !!}
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

        </div><!--/.col-->
    </div>


</div>
@endsection
