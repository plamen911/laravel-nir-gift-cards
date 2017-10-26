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