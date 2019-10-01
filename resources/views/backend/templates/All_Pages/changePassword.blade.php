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
    @include("backend.partials.flash-message")
</section>
<!-- Main content -->
<section class="content">

    <!-- Horizontal Form -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Change Password</h3>
            <span class="pull-right">Your Email is <b>{{ Auth::user()->email}}</b></span>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('change_password.reset')  }}" method="POST">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Current Password:</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="current" name="current" placeholder="Enter Current" tabindex="1">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">New Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Enter New Password" tabindex="2" min="6">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">Password Confirmation:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Re Enter Password" tabindex="3" min="6">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">
                <button class="btn btn-primary">
                    {{ 'Submit' }}
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-danger">
                    Cancel
                </a>
                <div class="col-md-3"></div>
                </div>
            </div>

        </form>
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection

@section('scriptFile')
@endsection

@section('footerScript')

@endsection
