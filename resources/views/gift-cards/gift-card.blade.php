@extends('layouts.master')

@section('content')
    <h2>Step 1 - Buy Gift Cards</h2>
    <p>Nantucket Island Resorts (NIR) Gift Cards can be redeemed at all our hotels, the marina, restaurants, spas and
        gift shops.</p>

    {{--@include('layouts.errors')--}}

    {{ Form::open(['url' => 'buy-gift-cards' . ((!empty($id)) ? '/' . $id : '')]) }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('amount', 'Amount($)') !!}
                    {!! Form::select('amount', $amountsArray, $giftCard->amount, ['class'=>'form-control', 'id' => 'amount']) !!}
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::label('customAmount', 'Enter Amount:') !!}
                    {!! Form::number('customAmount', $giftCard->customAmount, ['class'=>'form-control', 'id' => 'customAmount']) !!}
                    <span class="text-danger">{{ $errors->first('customAmount') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::label('quantity', 'Quantity:') !!}
                    {!! Form::selectRange('quantity', 1, 20, $giftCard->quantity, ['class'=>'form-control', 'id' => 'quantity']) !!}
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                </div>
                <div class="form-group">
                    Delivery Type:
                    @foreach ($deliveryTypes as $deliveryType)
                        <label>{!! Form::radio('delivery_id', $deliveryType->id, $giftCard->delivery_id == $deliveryType->id) !!} {{ $deliveryType->name }}</label>
                    @endforeach
                    <span class="text-danger">{{ $errors->first('deliveryType') }}</span>
                </div>
                <div id="sendToInner" class="form-group">
                    Send To:
                    <label>{!! Form::radio('sendto', 'me', $giftCard->sendto == 'me') !!} Me</label>
                    <label>{!! Form::radio('sendto', 'someone', $giftCard->sendto == 'someone') !!} Someone Else</label>
                    <span class="text-danger">{{ $errors->first('sendto') }}</span>
                </div>
                <div class="form-group">
                    {!! Recaptcha::render([ 'lang' => 'en' ]) !!}
                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Next <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            (function () {
                function handleAmount() {
                    var targetDiv = $('#customAmount').closest('div');
                    if (isNaN($('#amount').val())) {
                        targetDiv.css('display', 'block');
                    } else {
                        targetDiv.css('display', 'none');
                    }
                }
                function handleECertificate() {
                    var targetDiv = $('#sendToInner');
                    if ($('input[name="delivery_id"]:checked').val() === '2') {
                        targetDiv.css('display', 'none');
                    } else {
                        targetDiv.css('display', 'block');
                    }
                }
                handleAmount();
                handleECertificate();
                $('#amount').change(handleAmount);
                $('input[name="delivery_id"]').change(handleECertificate);
            })();
        });
    </script>
@endpush