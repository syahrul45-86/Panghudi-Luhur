@extends('admin.setting.layout')

@section('setting-content')
    <div class="col-12 col-md-9 d-flex flex-column">
        <form action="{{ route('admin.general-settings.update') }}" method="POST">
            <div class="card-body">

                <h3 class="card-title mt-4">Settings</h3>

@endsection
