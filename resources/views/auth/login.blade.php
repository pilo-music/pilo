@extends('admin.layouts.auth')

@section('content')
    <div class="flex-fill d-flex flex-column justify-content-center">
        <div class="container-tight py-6">
            <div class="text-center mb-4">
                <img src="/resources/admin/img/logo.png" height="36" alt="">
            </div>
            <form class="card card-md" action="{{route('login')}}" method="post">
                @csrf
                <div class="card-body">
                    <h2 class="mb-5 text-center">Login to your account</h2>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Password
                            <span class="form-label-description"></span>
                                </label>
                                <div class="input-group input-group-flat">
                                    <input name="password" type="password" class="form-control" placeholder="Password">
                                    <span class="input-group-text">
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input name="remember" type="checkbox" class="form-check-input"/>
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
