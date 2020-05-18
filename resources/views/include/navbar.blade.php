<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @guest
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('Menu') }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('resource.create') }}">
                            Add Available Resource
                        </a>
                        <a class="dropdown-item" href="{{ route('incident.create') }}">
                            Add Emergency Incident
                        </a>
                        <a class="dropdown-item" href="{{ route('resource.search') }}">
                            Search Resources
                        </a>
                        <a class="dropdown-item" href="{{ route('incident.search') }}">
                            Search Incidents
                        </a>
                        <a class="dropdown-item" href="{{ route('resource.report') }}">
                            Generate Resources Report
                        </a>
                        <a class="dropdown-item" href="{{ route('incident.report') }}">
                            Generate Incidents Report
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('Resources') }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('resource.index') }}">
                            All Resources
                        </a>
                        <a class="dropdown-item" href="{{ route('resource.create') }}">
                            Add Resource
                        </a>
                        <a class="dropdown-item" href="{{ route('resource.search') }}">
                            Search Resources
                        </a>
                        <a class="dropdown-item" href="{{ route('resource.report') }}">
                            Resources Report
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('Incidents') }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('incident.index') }}">
                            All Incidents
                        </a>
                        <a class="dropdown-item" href="{{ route('incident.create') }}">
                            Add Incident
                        </a>
                        <a class="dropdown-item" href="{{ route('incident.search') }}">
                            Search Incidents
                        </a>
                        <a class="dropdown-item" href="{{ route('incident.report') }}">
                            Incidents Report
                        </a>
                    </div>
                </li>
                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
