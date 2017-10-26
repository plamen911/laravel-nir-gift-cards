@extends('layouts.master')

@section('content')
    <h2>Payment Has Successfully Completed.</h2>
    <h3>Thank you for shopping with <strong>Nantucket Island Resorts</strong>!</h3>
    <h4>Check the confirmation email at {{ $giftCard->email }}</h4>
    <hr/>
    <p>Your credit card ending in <strong>{{ $giftCard->ccnumber }}</strong> has been charged
        <strong>${{ number_format($giftCard->total, 2) }}</strong>.</p>
    <p>Your order number is <strong>{{ $giftCard->order_number }}</strong>.</p>
    <p><strong>Nantucket Island Resorts</strong> will review all orders and payments. If a problem is found during
        verification, we will notify you via email.</p>
    <p>Note: If you do not receive the email in few minutes:</p>
    <ul>
        <li>Note: If you do not receive the email in few minutes:</li>
        <li>verify if you typed your email correctly</li>
        <li>if you can't resolve the issue, please contact <a href="mailto:support@nirdev.ivanovnewmedia.com">support@nirdev.ivanovnewmedia.com</a>.</li>
    </ul>
    <hr/>
    <p><a href="{{ url('/') }}" class="btn btn-default">Continue Shopping</a></p>
@endsection
