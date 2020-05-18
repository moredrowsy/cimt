@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="text-center">
                <h4 class="font-weight-bold">
                    {{ $title }}
                </h4>
            </div>
            @if(isset($incidents) && count($incidents))
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
                    @foreach($incidents as $key => $value)
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
            {{ $incidents->links() }}
            @else
            <div class="font-weight-bold text-center">
                There are currently no incidents
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/common.js') }}"></script>
@endsection
