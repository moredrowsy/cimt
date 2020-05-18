@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md">
            @if(isset($incident) && $incident)
            <div class="row">
                <div class="col-sm-3 mt-2 mb-2 align-self-center">
                    <span class="font-weight-bold">Incident ID</span>
                </div>
                <div class="col-sm-5 mt-2 mb-2 align-self-center" id="resource-id">
                    {{ $incident->id }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mt-2 mb-2 align-self-center">
                    <span class="font-weight-bold">Owner</span>
                </div>
                <div class="col-sm-5 mt-2 mb-2 align-self-center" id="resource-id">
                    {{ $incident->user->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mt-2 mb-2 align-self-center">
                    <span for="name" class="font-weight-bold">Category</span>
                </div>
                <div class="col-sm-5 mt-2 mb-2 align-self-center">
                    {{ $incident->category->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mt-2 mb-2 align-self-center">
                    <span for="primary-function" class="font-weight-bold">Date</span>
                </div>
                <div class="col-sm-5 mt-2 mb-2 align-self-center">
                    {{ $incident->date }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mt-2 mb-2 align-self-center">
                    <span for="description" class="font-weight-bold">Description</>
                </div>
                <div class="col-sm-5 mt-2 mb-2 align-self-center">
                    @if(isset($incident->description))
                    {{ $incident->description }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm mt-2 mb-2 text-left align-self-center">
                    @if($user_id == $incident->user->id)
                    <form action="{{ route('incident.destroy', $id) }}" method="POST" id="inc-destroy-form">
                        @csrf
                        @method('DELETE')

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            Delete
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalTitle">Confirm Delete Resource</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure want to delete this resource?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-primary">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
                <div class="col-sm mt-2 mb-2 text-right align-self-center">
                    <a href="{{ URL::previous() }}" class="btn btn-secondary">Back</a>
                    @if($user_id == $incident->user->id)
                    <a href="{{ route('incident.edit', $id) }}" class="btn btn-primary">Update</a>
                    @endif
                </div>
            </div>
            @else
            <div class="font-weight-bold text-center">
                Can not find resource @if(isset($id)) ID of {{ $id }}@endif.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/common.js') }}"></script>
@endsection
