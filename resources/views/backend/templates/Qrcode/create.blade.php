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
        {!! $qr !!}
        {{-- {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!} --}}
        <!-- form start -->
    </div>

</section>
<!-- /.content -->
@endsection

@section('scriptFile')
@endsection

@section('footerScript')
@endsection
