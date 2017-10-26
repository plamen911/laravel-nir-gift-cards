<h3>Nantucket Island Resorts</h3>
<h4>Gift Card Purchase Information</h4>
<table style="border: solid 1px #ccc; width: 650px;">

    <tr>
        <th>
            Billing Information
        </th>
    </tr>

    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Name: {{ $giftCard->name }}</td>
    </tr>


    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Card Type: {{ $giftCard->cctype }}</td>
    </tr>


    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Card (last 4 digits) : {{ $giftCard->ccnumber }}</td>
    </tr>


    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Exp: {{ $giftCard->ccexp_month }} / {{ $giftCard->ccexp_year }}</td>
    </tr>

    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Billing E-Mail: {{ $giftCard->email }}</td>
    </tr>


    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Billing Phone: {{ $giftCard->phone }}</td>
    </tr>

    <tr>
        <th>
            Order Information
        </th>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Amount: ${{ number_format($giftCard->amount, 2) }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Quantity: {{ $giftCard->quantity }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Shipping Cost: ${{ number_format($giftCard->shipping, 2) }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Total: ${{ number_format($giftCard->total, 2) }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Send card to: {{ $giftCard->sendto_name }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Delivery Method: {{ (isset($giftCard->deliveryTypes->name)) ? $giftCard->deliveryTypes->name : '' }}</td>
    </tr>
    <tr>

        @if (!$giftCard->isECertificate())
            <td style="background-color: #E7E6EE; padding: 5px;">Shipping Address: {{ $giftCard->address }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">{{ $giftCard->address2 }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">City: {{ $giftCard->city }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">State: {{ $giftCard->state }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">ZIP code: {{ $giftCard->zip }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Country: {{ $giftCard->country }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Shipping Method: {{ (isset($giftCard->shippingMethod->name)) ? $giftCard->shippingMethod->name : '' }}</td>
    </tr>
    <tr>

        @endif
        <td style="background-color: #E7E6EE; padding: 5px;">Order Number: {{ $giftCard->order_number }}</td>
    </tr>
    <tr>
        <td style="background-color: #E7E6EE; padding: 5px;">Order Date: {{ date('m/d/Y H:i', strtotime($giftCard->created_at)) }}</td>
    </tr>

</table>

<h3>Gift Card(s) Information</h3>

@foreach($giftCard->addresses as $address)
    <table style="border: solid 1px #ccc; margin-top: 10px; width: 650px;">
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">Card ID: {{ $address->pool_number }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">Recipient: {{ $address->recipient }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">E-Mail Address: {{ $address->email }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">Shipping Address: {{ $address->address }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">{{ $address->address2 }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">City: {{ $address->city }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">State: {{ $address->state }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">ZIP Code: {{ $address->zip }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">Country: {{ $address->country }}</td>
        </tr>
        <tr>
            <td style="background-color: #E7E6EE; padding: 5px;">Gift Card Message: {{ $address->message }}</td>
        </tr>
    </table>
@endforeach








<!--
<h3>Purchase Info</h3>
<ul>
    <li>id: {{ $giftCard->id }}</li>
    <li>amount: ${{ number_format($giftCard->amount, 2) }}</li>
    <li>quantity: {{ $giftCard->quantity }}</li>
    <li>shipping: ${{ number_format($giftCard->shipping, 2) }}</li>
    <li>total: ${{ number_format($giftCard->total, 2) }}</li>
    <li>send to: {{ $giftCard->sendto_name }}</li>
    <li>delivery: {{ (isset($giftCard->deliveryTypes->name)) ? $giftCard->deliveryTypes->name : '' }}</li>
    <li>name: {{ $giftCard->name }}</li>
    <li>cc type: {{ $giftCard->cctype }}</li>
    <li>cc number: {{ $giftCard->ccnumber }}</li>
    <li>cc exp. month: {{ $giftCard->ccexp_month }}</li>
    <li>cc exp. year: {{ $giftCard->ccexp_year }}</li>
    <li>email: {{ $giftCard->email }}</li>
    <li>phone: {{ $giftCard->phone }}</li>
    @if (!$giftCard->isECertificate())
        <li>shipping name: {{ (isset($giftCard->shippingMethod->name)) ? $giftCard->shippingMethod->name : '' }}</li>
        <li>address: {{ $giftCard->address }}</li>
        <li>address2: {{ $giftCard->address2 }}</li>
        <li>city: {{ $giftCard->city }}</li>
        <li>state: {{ $giftCard->state }}</li>
        <li>zip: {{ $giftCard->zip }}</li>
        <li>country: {{ $giftCard->country }}</li>
    @endif
    <li>status: {{ $giftCard->status }}</li>
    <li>reference: {{ $giftCard->reference }}</li>
    <li>code: {{ $giftCard->code }}</li>
    <li>order number: {{ $giftCard->order_number }}</li>
    <li>created at: {{ date('m/d/Y H:i', strtotime($giftCard->created_at)) }}</li>
</ul>

<h3>Addresses</h3>
<ul>
    @foreach($giftCard->addresses as $address)
        <li>
            <ul>
                <li>id: {{ $address->id }}</li>
                <li>recipient: {{ $address->recipient }}</li>
                <li>email: {{ $address->email }}</li>
                <li>phone: {{ $address->phone }}</li>
                <li>address: {{ $address->address }}</li>
                <li>address2: {{ $address->address2 }}</li>
                <li>city: {{ $address->city }}</li>
                <li>state: {{ $address->state }}</li>
                <li>zip: {{ $address->zip }}</li>
                <li>country: {{ $address->country }}</li>
                <li>message: {{ $address->message }}</li>
            </ul>
        </li>
    @endforeach
</ul>
-->