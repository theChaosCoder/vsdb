<div class="ui inverted menu">
	<div class="ui container">
		<a href="/" class="header item">
            <img class="logo" src="{{ asset('images/vsdb_icon.png') }}" style="margin-right:3px"> VSDB - VapourSynth Database
        </a>
		<a  href="/" class="item {{ Request::is('/') ? 'active' : '' }}">Home</a>
        <a href="/vsrepogui" class="item {{ Request::is('vsrepogui') ? 'active' : '' }}">VSRepo Gui</a>
        <a href="/avsrepogui" class="item {{ Request::is('avsrepogui') ? 'active' : '' }}">AVSRepo Gui</a>
		<a href="https://forum.doom9.org/showthread.php?p=1844512" target="_blank" class="item">VS Portable FATPACK</a>
		<a href="/stats" class="item {{ Request::is('stats') ? 'active' : '' }}">Plugin statistics</a>
	</div>
</div>
