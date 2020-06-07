@extends('layouts.app')

@section('content')
<div class="container">
    <p>{{ auth()->user() }}</p>
    <chat-component prop-user="{{ auth()->user() }}"></chat-component>
</div>
@endsection
