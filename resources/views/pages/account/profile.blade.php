@extends('pages.account.container')

@section('pages')
<div class="card">
    <div class="card-header"><h4>Profile</h4></div>

    <div class="card-body">
        <profile-component></profile-component>
        {{-- <form method="POST" action="{{ route('account_profile_save') }}">
            @csrf
            <input type="hidden" name="userid" value="{{ encrypt(Auth::user()->id) }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">{{ __('Firstname') }}</label>
                        <input type="text"
                            class="form-control" name="firstname" id="firstname" value="{{ Auth::user()->firstname }}" aria-describedby="firstname">
                        @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_contactnum">{{ __('Contact number') }}</label>
                        <input type="text"
                            class="form-control" name="user_contactnum" id="user_contactnum" value="{{ Auth::user()->user_contactnum }}" aria-describedby="user_contactnum">
                        @error('user_contactnum')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">{{ __('Lastname') }}</label>
                        <input type="text"
                            class="form-control" name="lastname" id="lastname" value="{{ Auth::user()->lastname }}" aria-describedby="lastname">
                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </form> --}}
    </div>
</div>
@endsection
