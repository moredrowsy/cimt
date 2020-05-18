@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('incident.update', $incident->id) }}" method="POST" id="inc-create-form">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col">
                        <h4 class="font-weight-bolder">{{ $title }}</h4>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Incident ID</span>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center" id="incident-id"> {{ $incident->id }} </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Owner</span>
                    </div>
                    <div class="col-sm-10  col-form-label align-self-center" id="resource-id">
                        {{ $incident->user->name }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="category" class="font-weight-bold">Category&nbsp;<span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="category" name="category"
                            data-prev_id="{{ $incident->category_id }}">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="date" class="font-weight-bold">Date&nbsp;<span class="text-danger">*</span></label>
                        <small class="text-secondary" style="display: block">(required)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="date" class="form-control input-expand-date" id="date" name="date"
                            value="{{ $incident->date }}" required>
                    </div>
                </div>
                <div class=" form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="description" class="font-weight-bold">Description&nbsp;<span
                                class="text-danger">*</span></label>
                        <small class="text-secondary" style="display: block">(required)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="text" class="form-control" id="description" name="description"
                            value="{{ $incident->description }}" required>
                    </div>
                </div>
                <div class=" form-group row">
                    <div class="col-sm text-right">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary">Back</a>
                        <button type="submit" @if(session()->has('id'))class="btn btn-primary d-none"
                            {{ 'disabled '}}
                            @else class="btn btn-primary"
                            @endif
                            id="save"
                            >Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/create_incident.js') }}"></script>
@endsection
