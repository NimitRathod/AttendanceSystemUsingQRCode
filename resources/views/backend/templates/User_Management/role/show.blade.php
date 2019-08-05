@extends('backend.layout.app')
@section('title') -
<?php echo
$title = ucfirst(explode(".",Request::route()->getName())[0]); ?>
@endsection

@section('styleFile')
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

{{-- style code --}}
@section('style')
@endsection

@section('content')

<section class="content-header">
    @include("backend.partials.success_form_create")
</section>

<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $title }} List</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="data_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Guard Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @if(!empty($data))
                    @foreach ($data as $record)
                    <tr>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->guard_name }}</td>
                        <td>{{ $record->created_at }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @can('role-edit')
                                <a href="{{ route('roles.edit',[$record->id]) }}" class="btn btn-circle btn-info ">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                @endcan

                                @if($record->name != 'super-admin')
                                @can('role-delete')
                                <form id="delete-role-form" action="{{ route('roles.destroy',[$record->id]) }}" method="POST" class="btn btn-circle btn-danger">
                                    @method('DELETE')
                                    @csrf
                                    <a class="btn btn-circle btn-danger btn-xs" >
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </form>
                                @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody> --}}
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('footerScript')
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#data_table').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "ajax": "{{ route('roles.getData') }}",
            "columns": [
            {data: 'name'},
            {data: 'guard_name'},
            {data: 'action', orderable: false, searchable: false}
            ]
        });
    });

    /* DELETE Record using AJAX Requres */
    $(document).on('click', '.delete', function () {
        var id = $(".delete").data("delete-id");
        var token = $(this).data("token");
        var URL = "roles/" + id;

        $('#confirmModal').modal('show');
        $.ajax(
        {
            url: URL,
            type: 'DELETE',
            data: {
                "id": id,
                // "_method": 'DELETE',
                "_token": token,
            },
            beforeSend:function(){
                $('#btn_ok_delete').text('Deleting...');
            },
            success: function (result) {
                alert("result "+result);
                console.log("result "+result);
                setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                }, 2000);
            },
            error: function (request, status, error) {
                console.log("request "+request);
                // var val = request.responseText;
                // alert("error" + val);
            }
        });
    });

    /* EDit Record using AJAX Requres */
    $(document).on('click', '.edit', function () {
        var id = $(this).data("edit-id");
        var URL = "/bck/roles/" +id+"/edit";
        window.location.href = URL;
    });
</script>
@endsection
