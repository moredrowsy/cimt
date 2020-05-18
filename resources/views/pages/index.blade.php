@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold text-center">
                    Welcome to the CERT Incident Management Tool (CIMT)
                </div>

                <div class="card-body">
                    The CIMT is an online web application that manages available resources and their assignments to
                    various emergency incidents that may have already occured, are happening or may happen in the future
                    in and around Pasadena City College campus. Emergency incidents may include, but not limited to,
                    hazardous waste spills, acts of terrorism, nunclear incident, campus shooting, car crashes with
                    fatalities, flooding, fire, etc.
                </div>
            </div>

            @guest
            @else
            @if(isset($verified) && $verified)
            <div class="card text-center mt-5">
                <div class="card-header font-weight-bold">
                    {{__('Menu')}}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{route('resource.create')}}">Add Available Resource</a></li>
                    <li class="list-group-item"><a href="{{route('incident.create')}}">Add Emergency Incident</a></li>
                    <li class="list-group-item"><a href="{{route('resource.search')}}">Search Resources</a></li>
                    <li class="list-group-item"><a href="{{route('incident.search')}}">Search Incidents</a></li>
                    <li class="list-group-item"><a href="{{route('resource.report')}}">Generate Resources Report</a>
                    </li>
                    <li class="list-group-item"><a href="{{route('incident.report')}}">Generate Incidents Report</a>
                    </li>
                    <li class="list-group-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endif
            @endguest
        </div>
    </div>
</div>
@endsection
