@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Admin Dashboard')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Users</h4>
                            <p class="card-category"> Here you can manage users</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="#" class="btn btn-sm btn-primary">Add user</a>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="table-responsive" style="max-width: 100%">
                                <table class="table table-bordered table-striped" id="user_list_admin">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger">
                        <span style="font-size:18px;">
                        <b> </b> This is a PRO feature!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

      var SITEURL = '{{URL::to('')}}';
      // Call AJAX for listing roles

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var table = $('#user_list_admin').DataTable({
        processing: true,
        serverSide: true,
        ajax: SITEURL+'/home',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name' , orderable: true, searchable: true},
            {data: 'email', name: 'email' , orderable: true, searchable: true},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('body').on('click', '.deleteUser', function (){
        var id = $(this).data("id");
        var result = confirm("Are You sure want to delete !");
        if(result){
            $.ajax({
                type: "DELETE",
                url: "delete-user"+'/'+id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }else{
            return false;
        }
    });

    $('body').on('click', '.blockUser', function (){
        var id = $(this).data("id");
        var result = confirm("Are You sure want to block !");
        if(result){
            $.ajax({
                type: "GET",
                url: "block-user"+'/'+id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }else{
            return false;
        }
    });
    });
  </script>
@endpush