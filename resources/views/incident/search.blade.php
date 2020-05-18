@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('incident.query') }}" method="POST" id="inc-search-form">
                @csrf
                <div class="form-group row">
                    <div class="col">
                        <h4 class="font-weight-bolder">{{ $title }}</h4>
                    </div>
                    <div class="col align-right">
                        <button type="reset" id="reset-inc-search"
                            style="background: #ff0000; color: white; font-weight: bold; border: none; padding: 1px 8px; border-radius: 50%; cursor: pointer; float: right">+</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="keyword" class="font-weight-bold">Keyword</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="text" class="form-control" id="keyword" name="keyword"
                            value="@if(session()->has('keyword')){{ session('keyword') }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="category" class="font-weight-bold">Category</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="category" name="category"
                            data-prev_id="@if(session()->has('category')){{ session('category') }}@endif">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="date" class="font-weight-bold">Date</label>
                        <small class="text-secondary" style="display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="date" class="form-control input-expand-date" id="date" name="date"
                            value="@if(isset($date) && $date){{ $date }}@endif">
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
<div class="container" id="inc-search-results">
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
                        <th scope="col">Category</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Date</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('results') as $key => $value)
                    <tr>
                        <th scope="row"><a href="{{ route('incident.show', $value) }}">{{ $value->id }}</a></th>
                        <td><a href="{{ route('incident.show', $value) }}">{{ $value->category->name }}</a></td>
                        <td>{{ $value->user->name }}</td>
                        <td>{{ $value->date }}</td>
                        <td>{{ $value->description }}</td>
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
<script src="{{ asset('js/search_incident.js') }}"></script>
@endsection
