@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <form action="{{ route('resource.update', $resource->id) }}" method="POST" id="res-create-form">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col">
                        <h4 class="font-weight-bolder">{{ $title }}</h4>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Resource ID</span>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center" id="resource-id">{{ $resource->id }}</div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <span class="font-weight-bold">Owner</span>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center" id="resource-id">
                        {{ $resource->user->name }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="resource-name"
                        class="col-sm-2 col-form-label align-self-center font-weight-bold">Resource Name&nbsp;<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <input type="text" class="form-control" id="resource-name" name="resource-name"
                            value="{{ $resource->name }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="primary-function" class="font-weight-bold">Primary Function</label>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="primary-function" name="primary-function"
                            data-prev_id="{{ $resource->pri_func_id }}">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="secondary-function" class="font-weight-bold">Secondary Function</label>
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="secondary-function" name="secondary-function"
                            data-prev_id="{{ $resource->sec_func_id }}">
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
                            value="{{ $resource->description }}">
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
                                    placeholder="Type and click add">
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="capabilities-add">Add</button>
                                <button type="button" class="btn btn-primary" id="capabilities-remove">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: -2em;">
                    <div class="col-sm-2 col-form-label align-self-center">
                    </div>
                    <div class="col-sm-10 col-form-label align-self-center">
                        <select class="form-control" id="capabilities" multiple size="5" name="capabilities[]">
                            @if(isset($resource->capabilities))
                            @foreach ($resource->capabilities as $cap)
                            <option value="{{ $cap->name }}">{{ $cap->name }}</option>
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
                            value="{{ $resource->distance }}" step="any" min="0" placeholder="miles">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-form-label align-self-center">
                        <label for="cost" class="font-weight-bold">Cost&nbsp;<span class="text-danger">*</span></label>
                        <small class="text-secondary" style=" display: block">(USD)</small>
                    </div>
                    <div class="form-row col-form-label align-self-center align-items-center">
                        <div class="ml-3 col-auto">
                            <input type="number" class="form-control mb-2" id="cost" name="cost"
                                value="{{ $resource->cost }}" step="any" min="0" placeholder="$" required>
                        </div>
                        <div class="col-auto">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">per&nbsp;<span class="text-danger">&nbsp;*</span>
                                    </div>
                                </div>
                                <select class="form-control" id="unit-cost" name="unit-cost"
                                    data-prev_id="{{ $resource->unit_cost_id }}">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm text-right">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary">Back</a>
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
