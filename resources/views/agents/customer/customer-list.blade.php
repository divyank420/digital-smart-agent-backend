@if ($customers->count() > 0)
@foreach ($customers as $customer)
<tr>
    <td>
        <div class="d-flex align-items-center">
            <div><i class="bx bx-user me-2 font-15 text-danger"></i>
            </div>
            <div class="font-weight-bold text-theme">{{ $customer['customer']['name'].'('.$customer->customer->id.')'  }}</div>
        </div>
    </td>
    <td>
        <div>
            {{ $customer['name']}} <br>
            <small class="text-muted">{{ $customer['rm_code'] }}</small>
        </div>
    </td>
    <td>{{ $customer->customer->mobile }}</td>
    <td>{{ $customer->customer->email }}</td>
    <td>{{ amountFormat($customer['monthly_amount']) }}</td>
    <td>{{ amountFormat($customer['installment_amount']) }}</td>
    <td>
        <button class="badge badge-info">Edit</button>
    </td>
</tr>
@endforeach

@else
<tr>
    <td>No Customer Found</td>
</tr>
@endif