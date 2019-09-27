@extends('backend.layout.app')
@section('title') -
<?php echo
$title = ucfirst(explode(".",Request::route()->getName())[0]); ?>
@endsection

@section('styleFile')
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">
@endsection

{{-- style code --}}
@section('style')
@endsection

@section('content')

<section class="content-header">
    @include("backend.partials.flash-message")
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $title }} List</h3>
            @can('user-create')
            <a href="{{ route('users.create') }}" class="btn btn-success pull-right" >
                <i class="ft-plus"></i>
                Add
            </a>
            @endcan
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="data_table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>EMail</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.box-body -->
        <!-- Delete Data Confirem Modal  -->
        <div id="confirmModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Confirmation</h2>
                    </div>
                    <div class="modal-body">
                        <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="ok_button" id="btn_ok_delete" class="btn btn-danger">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
@endsection

@section('scriptFile')
<!-- yajra package -->
@include('backend.includes.yajra_datatabel')
@endsection

@section('footerScript')
<!-- page script -->
<script type="text/javascript">

    $(document).ready(function() {
        var URL = "{{ route('users.getData') }}";
        var _DataTable =  $('#data_table').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth" : true,
            "lengthMenu": [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'All' ]
            ],
            "order": [[2, 'desc']],
            "ajax": URL,
            "columns": [
            {data: 'name'},
            {data: 'email'},
            {data: 'role'},
            {data: 'action', orderable: false, searchable: false}
            ],
            dom: 'lBfrtip<"actions">',
            buttons: [
            {
                extend: 'copy',
                text: "<span class='fa fa-clipboard'></span> Copy",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: "<span class='fa fa-file'></span> CSV",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: "<span class='fa fa-file-excel-o'></span> Excel",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                text: "<span class='fa fa-print'></span> Print",
                oSelectorOpts: {
                    page: 'all'
                },
            },
            {
                extend: 'colvis',
                text: "<span class='fa fa-eye'></span> Column Visible",
                exportOptions: {
                    columns: ':visible'
                }
            },
            ]
        });

        _DataTable.buttons().container().appendTo('#data_table_wrapper .col-sm-6:eq(0)' );

    });

    /* DELETE Record using AJAX Requres */
    $(document).on('click', '.delete', function(){
        var id = $(this).data("delete-id");
        var token = $(this).data("token");
        var URL = "users/"+id;
        if(confirm("Are you sure you want to Delete this data?"))
        {
            $.ajax({
                url:URL,
                type: 'POST',
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token
                },
                success:function(data)
                {
                    // alert(data);
                    $('#data_table').DataTable().ajax.reload();
                },
                error: function (request, status, error) {
                    console.log("request "+request);
                }
            })
        }
        else
        {
            return false;
        }
    });

    /* EDit Record using AJAX Requres */
    $(document).on('click', '.edit', function () {
        var id = $(this).data("edit-id");
        var URL = "/bck/users/" +id+"/edit";
        window.location.href = URL;
    });
</script>
@endsection
