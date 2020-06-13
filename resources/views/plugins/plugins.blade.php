@extends('layouts.app_plugins')
@section('content')

@include('partials.fe_nav')

<div class="ui two column centered grid">
    <div class="column">
        <div class="ui message">
            <div class="header">
                Welcome to vsdb.top - All your <a href="http://www.vapoursynth.com">VapourSynth</a> Plugins in one place! <a class="ui orange label">beta version</a>
            </div>
            <p>Most of them are also available via the VSRepo plugin manager. For more details visit <a href="https://forum.doom9.org/showthread.php?t=175590">vsrepo - doom9</a> and <a href="https://github.com/vapoursynth/vsrepo">Github</a>.</p>
            <p>If you have questions or suggestions, visit this forum thread <a href="https://forum.doom9.org/showthread.php?t=175702">vsdb - doom9</a>.</p>
        </div>
    </div>
</div>


<div class="ui grid vsdb-full">
	<div class="column">

            <center>
                <div class="ui toggle checkbox">
                    <input type="checkbox" name="gpu" id="gpu" value="gpuval">
                    <label for="gpu">Show only plugins with GPU-Support</label>
                </div>
            </center>

		<table id="vsdb" class="ui celled compact padded striped green table selectable ">
			<thead>
				<tr>
					<th></th>
                    <th>Name</th>
                    <th class="center aligned">type</th>
					<th class="two wide">Namespace</th>
					<th>Description</th>
					<th>Category</th>
					<th class="center aligned">GPU</th>
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
											<td>{{ $plugin->identifier }}</td>
										</tr>
										<tr>
											<td>Type</td>
											<td>{{ $plugin->type }}</td>
                                        </tr>
                                        @if($plugin->vs_included)
                                        <tr>
											<td>Included Plugin</td>
											<td><a href="{{ $plugin->url_website }}">Link</a></td>
										</tr>
                                        @endif

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
									<i class="icon"><i class="fas fa-box"></i></i>
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
								@if(!empty($plugin->dependencies))
								<ul>
									@foreach (explode(",", $plugin->dependencies) as $dep)
									<li>{{ $dep }}</li>
									@endforeach
								</ul>
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
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
										@foreach($plugin->functions as $pfunction)
										<tr>
											<td>{{ $pfunction['name'] }}</td>
											<td class="center aligned">{{ $pfunction['bitdepth'] ?: 'unknown' }}</td>
											<td class="center aligned">{{ $pfunction['colorspace'] ?: 'unknown' }}</td>
											<td>{{ $pfunction['description'] ?: '-' }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						</td>'><!-- data-child-value END -->

					<td class="details-control"></td>
                    <td>{{ $plugin->name }}</td>
                    <td class="center aligned">
						@if ($plugin->type == "PyScript")
                            <i class="far fa-file-alt" title="{{ $plugin->type }}"></i>
						@else
                            <i class="fas fa-file-powerpoint" title="{{ $plugin->type }}"></i>
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
					<td>{{ $plugin->gpusupport }}</td>
					<td class="center aligned"><small>@if(!empty($plugin->version_published)) {{ \Carbon\Carbon::parse($plugin->version_published)->format('Y-m-d') }} @endif</small></td>
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
				</tbody>
		</table>

	</div>
</div>
@endsection
