@extends('layouts.app')
@push('css')

    <style>
        .profilePic {
            padding: 5px;
            border: solid 1px #bccdfa;
            height: 160px;
            width: 150px;
        }

        .profilePic img{
            border: solid 2px #dde2f3;
            height: 150px;
            width: 140px;
        }
    </style>
@endpush

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title">New Event</h3>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Event</a></li>
                            <li class="breadcrumb-item active">New Event</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="users-list-wrapper">
                    <form action="{{ route('event.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">New Event</h4>
                                        <div class="heading-elements">
                                            <a type="button" href="{{ route('event.record') }}" class="btn btn-sm btn-icon btn-info"><i class="fa fa-server"></i> Event List</a>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group @error('title') has-error @enderror">
                                                        <label for="title" class="label-control required">Event Title</label>
                                                        <input type="text" name="title" id="title" class="form-control  @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Ex. The Cricket" required>
                                                        @error('title')
                                                            <p class="help-block">{{ $errors->first('title') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group @error('event_date_time') has-error @enderror">
                                                        <label for="title_bn" class="label-control required">Event Date</label>
                                                        <div class="input-group date" id="datetimepicker1">
                                                            <input type="text" name="event_date_time" id="event_date_time" class="form-control @error('event_date_time') is-invalid @enderror" value="{{ old('event_date_time') }}" required/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @error('event_date_time')
                                                            <p class="help-block">{{ $errors->first('event_date_time') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group @error('status') has-error @enderror">
                                                        <label for="status" class="label-control required">Status</label>
                                                        <select name="status" id="status" class="form-control  @error('status') is-invalid @enderror" required>
                                                            <option value="1">Active</option>
                                                            <option value="2">In-Active</option>
                                                        </select>
                                                        @error('status')
                                                            <p class="help-block">{{ $errors->first('status') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group @error('details') has-error @enderror">
                                                        <label for="detail" class="label-control required">Event Detail</label>
                                                        <textarea name="details" id="details" cols="30" rows="10" class="form-control  @error('details') is-invalid @enderror" required>{{ old('details') }}</textarea>
                                                        @error('details')
                                                            <p class="help-block">{{ $errors->first('details') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="cal-md-2">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('app-assets/js/scripts/pickers/dateTime/bootstrap-datetime.js') }}"></script>
@endpush
