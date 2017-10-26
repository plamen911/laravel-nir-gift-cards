@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sage Payment Gateway</h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}"> Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-money"></i> Payment Gateway
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::open(['route' => 'admin.payment-gateway', 'class' => 'form-horizontal']) }}
                <div class="form-group">
                    <label class="control-label col-sm-4" for="merchant_id">Merchant ID<em class="text-danger">*</em></label>
                    <div class="col-sm-8">
                        {!! Form::text('merchant_id', $result[0]->value, ['class' => 'form-control', 'id' => 'merchant_id', 'placeholder' => 'Merchant ID']) !!}
                        <span class="text-danger">{{ $errors->first('merchant_id') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="merchant_key">Merchant Key<em class="text-danger">*</em></label>
                    <div class="col-sm-8">
                        {!! Form::text('merchant_key', $result[1]->value, ['class' => 'form-control', 'id' => 'merchant_key', 'placeholder' => 'Merchant Key']) !!}
                        <span class="text-danger">{{ $errors->first('merchant_key') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="developer_id">Developer ID<em class="text-danger">*</em></label>
                    <div class="col-sm-8">
                        {!! Form::text('developer_id', $result[2]->value, ['class' => 'form-control', 'id' => 'developer_id', 'placeholder' => 'Developer ID']) !!}
                        <span class="text-danger">{{ $errors->first('developer_id') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="developer_key">Developer Key<em class="text-danger">*</em></label>
                    <div class="col-sm-8">
                        {!! Form::text('developer_key', $result[3]->value, ['class' => 'form-control', 'id' => 'developer_key', 'placeholder' => 'Developer Key']) !!}
                        <span class="text-danger">{{ $errors->first('developer_key') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="test_ccard">Test Credit Number<em class="text-danger">*</em></label>
                    <div class="col-sm-8">
                        {!! Form::number('test_ccard', $result[4]->value, ['class' => 'form-control', 'id' => 'test_ccard', 'placeholder' => 'Test Credit Card Number']) !!}
                        <span class="text-danger">{{ $errors->first('test_ccard') }}</span>
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
