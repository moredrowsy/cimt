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
            @if(isset($resources) && count($resources))
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Resource Name</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Primary Functions</th>
                        <th scope="col">Secondary Functions</th>
                        <th scope="col">Distance</th>
                        <th scope="col">Cost&nbsp;/&nbsp;Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resources as $key => $value)
                    <tr>
                        <th scope="row"><a href="{{ route('resource.show', $value) }}">{{ $value->id }}</a></th>
                        <td><a href="{{ route('resource.show', $value) }}">{{ $value->name }}</a></td>
                        <td>{{ $value->user->name }}</td>
                        <td>{{ $value->pri_func->name }}</td>
                        <td>@if(isset($value->sec_func)){{ $value->sec_func->name }}@endif</td>
                        <td>{{ $value->distance }}</td>
                        <td>${{ $value->cost }}&nbsp;/&nbsp;{{ $value->unit_cost->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $resources->links() }}
            @else
            <div class="font-weight-bold text-center">
                There are currently no resources
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/common.js') }}"></script>
@endsection
