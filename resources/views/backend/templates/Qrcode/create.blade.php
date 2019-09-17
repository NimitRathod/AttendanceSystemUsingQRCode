@extends('backend.layout.app')
@section('title') -
<?php
$title = ucfirst(explode(".",Request::route()->getName())[0]); ?>
@endsection

@section('styleFile')
<!-- Custom styles for this page -->
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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

        {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!}
        <!-- form start -->
    </div>

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
<script>
    // $(document).ready(function(){
        //     alert("Permission");
        // });
    </script>
    @endsection
