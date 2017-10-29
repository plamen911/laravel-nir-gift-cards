@extends('layouts.master')

@section('content')
    <p>This secure online form makes it easy for you to order and deliver your Gift Card. Orders totaling up to $5,000, can be made using a single order form. After your order is processed, a confirmation page will provide a tracking number, and a detailed receipt will be sent to you by email.</p>
    <h2>Step 2 - Delivery Information</h2>
    <p>Please complete the address information below. We will load the requested gift card with the selected dollar value and send it via your preferred shipping method to the address indicated. In addition, by completing the recipient's email address, we will promptly send your personalized message with notification of the gift card purchased. We know any recipient will be thrilled and pleased to be remembered!</p>
    <i>Note: Fields marked with <span id="mandatory">*</span> are mandatory.</i>
    <h3>Gift Card {{ $index + 1 }} of {{ $giftCard->quantity }}</h3>

    {{--@include('layouts.errors')--}}

    {{ Form::open(['url' => 'buy-gift-cards/' . $address->card_id . '/address/' . $index]) }}
        {!! Form::hidden('delivery_id', $giftCard->delivery_id) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('recipient', '* Recipient\'s Name:') !!}
                    {!! Form::text('recipient', $address->recipient, ['class'=>'form-control', 'id' => 'recipient']) !!}
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::label('email', '* Recipient\'s Email:') !!}
                    {!! Form::email('email', $address->email, ['class'=>'form-control', 'id' => 'email']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::label('message', 'Personalized Message for Recipient:') !!}
                    {!! Form::text('message', $address->message, ['class'=>'form-control', 'id' => 'message']) !!}
                    <span class="text-danger">{{ $errors->first('message') }}</span>
                </div>
                @if (!$giftCard->isECertificate())
                    <div class="form-group">
                        {!! Form::label('address', '* Shipping Address 1:') !!}
                        {!! Form::text('address', $address->address, ['class'=>'form-control', 'id' => 'address']) !!}
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    </div>
                    <div class="form-group">
                        {!! Form::label('address2', 'Shipping Address 2:') !!}
                        {!! Form::text('address2', $address->address2, ['class'=>'form-control', 'id' => 'address2']) !!}
                        <span class="text-danger">{{ $errors->first('address2') }}</span>
                    </div>
                    <div class="form-group">
                        {!! Form::label('city', '* City:') !!}
                        {!! Form::text('city', $address->city, ['class'=>'form-control', 'id' => 'city']) !!}
                        <span class="text-danger">{{ $errors->first('city') }}</span>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                @if (!$giftCard->isECertificate())
                    <div class="form-group">
                        {!! Form::label('state', '* State:') !!}
                        {!! Form::text('state', $address->state, ['class'=>'form-control', 'id' => 'state']) !!}
                        <span class="text-danger">{{ $errors->first('state') }}</span>
                    </div>
                    <div class="form-group">
                        {!! Form::label('zip', '* Zip Code:') !!}
                        {!! Form::text('zip', $address->zip, ['class'=>'form-control', 'id' => 'zip']) !!}
                        <span class="text-danger">{{ $errors->first('zip') }}</span>
                    </div>
                    <div class="form-group">
                        {!! Form::label('country', '* Country:') !!}
                        {!! Form::select('country', $countriesArray, $address->country, ['class'=>'form-control', 'id' => 'country']) !!}
                        <span class="text-danger">{{ $errors->first('country') }}</span>
                    </div>

                    @if (!$giftCard->isECertificate())
                        <div class="form-group">
                            {!! Form::label('shipping_id', 'Shipping Method:') !!}
                            {!! Form::select('shipping_id', $shippingMethodsArray, $giftCard->shipping_id, ['class'=>'form-control', 'id' => 'shipping_id']) !!}
                            <span class="text-danger">{{ $errors->first('shipping_id') }}</span>
                            <p id="shippingMethodNote" class="help-block">
                                <i>Note: International shipping will be calculated when the gift card is mailed.</i>
                            </p>
                        </div>
                    @endif

                @endif
            </div>
        </div>
        <div class="form-group">
            <a href="{!! $prevUrl !!}" class="btn btn-default">
                <span class="glyphicon glyphicon-chevron-left"></span> Back
            </a>
            <button type="submit" class="btn btn-primary">
                Next <span class="glyphicon glyphicon-chevron-right"></span>
            </button>
        </div>
    {{ Form::close() }}
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order Summary</h3>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Item</div>
                            <div class="col-sm-6">Gift Card</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Quantity</div>
                            <div class="col-sm-6">{{ $giftCard->quantity }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Amount</div>
                            <div class="col-sm-6">${{ number_format($giftCard->amount * $giftCard->quantity, 2) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Delivery Type</div>
                            <div class="col-sm-6">{{ $giftCard->deliveryTypes()->first()->name }}</div>
                        </div>
                    </li>
                    @if (!$giftCard->isECertificate())
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Delivery Method</div>
                                <div class="col-sm-6">{{ $giftCard->sendto_name }}</div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            (function () {
                function handleShipping() {
                    var targetElem = $('#shippingMethodNote');
                    if ($('#shipping_id option:selected').text().indexOf('International Shipping') !== -1) {
                        targetElem.css('display', 'block');
                    } else {
                        targetElem.css('display', 'none');
                    }
                }
                handleShipping();
                $('#shipping_id').change(handleShipping);
            })();
        });
    </script>
@endpush