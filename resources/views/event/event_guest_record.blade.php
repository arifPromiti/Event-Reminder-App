@extends('layouts.app')
@push('css')

@endpush

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title">Event Guest List</h3>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Event</a></li>
                            <li class="breadcrumb-item active">Event Guest List</li>
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
                                                    <label for="searchData">Guest name/ Email / Reminder ID</label>
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
                                    <h4 class="card-title">Event Guest List</h4>
                                    <div class="heading-elements">
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('event.guest.create') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group @error('event_id') has-error @enderror">
                                                        <select name="event_id" id="event_id" class="form-control  @error('event_id') is-invalid @enderror" required>
                                                            <option value="">Select Event</option>
                                                            @forelse($events as $row)
                                                                <option value="{{ $row->id }}">{{ $row->title.' ['.$row->reminder_id.']' }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @error('event_id')
                                                            <p class="help-block">{{ $errors->first('event_id') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group @error('guest_name') has-error @enderror">
                                                        <input type="text" name="guest_name" id="guest_name" class="form-control  @error('guest_name') is-invalid @enderror" value="{{ old('guest_name') }}" placeholder="Guest Name Ex. Arif Ahmmad" required>
                                                        @error('guest_name')
                                                            <p class="help-block">{{ $errors->first('guest_name') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group @error('guest_email') has-error @enderror">
                                                        <input type="email" name="guest_email" id="guest_email" class="form-control  @error('guest_email') is-invalid @enderror" value="{{ old('guest_email') }}" placeholder="Guest Email Ex. arif.ahmmad.dip@gmail.com" required>
                                                        @error('guest_email')
                                                            <p class="help-block">{{ $errors->first('guest_email') }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-success mb-0 ps-container ps-theme-default" id="datatable">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Reminder Id</th>
                                                    <th>Guest Name</th>
                                                    <th>Guest Email</th>
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
                    'url': "{{ route('event.guest.record.data') }}",
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
                    { data: "guest_name", 'orderable': false },
                    { data: "guest_email", 'orderable': false, 'className': 'text-center'  },
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
                url: "{{ route('event.guest.delete') }}",
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
