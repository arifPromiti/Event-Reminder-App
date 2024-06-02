@extends('layouts.app')
@push('css')

@endpush

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title">Event List</h3>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Event</a></li>
                            <li class="breadcrumb-item active">Event List</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="users-list-wrapper">
                    <div class="row match-height">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Filter</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse">
                                    <div class="card-body">
                                        <form id="filterForm">
                                            <div class="row">
                                                <div class="col-md-3 form-group">
                                                    <label for="searchData">Event Title</label>
                                                    <input type="text" class="form-control" name="searchData" id="searchData">
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="">Select One</option>
                                                        <option value="1">Active</option>
                                                        <option value="2">In-Active</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12" align="right">
                                                    <a type="button" href="javascript:resetDt();" class="btn btn-warning"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a>
                                                    <a href="javascript:reloadTable();" type="button" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i> Search</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Event List</h4>
                                    <div class="heading-elements">
                                        <a type="button" href="{{ route('event.add') }}" class="btn btn-sm btn-icon btn-success"><i class="fa fa-paper-plane"></i> Add New Event</a>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('event.import.csv') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="file" name="file" class="form-control" accept=".csv">
                                                            <div class="input-group-append">
                                                                <span class="input-group-button">
                                                                    <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Upload CSV</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <a type="button" href="{{ asset('event_csv.csv') }}" class="btn btn-info" download><i class="fa fa-download"></i> Download CSV File Format</a>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-success mb-0 ps-container ps-theme-default" id="datatable">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Reminder Id</th>
                                                    <th>Event</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
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
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/page-users.js') }}"></script>
    <!-- END: Page JS-->

    <script>
        $(document).ready(function(){
            $('#datatable').DataTable({
                'processing'   : true,
                'serverSide'   : true,
                'bFilter'      : false,
                'bLengthChange': false,
                'ajax': {
                    'type': 'POST',
                    'url': "{{ route('event.record.data') }}",
                    'data':function (d) {
                        d.searchData = $('#searchData').val();
                        d.status     = $('#status').val();
                        d._token     = '{{ csrf_token() }}';
                    },
                    beforeSend: function() {
                        $('#searchButton').html(
                            '<i class="loader fa fa-refresh"></i> Search');
                    },
                    complete: function() {
                        $('#searchButton').html('<i class="fa fa-search"></i> Search');
                    }
                },
                'columns': [
                    { data: "id", 'visible': false },
                    { data: "reminder_id", 'orderable': false },
                    { data: "title", 'orderable': false },
                    { data: "event_date_time", 'orderable': false, 'className': 'text-center'  },
                    { data: "status", 'orderable': false, 'className': 'text-center' },
                    { data: "action", 'orderable': false, 'className': 'text-center' }
                ],
                'order': [[0, 'desc']]
            });
        });

        function reloadTable(){
            $('#datatable').DataTable().ajax.reload();
        }

        function resetDt() {
            $('#filterForm').trigger("reset");
            reloadTable();
        }

        function deleteData(id){
            $.ajax({
                type: "POST",
                url: "{{ route('event.delete') }}",
                data    : {
                    'id'    : id,
                    '_token':'{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(data){
                    console.log(data);
                    if(data.success){
                        swal({
                            title            : "Success !",
                            text             : data.success,
                            type             : "success",
                            showCancelButton : false,
                            showConfirmButton: false,
                            timer            : 3000,
                        });
                        reloadTable();
                    }else if(data.error){
                        swal({
                            title            : "Sorry !",
                            text             : data.error,
                            type             : "error",
                            showCancelButton : false,
                            showConfirmButton: false,
                            timer            : 3000,
                        });
                    }else{
                        console.log(data.v_error);
                        swal({
                            title            : "Sorry !",
                            text             : data.msg,
                            type             : "warning",
                            showCancelButton : false,
                            showConfirmButton: false,
                            timer            : 3000,
                        });
                    }
                },error :function(data){
                    swal({
                        title            : "Sorry !",
                        text             : "This option is unavailable right now. Please contract solvers.",
                        type             : "warning",
                        showCancelButton : false,
                        showConfirmButton: false,
                        timer            : 3000,
                    });
                }
            });
        }

    </script>

@endpush
