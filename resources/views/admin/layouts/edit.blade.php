@extends('admin.layouts.master')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <h2 class="page-title">
                    @yield('title')
                </h2>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="box">
            <div class="card">
                @yield('form')
            </div>
        </div>
    </div>
@endsection


@section('styles')
    <link href="/resources/admin/libs/selectize/dist/css/selectize.css" rel="stylesheet"/>
    <link href="/resources/admin/libs/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
    <link href="/resources/admin/libs/nouislider/distribute/nouislider.min.css" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="/resources/admin/libs/autosize/dist/autosize.min.js"></script>
    <script src="/resources/admin/libs/imask/dist/imask.min.js"></script>
    <script src="/resources/admin/libs/selectize/dist/js/standalone/selectize.min.js"></script>
    <script src="/resources/admin/libs/flatpickr/dist/flatpickr.min.js"></script>
    <script src="/resources/admin/libs/flatpickr/dist/plugins/rangePlugin.js"></script>
    <script src="/resources/admin/libs/nouislider/distribute/nouislider.min.js"></script>
    <script>
        $(document).ready(function () {
            $('select').selectize();
        });
    </script>
@endsection
