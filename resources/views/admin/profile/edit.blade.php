@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Your Profile</h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}"> Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-user"></i> Profile
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::open(['route' => 'admin.profile', 'class' => 'form-horizontal']) }}
            <div class="form-group">
                <label class="control-label col-sm-4" for="name">Name<em class="text-danger">*</em></label>
                <div class="col-sm-8">
                    {!! Form::text('name', $result->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">E-Mail Address<em class="text-danger">*</em></label>
                <div class="col-sm-8">
                    {!! Form::email('email', $result->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'E-Mail Address']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="password">Password</label>
                <div class="col-sm-8">
                    <input id="password" type="password" class="form-control" name="password">
                    <div><em>Enter new password only. Leave blank to use existing password.</em></div>
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            window.setTimeout(function () {
               $('#password').val('');
            }, 100);
        });
    </script>
@endpush
