<nav id="nav">  
<ul>
    @auth
      @if(auth()->user()->role === 'verified')
        <li @if(request()->routeIs('tournaments.create')) class="current" @endif>
          <a href="{{ route('tournaments.create') }}">Create Tournament</a>
        </li>
      @endif
    @endauth
    <li class="{{ request()->routeIs('home')      ? 'current' : '' }}">
      <a href="{{ route('home') }}">Latest Post</a>
    </li>
    <li class="{{ request()->routeIs('archives')  ? 'current' : '' }}">
      <a href="{{ route('archives') }}">Archives</a>
    </li>
    <li class="{{ request()->routeIs('apply')     ? 'current' : '' }}">
      <a href="{{ route('apply') }}">Apply for verification</a>
    </li>
    <li class="{{ request()->routeIs('contact')   ? 'current' : '' }}">
      <a href="{{ route('contact') }}">Contact me</a>
    </li>
  </ul>
</nav>
