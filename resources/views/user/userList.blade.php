@extends('layouts.app')

@push('css')

@endPush

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title">Users List</h3>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users List</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- users list start -->
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
                                                    <label for="searchData">Users Name/ Email</label>
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
                                    <h4 class="card-title">User List</h4>
                                    <div class="heading-elements">
                                        <a type="button" href="javascript:addUser();" class="btn btn-sm btn-icon btn-success"><i class="fa fa-paper-plane"></i> Add New User</a>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-success mb-0 ps-container ps-theme-default" id="datatable">
                                                <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Password</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade text-left" id="userAddForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning white">
                                            <h4 class="modal-title"><i class="fa-solid fa-user"></i> User Form</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="userForm" action="">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="name">Full Name</label>
                                                            <input type="text" name="name" id="name" placeholder="Full Name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" name="email" id="email" placeholder="Email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div id="passwordSection" class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="password">Password </label>
                                                            <label class="red" for="password">( Minimum 6 character need )</label>
                                                            <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                                            <a type="button" id="submitFrom" href="javascript:saveUser();" class="btn btn-warning"><i class="fa-solid fa-paper-plane"></i> Save</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endSection

@push('js')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/page-users.js') }}"></script>
    <!-- END: Page JS-->

    <script>
        var actionUrl = '';

        $(function(){
            $('#datatable').DataTable({
                'processing'   : true,
                'serverSide'   : true,
                'bFilter'      : false,
                'bLengthChange': false,
                'ajax': {
                    'type': 'POST',
                    'url': "{{ route('user.record.data') }}",
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
                    { data: "name", 'orderable': false },
                    { data: "email", 'orderable': false },
                    { data: "view_password", 'orderable': false },
                    { data: "status", 'orderable': false, 'className': 'text-center' },
                    { data: "action", 'orderable': false, 'className': 'text-center' }
                ],
                'order': [[0, 'desc']]
            });
        });

        function addUser(){
            $("#userForm").trigger('reset');
            $('#submitFrom').removeAttr('disabled');
            $('#passwordSection').show();
            actionUrl = '{{ route("user.create") }}';
            $('#userAddForm').modal('show');
        }

        function editUser(id){
            $("#userForm").trigger('reset');
            $('#submitFrom').removeAttr('disabled');
            let url = '{{ route("user.info", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(data){
                    $('#name').val(data.name);
                    $('#email').val(data.email);

                    $('#passwordSection').hide();

                    actionUrl = '{{ route("user.update", ":id") }}';
                    actionUrl = actionUrl.replace(':id', id);

                    $('#userAddForm').modal('show');
                }
            });
        }

        function reloadTable(){
            $('#userList').DataTable().ajax.reload();
        }

        function saveUser(){
            $('#submitFrom').attr('disabled', 'disabled');
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                type    : "POST",
                url     : actionUrl,
                data    : {
                    'name'    : name,
                    'email'   : email,
                    'password': password,
                },
                dataType: "json",
                success :function(data){
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
                        $('#userAddForm').modal('hide');
                    }else if(data.error){
                        swal({
                            title            : "Sorry !",
                            text             : data.error,
                            type             : "error",
                            showCancelButton : false,
                            showConfirmButton: false,
                            timer            : 3000,
                        });
                        $('#submitFrom').removeAttr('disabled');
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
                        $('#submitFrom').removeAttr('disabled');
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
                    $('#submitFrom').removeAttr('disabled');
                }
            });
        }
    </script>


@endPush
