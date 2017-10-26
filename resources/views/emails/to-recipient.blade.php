<table width="650"  border="0">
    <tr>
        <td>
            <p>Dear {{ $address->recipient  }},</p>

            <p>You have been sent a Nantucket Island Resorts eGiftCard from {{ $giftCard->name }}.</p>

        </td>
    </tr>
    <tr>
        <td style="text-align: center; ">
            <h3>Amount: ${{ $giftCard->amount }}</h3>
        </td>

    </tr>
    <tr>
        <td style="text-align: center; ">
            <h3>eGiftCard Number: {{ $address->pool_number }}</h3>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <h4>From - {{ $giftCard->name }}</h4>
            <h4>To - {{ $address->recipient }}</h4>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <h4> {{ $address->message }}</h4>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
           <img src="{{ asset('images/gift-card-email.jpg') }}" style="max-width: 100%;"/>
        </td>
    </tr>
</table>