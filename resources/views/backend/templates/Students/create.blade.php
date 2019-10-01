@extends('backend.layout.app')
@section('title') -
<?php
$title = ucfirst(explode(".",Request::route()->getName())[0]); ?>
@endsection

@section('styleFile')
@endsection

{{-- style code --}}
@section('style')
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
            <h3 class="box-title">{{  'Create'  }} {{ $title }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('students.store')  }}" method="POST" enctype='multipart/form-data'>
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Students CSV File</label>

                    <div class="col-sm-10">                        
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-md-5">
                 <input type='submit' name='submit' value='Import' class="btn btn-primary pull-right">
             </div>
             <div class="col-md-5">
                <a href="{{ route('students.index') }}" class="btn btn-danger">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

</section>
<!-- /.content -->

@endsection

@section('scriptFile')

@endsection

@section('footerScript')

@endsection
