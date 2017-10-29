@extends('layouts.master')

@section('content')
    <p>This secure online form makes it easy for you to order and deliver your Gift Card. Orders totaling up to $5,000, can be made using a single order form. After your order is processed, a confirmation page will provide a tracking number, and a detailed receipt will be sent to you by email.</p>
    <h2>Step 3 - Complete Your Purchase</h2>
    <p>You're almost done. Please fill out your address as it appears on your credit card and review your order. We'll even send an email confirmation of this order via the email address indicated.</p>
    <i>Note: Fields marked with <span id="mandatory">*</span> are mandatory.</i>

    @include('layouts.errors')

    {{ Form::open(['url' => 'buy-gift-cards/' . $giftCard->id . '/purchase']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group col-sm-6">
                    {!! Form::label('name', '* Name:') !!}
                    {!! Form::text('name', $giftCard->name, ['class'=>'form-control', 'id' => 'name']) !!}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group col-sm-6">
                    {!! Form::label('email', '* Email Receipt To:') !!}
                    {!! Form::email('email', $giftCard->email, ['class'=>'form-control', 'id' => 'email']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('address', '* Billing Address 1:') !!}
                    {!! Form::text('address', $giftCard->address, ['class'=>'form-control', 'id' => 'address']) !!}
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('address2', 'Address 2:') !!}
                    {!! Form::text('address2', $giftCard->address2, ['class'=>'form-control', 'id' => 'address2']) !!}
                    <span class="text-danger">{{ $errors->first('address2') }}</span>
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('city', '* City:') !!}
                    {!! Form::text('city', $giftCard->city, ['class'=>'form-control', 'id' => 'city']) !!}
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('state', '* State:') !!}
                    {!! Form::text('state', $giftCard->state, ['class'=>'form-control', 'id' => 'state']) !!}
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('zip', '* Zip Code:') !!}
                    {!! Form::text('zip', $giftCard->zip, ['class'=>'form-control', 'id' => 'zip']) !!}
                    <span class="text-danger">{{ $errors->first('zip') }}</span>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('country', '* Country:') !!}
                    {!! Form::select('country', $countriesArray, $giftCard->country, ['class'=>'form-control', 'id' => 'country']) !!}
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group col-sm-6">
                    {!! Form::label('cctype', '* Select Credit Card:') !!}
                    {!! Form::select('cctype', $creditCardTypesArray, $giftCard->cctype, ['class'=>'form-control', 'id' => 'cctype']) !!}
                    <span class="text-danger">{{ $errors->first('cctype') }}</span>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('ccnumber', '* Credit Card Number:') !!}
                    {!! Form::number('ccnumber', $giftCard->ccnumber, ['class'=>'form-control', 'id' => 'ccnumber']) !!}
                    <span class="text-danger">{{ $errors->first('ccnumber') }}</span>
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('cvv', '*Security Code:') !!}
                    {!! Form::number('cvv', $giftCard->cvv, ['class'=>'form-control', 'id' => 'cvv']) !!}
                    <span class="text-danger">{{ $errors->first('cvv') }}</span>
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('ccexp_month', '* Exp Month(MM):') !!}
                    {!! Form::number('ccexp_month', $giftCard->ccexp_month, ['class'=>'form-control', 'id' => 'ccexp_month']) !!}
                    <span class="text-danger">{{ $errors->first('ccexp_month') }}</span>
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('ccexp_year', '* Exp Year(YY):') !!}
                    {!! Form::number('ccexp_year', $giftCard->ccexp_year, ['class'=>'form-control', 'id' => 'ccexp_year']) !!}
                    <span class="text-danger">{{ $errors->first('ccexp_year') }}</span>
                </div>
                <div class="form-group col-sm-10">
                    {!! Form::label('phone', 'Phone Number:') !!}
                    {!! Form::number('phone', $giftCard->phone, ['class'=>'form-control', 'id' => 'phone']) !!}
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <p>
                    <strong>Terms & Conditions</strong><br>
                    Use this card for payment of goods and/or services.
                    This card cannot be redeemed for cash and cannot be replaced if lost or stolen.
                    Call 800.475.2637 for Customer Service. This Gift Card is valid at Nantucket Island Resorts' hotels, restaurants, spas, in-hotel gift shops and the marina which include: The Wauwinet, White Elephant, White Elephant Village I Residences & Inn, Jared Coffin House, The Cottages & Lofts, Nantucket Boat Basin, Brant Point Grill, TOPPER'S, White Elephant Spa and The Wauwinet Spa by the Sea. Not valid at the restaurant in Jared Coffin House.  Expires 7 years from purchase date.
                </p>

                <label>{!! Form::checkbox('agree', '1', $giftCard->agree === '1') !!} I agree with 'Terms & Conditions' of Gift Card</label>
                <div class="text-danger">{{ $errors->first('agree') }}</div>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <a href="{!! $prevUrl !!}" class="btn btn-default">
                <span class="glyphicon glyphicon-chevron-left"></span> Back
            </a>
            {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
        </div>
    {{ Form::close() }}
    <hr>
    <div class="alert alert-info">
        <p>Please allow a few seconds once submitting the form for the next page to appear.</p>
        <p>If you receive an error, please call 1-800-ISLANDS (475-2637)</p>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Submit Your Order</h3>
                </div>
                <ul class="list-group">
                    @if ($giftCard->isECertificate())
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Gift Card Amount</div>
                                <div class="col-sm-6">${{ number_format($giftCard->amount * $giftCard->quantity, 2) }}</div>
                            </div>
                        </li>
                    @else
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Shipping Method</div>
                                <div class="col-sm-6">{{ $giftCard->shippingMethod()->first()->name }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Gift Card Amount</div>
                                <div class="col-sm-6">${{ number_format($giftCard->amount * $giftCard->quantity, 2) }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Shipping Charges</div>
                                <div class="col-sm-6">${{ $giftCard->shipping }}</div>
                            </div>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Total</div>
                            <div class="col-sm-6">${{ number_format($giftCard->total, 2) }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
