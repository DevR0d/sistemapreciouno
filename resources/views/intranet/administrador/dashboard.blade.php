@extends('intranet/layout')
@section('title', 'Dashboard')

@section('hideSearchBar', true)
@section('content')
    <div class="enable-scroll">
        @livewire('dashboard.dashboard')
    </div>
@endsection
