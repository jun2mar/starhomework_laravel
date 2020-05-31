@extends('pages.account.container')

@section('pages')
<div class="card">
    <div class="card-header">Homework Payment</div>

    <div class="card-body">
        <homework-template-component prop-unpaid-homework-id="{{ $request }}"></homework-template-component>
    </div>
</div>
@endsection
