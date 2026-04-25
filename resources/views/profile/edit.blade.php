@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-lg bg-white p-4 shadow sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
