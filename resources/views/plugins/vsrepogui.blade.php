@extends('layouts.app_plugins')
@section('content')

@include('partials.fe_nav')

<div class="ui two column centered grid">
    <div class="column">
        <div class="ui message">
            <div class="header">
                Huh!? Same plugin list?
            </div>
            <p>No! This page acts as a GUI for VSRepo from <a href="https://github.com/vapoursynth/vsrepo">Github</a>. All data are from there.</p>
        </div>
    </div>
</div>


<div class="ui grid vsdb-full">
	<div class="column">

		<table id="vsdb" class="ui celled compact padded striped green table selectable ">
			<thead>
				<tr>
					<th></th>
                    <th>Name</th>
                    <th class="center aligned">type</th>
					<th class="two wide">Namespace</th>
					<th>Description</th>
					<th>Category</th>
					<th class="center aligned">Published</th>
					<th class="two wide">Links</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($plugins as $plugin)

				<tr data-child-value='<td colspan="9">
						<div class="ui four column very relaxed grid">
							<?php #info ?>
							<div class="column ui raised">
								<h4 class="ui horizontal divider header">
									<i class="info circle chart icon"></i> Info
								</h4>
								<table class="ui definition table">
									<tbody>
										<tr>
											<td class="three wide column">Identifier</td>
											<td>@if(isset($plugin['identifier'])) {{ $plugin['identifier'] }} @endif</td>
                                        </tr>
                                        @isset($plugin['modulename'])
                                        <tr>
                                            <td class="three wide column">Modulename</td>
                                            <td>{{ $plugin['modulename'] }}</td>
                                        </tr>
                                        @endisset
										<tr>
											<td>Type</td>
											<td>{{ $plugin['type'] }}</td>
                                        </tr>
									</tbody>
								</table>
							</div>

							<?php #releases ?>
							<div class="column ui raised">
								<h4 class="ui horizontal divider header">
									<i class="download circle chart icon"></i> Releases
								</h4>
								@if(!empty($plugin['releases']))
								<div class="ui icon message">
									<i class="icon"><i class="fas fa-box"></i></i>
									<div class="content">
										<div class="header">
											VSRrepo is available
										</div>
										<p>Install with: <b>vsrepo install @if(isset($plugin['namespace'])) {{ $plugin['namespace'] }} @else {{ $plugin['modulename'] }} @endif</b></p>
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
											#$releases_json = json_decode($plugin->releases, true);
											$rel_counter = 0;
										?>

										@foreach ($plugin['releases'] as $releases)
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
									<i class="icon"><i class="fas fa-box"></i></i>
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
								@if(isset($plugin['dependencies']))
								<ul>
                                    @foreach ($plugin['dependencies'] as $dep)
									<li>{{ $dep }}</li>
									@endforeach
								</ul>
								@endif
							</div>
						</div>

						</td>'><!-- data-child-value END -->

					<td class="details-control"></td>
                    <td>{{ $plugin['name'] }}</td>
                    <td class="center aligned">
						@if ($plugin['type'] == "PyScript")
                            <i class="far fa-file-alt" title="{{ $plugin['type'] }}"></i>
                        @endif
                        @if ($plugin['type'] == "PyWheel")
                            <i class="fas fa-cube" title="{{ $plugin['type'] }}"></i>
                        @endif
                        @if ($plugin['type'] == "VSPlugin")
                            <i class="fas fa-file-powerpoint" title="{{ $plugin['type'] }}"></i>
						@endif
                    </td>
                    <td>@if(isset($plugin['namespace']))
                            <a href="https://github.com/vapoursynth/vsrepo/blob/master/local/{{ $plugin['namespace'] }}.json" target="_blank">{{ $plugin['namespace'] }}</a>
                        @else
                            <a href="https://github.com/vapoursynth/vsrepo/blob/master/local/{{ $plugin['modulename'] }}.json" target="_blank">{{ $plugin['modulename'] }}</a>
                        @endif</td>
					<td>{{ $plugin['description'] }}</td>
					<td><small>{{ $plugin['category'] }}</small></td>
					<td class="center aligned"><small>@if(isset($plugin['releases'][0]['published'])) {{ \Carbon\Carbon::parse($plugin['releases'][0]['published'])->format('Y-m-d') }} @endif</small></td>
					<td>
						@php
							$urls = "";
							if(isset($plugin['website']))    $urls .= '<a href="'.$plugin['website'].'" target="_blank">Website</a> | ';
							if(isset($plugin['github'])) 	$urls .= '<a href="'.$plugin['github'].'" target="_blank">Github</a> | ';
							if(isset($plugin['doom9'])) 	$urls .= '<a href="'.$plugin['doom9'].'"target="_blank">Doom9</a>';
							$urls = trim(trim(trim($urls), "|"));
						@endphp
						{!! $urls !!}
					</td>
				</tr>
					@endforeach
				</tbody>
		</table>

	</div>
</div>
@endsection
