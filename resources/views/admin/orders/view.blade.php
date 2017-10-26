@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Order Details</h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i><a href="{{ route('admin.dashboard') }}"> Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-fw fa-table"></i><a href="{{ route('admin.orders') }}"> Orders</a>
                </li>
                <li class="active">
                    Order # {{ $giftCard->order_number }}
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Payment Information</h3>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Order #</div>
                            <div class="col-sm-6">{{ $giftCard->order_number }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Order Date</div>
                            <div class="col-sm-6">{{ date('m/d/Y', strtotime($giftCard->created_at)) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Order Code</div>
                            <div class="col-sm-6">{{ $giftCard->code }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Order Ref.</div>
                            <div class="col-sm-6">{{ $giftCard->reference }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Amount</div>
                            <div class="col-sm-6">${{ number_format($giftCard->amount, 2) }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Quantity</div>
                            <div class="col-sm-6">${{ $giftCard->quantity }}</div>
                        </div>
                    </li>
                    @if (!$giftCard->isECertificate())
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Shipping</div>
                                <div class="col-sm-6">${{ number_format($giftCard->shipping, 2) }}</div>
                            </div>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Total</div>
                            <div class="col-sm-6">${{ number_format($giftCard->total, 2) }}</div>
                        </div>
                    </li>
                    @if (!$giftCard->isECertificate())
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Shipping Method</div>
                                <div class="col-sm-6">{{ $giftCard->shippingMethod->name }}</div>
                            </div>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Delivery Type</div>
                            <div class="col-sm-6">{{ $giftCard->deliveryTypes->name }}</div>
                        </div>
                    </li>
                    @if (!$giftCard->isECertificate())
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Send To</div>
                                <div class="col-sm-6">{{ $giftCard->sendto_name }}</div>
                            </div>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Name</div>
                            <div class="col-sm-6">{{ $giftCard->name }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Email Receipt To</div>
                            <div class="col-sm-6">{{ $giftCard->email }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Billing Address 1</div>
                            <div class="col-sm-6">{{ $giftCard->address }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Billing Address 2</div>
                            <div class="col-sm-6">{{ $giftCard->address2 }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">City</div>
                            <div class="col-sm-6">{{ $giftCard->city }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">State</div>
                            <div class="col-sm-6">{{ $giftCard->state }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Zip Code</div>
                            <div class="col-sm-6">{{ $giftCard->zip }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Country</div>
                            <div class="col-sm-6">{{ $giftCard->country }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Card Type</div>
                            <div class="col-sm-6">{{ $giftCard->cctype }}</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">Card Number</div>
                            <div class="col-sm-6">{{ $giftCard->ccnumber }} (last 4 digits)</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            {{--<h2>Delivery Information</h2>--}}
            @foreach ($giftCard->addresses as $i => $address)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recipient #{{ $i + 1 }} Delivery Information</h3>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Name</div>
                                <div class="col-sm-6">{{ $address->recipient }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Email</div>
                                <div class="col-sm-6">{{ $address->email }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Personalized Message</div>
                                <div class="col-sm-6">{{ $address->message }}</div>
                            </div>
                        </li>
                        @if (!$giftCard->isECertificate())
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Shipping Address 1</div>
                                    <div class="col-sm-6">{{ $address->address }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Shipping Address 2</div>
                                    <div class="col-sm-6">{{ $address->address2 }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">City</div>
                                    <div class="col-sm-6">{{ $address->city }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">State</div>
                                    <div class="col-sm-6">{{ $address->state }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Zip Code</div>
                                    <div class="col-sm-6">{{ $address->zip }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Country</div>
                                    <div class="col-sm-6">{{ $address->country }}</div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection

