@extends('layouts.app')
@push('css')

@endpush

@section('content')
    <style>
        .dash-brand-logo{
            height: 100px;
            width: auto;
        }
    </style>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="users-list-wrapper">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="media">
                                            <div class="media-left pr-1">
                                                <img class="media-object img-xl" src="{{ asset('img/No_profile-image.png') }}" alt="Generic placeholder image">
                                            </div>
                                            <div class="media-body">
                                                <h6 class="text-bold-500 pt-1 mb-0">{{ auth()->user()->name }}</h6>
                                                <h6 class="text-bold-500 pt-1 mb-0">{{ auth()->user()->user_type }} account</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-primary bg-darken-2">
                                            <i class="icon-camera font-large-2 white"></i>
                                        </div>
                                        <div class="p-2 bg-gradient-x-primary white media-body">
                                            <h5>Upcoming Events</h5>
                                            <h5 class="text-bold-400 mb-0"><i class="feather icon-plus"></i> {{ $activeEvents }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-danger bg-darken-2">
                                            <i class="icon-basket-loaded font-large-2 white"></i>
                                        </div>
                                        <div class="p-2 bg-gradient-x-danger white media-body">
                                            <h5>Complete Events</h5>
                                            <h5 class="text-bold-400 mb-0"><i class="feather icon-arrow-up"></i> {{ $completeEvents }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-warning bg-darken-2">
                                            <i class="icon-user font-large-2 white"></i>
                                        </div>
                                        <div class="p-2 bg-gradient-x-warning white media-body">
                                            <h5>Current Guest</h5>
                                            <h5 class="text-bold-400 mb-0"><i class="feather icon-arrow-down"></i> {{ $eventGuests }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection


@push('js')


@endpush
