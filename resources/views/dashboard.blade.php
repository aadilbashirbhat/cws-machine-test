@extends('layouts.admin_app')

@section('title', 'Dashboard')

@section('content')
@includeIf('partials.dashboard_labels')
@endsection

@push('head')
<!-- Additional styles specific to this view -->
@endpush

@push('bottom-scripts')
<!-- Additional scripts specific to this view -->
@endpush
@push('breadcrumb')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><span>Dashboard</span>
            </li>
        </ol>
    </nav>
</div>
@endpush