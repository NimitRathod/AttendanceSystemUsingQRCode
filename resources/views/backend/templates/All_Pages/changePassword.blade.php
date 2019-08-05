@extends('backend.layout.app')
@section('title') -
<?php
$title = ucfirst(explode(".",Request::route()->getName())[0]);
echo $title;
?>

@endsection

@section('styleFile')

@endsection

{{-- style code --}}
@section('style')
<style>

</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    @include("backend.partials.form_error_alert")
</section>
<!-- Main content -->
<section class="content">

    <!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}
            Change Password</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('users.store')  }}" method="POST">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Current Password:</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="current" name="current" placeholder="Enter Current">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">New Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Enter New Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">Password Confirmation:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Re Enter Password" >
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{ route('users.index') }}" class="btn btn-danger">
                    Cancel
                </a>
                <button class="btn btn-primary pull-right">
                    {{ 'Submit' }}
                </button>
            </div>

        </form>
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection

@section('scriptFile')
{{-- Data Table js --}}
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
@endsection

@section('footerScript')

@endsection
