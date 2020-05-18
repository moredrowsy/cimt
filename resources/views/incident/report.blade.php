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
            @if(isset($reports) && count($reports))
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" width="10%">ID</th>
                        <th scope="col">Category</th>
                        <th scope="col" class="text-center" width="15%">Total Incidents</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $key => $value)
                    <tr>
                        <th scope="row" width="10%">{{ $value->id }}</th>
                        <td>{{ $value->name }}</td>
                        <td class="text-center" width="15%">{{ $value->count }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-secondary table-borderless font-weight-bold">
                        <th scope="row" width="10%"></th>
                        <td>Total</td>
                        <td class="text-center" width="15%">{{ $total }}</td>
                    </tr>
                </tbody>
            </table>
            @else
            <div class="font-weight-bold text-center">There are currently no reports</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/common.js') }}"></script>
@endsection
