@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('resource.store') }}" method="POST" id="res-create-form">
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
                                        <button type="reset" class="btn btn-primary" id="reset-res-create"
                                            data-dismiss="modal">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Resource ID</span>
                        <small class="text-secondary" style=" display: block">(assigned on save)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center" id="resource-id">
                        @if(session()->has('id'))<a
                            href="{{ route('resource.show', session('id')) }}">{{ session('id') }}</a>@endif
                    </div>
                </div>
                <div class="form-group row h-100">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Owner</span>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center" id="resource-id">
                        {{ $user->name }}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="resource-name" class="font-weight-bold">Resource Name&nbsp;<span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="text" class="form-control" id="resource-name" name="resource-name"
                            value="@if(session()->has('resource_name')){{ session('resource_name') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="primary-function" class="font-weight-bold">Primary Function</label>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="primary-function" name="primary-function"
                            data-prev_id="@if(session()->has('primary_function')){{ session('primary_function') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="secondary-function" class="font-weight-bold">Secondary Function</label>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="secondary-function" name="secondary-function"
                            data-prev_id="@if(session()->has('secondary_function')){{ session('secondary_function') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="description" class="font-weight-bold">Description</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="text" class="form-control" id="description" name="description"
                            value="@if(session()->has('description')){{ session('description') }}@endif"
                            @if(session()->has('id')){{'disabled'}}@endif>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="capabilities" class="font-weight-bold">Capabilities</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="capabilities-input"
                                    placeholder="Type and click add" @if(session()->has('id')){{'disabled'}}@endif>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="capabilities-add"
                                    @if(session()->has('id')){{'disabled'}}@endif>Add</button>
                                <button type="button" class="btn btn-primary" id="capabilities-remove"
                                    @if(session()->has('id')){{'disabled'}}@endif>Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: -2em;">
                    <div class="col-sm-2 col-form-label align-self-center">
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="capabilities" multiple size="5" name="capabilities[]"
                            @if(session()->has('id')){{'disabled'}}@endif>
                            @if(session()->has('capabilities'))
                            @foreach (session('capabilities') as $cap)
                            <option value="{{ $cap }}">{{ $cap }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="distance" class="font-weight-bold">Distance from PCC</label>
                        <small class="text-secondary" style=" display: block">(optional)</small>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="number" class="form-control" id="distance" name="distance"
                            value="@if(session()->has('distance')){{ session('distance') }}@endif" step="any" min="0"
                            placeholder="miles" @if(session()->has('id')){{'disabled'}}@endif>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="cost" class="font-weight-bold">Cost&nbsp;<span class="text-danger">*</span></label>
                        <small class="text-secondary" style=" display: block">(USD)</small>
                    </div>
                    <div class="form-row align-items-center">
                        <div class="ml-3 col-auto">
                            <input type="number" class="form-control mb-2" id="cost" name="cost"
                                value="@if(session()->has('cost')){{ session('cost') }}@endif" step="any" min="0"
                                placeholder="$" @if(session()->has('id')){{'disabled'}}@endif required>
                        </div>
                        <div class="col-auto">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">per&nbsp;<span class="text-danger">&nbsp;*</span>
                                    </div>
                                </div>
                                <select class="form-control" id="unit-cost" name="unit-cost"
                                    data-prev_id="@if(session()->has('unit_cost')){{ session('unit_cost') }}@endif"
                                    @if(session()->has('id')){{'disabled'}}@endif>
                                </select>
                            </div>
                        </div>
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
<script src="{{ asset('js/create_resource.js') }}"></script>
@endsection
