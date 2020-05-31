@extends('pages.account.container')

@section('pages')
<div class="card">
    <div class="card-header">Order View</div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <homework-order-view-chat-component prop-order-id="{{ $request }}"></homework-order-view-chat-component>
            </div>
            <div class="col-md-4">
                <homework-order-view-timer-component prop-order-id="{{ $request }}"></homework-order-view-timer-component>
            </div>
        </div>
    </div>
</div>
@endsection
