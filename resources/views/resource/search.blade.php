@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('resource.query') }}" method="POST" id="res-search-form">
                @csrf
                <div class="form-group row">
                    <div class="col">
                        <h4 class="font-weight-bolder">{{ $title }}</h4>
                    </div>
                    <div class="col align-right">
                        <button type="reset" id="reset-res-search"
                            style="background: #ff0000; color: white; font-weight: bold; border: none; padding: 1px 8px; border-radius: 50%; cursor: pointer; float: right">+</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="keyword" class="font-weight-bold">Keywords</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="text" class="form-control" id="keyword" name="keyword"
                            value="@if(session()->has('keyword')){{ session('keyword') }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="primary-function" class="font-weight-bold">Primary Function</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="primary-function" name="primary-function"
                            data-prev_id="@if(session()->has('primary_function')){{ session('primary_function') }}@endif">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="incident" class="font-weight-bold">Incident</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="incident" name="incident"
                            data-prev_id="@if(session()->has('incident')){{ session('incident') }}@endif">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="distance" class="font-weight-bold">Distance within PCC</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="number" class="form-control" id="distance" name="distance"
                            value="@if(session()->has('distance')){{ session('distance') }}@endif" step="any" min="0"
                            placeholder="miles">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm text-right">
                        <a href="/" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session()->has('results'))
<div class="container" id="res-search-results">
    <div class="row justify-content-center">
        <div class="col">
            <div class="text-center">
                <h4 class="font-weight-bold">
                    {{ session('search_title') }}
                </h4>
            </div>
            @if(session()->has('results') && count(session('results')))
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Resource Name</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Primary Functions</th>
                        <th scope="col">Distance</th>
                        <th scope="col">Cost&nbsp;/&nbsp;Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('results') as $key => $value)
                    <tr>
                        <th scope="row"><a href="{{ route('resource.show', $value) }}">{{ $value->id }}</a></th>
                        <td><a href="{{ route('resource.show', $value) }}">{{ $value->name }}</a></td>
                        <td>{{ $value->user->name }}</td>
                        <td>{{ $value->pri_func->name }}</td>
                        <td>{{ $value->distance }}</td>
                        <td>${{ $value->cost }}&nbsp;/&nbsp;{{ $value->unit_cost->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="font-weight-bold text-center">
                No results found
            </div>
            @endif
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/search_resource.js') }}"></script>
@endsection
