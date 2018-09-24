@extends('layouts.app_plugins')
@section('content')


<div class="ui fixed_ inverted menu">
	<div class="ui container">
		<a href="/" class="header item">
            <img class="logo" src="{{ asset('images/vsdb_icon.png') }}" style="margin-right:3px"> VSDB - VapourSynth Database
        </a>
		<a href="/" class="item">Home</a>
		<a href="#" class="item">VSRepo Gui</a>
		<a href="#" class="item">Plugin statistics</a>
	</div>
</div>











<div class="ui grid vsdb-full">
	<div class="column">

				@forelse ($plugins as $plugin)
                        <h1 style="border-bottom: 1px solid black; margin-top: 10px; margin-bottom: 20px">{{ $plugin->name }}</h1>

						<div class="ui four column very relaxed grid">
							<?php #info ?>
							<div class="column ui raised">
								<h4 class="ui horizontal divider header">
									<i class="info circle chart icon"></i> Info
								</h4>
								<table class="ui definition table">
									<tbody>
                                        <tr>
                                            <td class="four wide column">Name</td>
                                            <td>{{ $plugin->name }}</td>
                                        </tr>
										<tr>
                                            <td>Identifier</td>
                                            <td>{{ $plugin->identifier }}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>{{ $plugin->type }}</td>
                                        </tr>
                                        <tr>
                                            <td>Category</td>
                                            <td>{{ $plugin->categories['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>{{ $plugin->description }}</td>
                                        </tr>
                                        <tr>
                                            <td>Has GPU-Support?</td>
                                            <td>@empty($plugin->gpusupport) no @endempty {{ $plugin->gpusupport }}</td>
                                        </tr>
                                        <tr>
                                            <td>Links</td>
                                            <td>
                                                @php
                                                    $urls = "";
                                                    if(!empty($plugin['url_website']) && $plugin['url_github'] != $plugin['url_website']) $urls .= '<a href="'.$plugin['url_website'].'" target="_blank">Website</a> | ';
                                                    if(!empty($plugin['url_github'])) 	$urls .= '<a href="'.$plugin['url_github'].'" target="_blank">Github</a> | ';
                                                    if(!empty($plugin['url_doom9'])) 	$urls .= '<a href="'.$plugin['url_doom9'].'"target="_blank">Doom9</a> | ';
                                                    if(!empty($plugin['url_avswiki'])) 	$urls .= '<a href="'.$plugin['url_avswiki'].'" target="_blank">AvsWiki</a>';
                                                    $urls = trim(trim(trim($urls), "|"));
                                                @endphp
                                                {!! $urls !!}
                                            </td>
                                        </tr>

									</tbody>
								</table>
							</div>

							<?php #releases ?>
							<div class="column ui raised">
								<h4 class="ui horizontal divider header">
									<i class="download circle chart icon"></i> Releases
								</h4>
								@if(!empty($plugin->releases))
								<div class="ui icon message">
									<i class="icon"><img width=40 height=40 src="https://png.icons8.com/metro/50/000000/box.png"></i>
									<div class="content">
										<div class="header">
											VSRrepo is available
										</div>
										<p>Install with: <b>vsrepo install {{ $plugin->namespace }}</b></p>
									</div>
								</div>

								<table class="ui table">
									<thead>
										<tr>
											<th>Version</th>
											<th>Published</th>
											<th>Download</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$releases_json = json_decode($plugin->releases, true);
											$rel_counter = 0;
										?>

										@foreach ($releases_json as $releases)
										@if($loop->iteration > 5) {{-- Show only the last 5 download links for now. Todo: "show more" table --}}
											@php
												continue;
											@endphp
										@endif
										<tr>
											<td>{{ $releases['version'] }}</td>
											<td>
                                                @isset($releases['published']) {{ \Carbon\Carbon::parse($releases['published'])->format('Y-m-d') }} @endisset
											</td>
											<td>
												@isset($releases['win32']['url'])	<a href="{{ $releases['win32']['url'] }}">win32</a>	  @endisset
												@isset($releases['win64']['url'])	<a href="{{ $releases['win64']['url'] }}">win64</a>	  @endisset
												@isset($releases['script']['url'])	<a href="{{ $releases['script']['url'] }}">script</a>  @endisset
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>

								@else
								<div class="ui icon message">
									<i class="icon"><img width=40 height=40 src="https://png.icons8.com/metro/50/000000/box.png"></i>
									<div class="content">
										<div class="header">
											VSRrepo is NOT available! :-(
										</div>
										<p>Further information here: <b><a href="https://github.com/vapoursynth/vsrepo"
                                                    target="_blank">VSRepo</a></b></p>
									</div>
								</div>
								@endif
							</div>

							<?php #dependencies ?>
							<div class="column ui raised">
								<h4 class="ui horizontal divider header">
									<i class="cubes circle chart icon"></i> Dependencies
								</h4>
								@if(!empty($plugin->dependencies))
								<ul>
									@foreach (explode(",", $plugin->dependencies) as $dep)
									<li>{{ $dep }}</li>
									@endforeach
                                </ul>
                                @else
                                    <center>no dependencies</center>
								@endif
							</div>
						</div>


						<div class="ui column very relaxed grid">
							<?php #### info ?>
							<div class="column ui raised">
								<h4 class="ui horizontal divider header">
									<i class="cog circle chart icon"></i> Plugin-Functions
								</h4>

								<table style="margin-bottom: 20px" class="ui definition table">
									<thead>
										<tr>
											<th class="two wide"></th>
											<th class="two wide center aligned">Bit Depth</th>
                                            <th class="two wide center aligned">Color Space</th>
                                            @if(!empty($plugin->categories['name']))
                                            <th class="two wide center aligned">Category</th>
                                            @endif
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
										@foreach($plugin->functions as $pfunction)
										<tr>
											<td>{{ $pfunction['name'] }}</td>
											<td class="center aligned">{{ $pfunction['bitdepth'] ?: 'unknown' }}</td>
                                            <td class="center aligned">{{ $pfunction['colorspace'] ?: 'unknown' }}</td>
                                            @if(!empty($plugin->categories['name']))
                                            <td class="center aligned">{{ $pfunction->categories['name'] ?: 'unknown' }}</td>
                                            @endif
											<td>{{ $pfunction['description'] ?: '-' }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
                        </div>

                    @empty
                        <center><b>This plugin does not exist</b></center>
					@endforelse


	</div>
</div>
@endsection
