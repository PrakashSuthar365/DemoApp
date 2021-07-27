@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('User Dashboard')])

@section('content')
    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>
                <p class="card-category">Used Space</p>
                <h3 class="card-title">49/50
                    <small>GB</small>
                </h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                    <i class="material-icons text-danger">warning</i>
                    <a href="#pablo">Get More Space...</a>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">store</i>
                </div>
                <p class="card-category">Revenue</p>
                <h3 class="card-title">$34,245</h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                </div>
                <p class="card-category">Fixed Issues</p>
                <h3 class="card-title">75</h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">local_offer</i> Tracked from Github
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-twitter"></i>
                </div>
                <p class="card-category">Followers</p>
                <h3 class="card-title">+245</h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">update</i> Just Updated
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Product ToDo</h4>
                        <p class="card-category">Ajax CRUD Tutorial Using Datatable                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered data-table" style="max-width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Details</th>
                                            <th width="280px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Details</label>
                                <div class="col-sm-12">
                                    <textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-left:16px;">
                                <input type="file" class="form-control" id="image" name="image" required="">
                            </div>
                            <div class="col-sm-12 pull-right">
                                <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                    alt="preview image" style="max-height: 250px;">
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary float-right" id="saveBtn" value="create">Save changes</button>
                            </div>
                        </form>
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

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#image').change(function(){
           let reader = new FileReader();
            reader.onload = (e) => { 
                $('#preview-image').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('ajaxproducts.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'detail', name: 'detail'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
     
        $('#createNewProduct').click(function () {
            $('#saveBtn').val("create-product");
            $('#image').val('');
            $('#name').val('');
            $('#detail').val('');
            $('#product_id').val('');
            // $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#id').val('');
            $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
            $('#ajaxModel').modal('show');
        });
    
        $('body').on('click', '.editProduct', function () {
            var product_id = $(this).data('id');
            $.get("{{ route('ajaxproducts.index') }}" +'/' + product_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#product_id').val(data.id);
                $('#name').val(data.name);
                $('#detail').val(data.detail);
            })
        });
    
        // $('#saveBtn').click(function (e) {
        //     // e.preventDefault();
        //     // $(this).html('Sending..');
        //     $("form[name='productForm']").validate({   //#register-form is form id
        //         // Specify the validation rules
        //         rules: {
        //             name: "required", //firstname is corresponding input name   
        //             detail: "required", //firstname is corresponding input name
        //         },
        //         // Specify the validation error messages
        //         messages: {
        //             name: "Enter Name",
        //             detail: "Enter Detail"
        //         },
        //         submitHandler: function(form) {
        //             $.ajax({
        //                 data: $('#productForm').serialize(),
        //                 url: "{{ route('ajaxproducts.store') }}",
        //                 type: "POST",
        //                 dataType: 'json',
        //                 success: function (data) {
        //                     $('#image').val('');
        //                     $('#name').val('');
        //                     $('#detail').val('');
        //                     $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
        //                     $('#ajaxModel').modal('hide');
        //                     table.draw();
        //                 },
        //                 error: function (data) {
        //                     console.log('Error:', data);
        //                     $('#saveBtn').html('Save Changes');
        //                 }
        //             });
        //         }
        //     });
        // });
        
        $('#productForm').submit(function(e) {
            e.preventDefault();
            var f = $('#FormData');
            var formData = new FormData(f);
            console.log(formData.getAll());
            // $.ajax({
            //     type: 'POST',
            //     url: "{{ url('/uploadfile') }}",
            //     data: formData,
            //     cache: false,
            //     contentType: false,
            //     processData: false,
            //     success: (data) => {
            //         this.reset();
            //         alert('File has been uploaded successfully');
            //         console.log(data);
            //     },
            //     error: function (data) {
            //         console.log(data);
            //     }
            // });
        });

        $('body').on('click', '.deleteProduct', function (){
            var product_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if(result){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('ajaxproducts.store') }}"+'/'+product_id,
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