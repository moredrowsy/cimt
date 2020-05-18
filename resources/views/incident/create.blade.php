@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('incident.store') }}" method="POST" id="inc-create-form">
                @csrf
                <div class="form-group row">
                    <div class="col">
                        <h4 class="font-weight-bolder">{{ $title }}</h4>
                    </div>
                    <div class="col align-right">
                        <!-- Button trigger modal -->
                        <button type="button" data-toggle="modal" data-target="#resetModal"
                            style="background: #ff0000; color: white; font-weight: bold; border: none; padding: 1px 8px; border-radius: 50%; cursor: pointer; float: right">+</button>

                        <!-- Modal -->
                        <div class="modal fade" id="resetModal" tabindex="-1" role="dialog"
                            aria-labelledby="resetModalTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="resetModalTitle">Confirm Reset</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to reset the form?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="reset" class="btn btn-primary" id="reset-inc-create"
                                            data-dismiss="modal">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Incident ID</span>
                        <small class="text-secondary" style="display: block">(assigned on save)</small>
                    </div>
                    <div class="col-sm-10  col-form-label align-self-center" id="incident-id">
                        @if(session()->has('id'))<a
                            href="{{ route('incident.show', session('id')) }}">{{ session('id') }}</a>@endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Owner</span>
                    </div>
                    <div class="col-sm-10  col-form-label align-self-center" id="resource-id">
                        {{ $user->name }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="category" class="font-weight-bold">Category&nbsp;<span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-10  col-form-label align-self-center">
                        <select class="form-control" id="category" name="category"
                            data-prev_id="@if(session()->has('category')){{ session('category') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="date" class="font-weight-bold">Date&nbsp;<span class="text-danger">*</span></label>
                        <small class="text-secondary" style="display: block">(required)</small>
                    </div>
                    <div class="col-sm-10  col-form-label align-self-center">
                        <input type="date" class="form-control input-expand-date" id="date" name="date"
                            value="@if(session()->has('date')){{ session('date') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="description" class="font-weight-bold">Description&nbsp;<span
                                class="text-danger">*</span></label>
                        <small class="text-secondary" style="display: block">(required)</small>
                    </div>
                    <div class="col-sm-10  col-form-label align-self-center">
                        <input type="text" class="form-control" id="description" name="description"
                            value="@if(session()->has('description')){{ session('description') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm text-right">
                        <a href="/" class="btn btn-secondary">Cancel</a>
                        <button type="submit" @if(session()->has('id'))class="btn btn-primary d-none" {{ 'disabled '}}
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
