@extends('pages.account.container')

@section('pages')
<div class="card">
    <div class="card-header">Homework list</div>

    <div class="card-body">
        <homeworklist-component
            props-route-new="{{ route('account_homework_new') }}"
            props-route-billing="{{ route('account_homework_billing') }}"
            props-route-order-view="{{ route('account_order_view') }}"
        >
        </homeworklist-component>
    </div>
</div>
@endsection
