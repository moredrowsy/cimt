@isset($view)
<div class="container">
    <div class="card mt-3 mb-3 text-black-50"
        style="background: none; border: none;  border-bottom: 1px solid lightgray;">
        <div class="ml-auto text-right">
            <div class="font-weight-bold">
                {{$view['role']}}
            </div>
            <div>
                {{$view['body']}}
            </div>
            <div>
                @if( isset($requests['requesters']) && $requests['requesters'])
                <div class="">
                    <a href="{{ route('res-inc-requests.index') }}">Outbound requests: <span class="text-danger">{{ $requests['requesters']}}</span></a>
                </div>
                @endif
                @if( isset($requests['requestees']) && $requests['requestees'])
                <div>
                    <a href="{{ route('res-inc-requests.index') }}">Inbound requests: <span class="text-danger">{{ $requests['requestees']}}</span></a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endisset
