<div class="table-responsive">
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Online</th>
                <th>500</th>
                <th>200</th>
                <th>100</th>
                <th>50</th>
                <th>20</th>
                <th>10</th>
                <th>Total</th>
                @if ($loggedInUserId)
                    <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if($denomination->count() > 0)
                @foreach ($denomination as $value)
                @php
                    $total = 0;
                    $total += $value->online;
                    $total += $value->n_2000*2000;
                    $total += $value->n_500*500;
                    $total += $value->n_200*200;
                    $total += $value->n_100*100;
                    $total += $value->n_50*50;
                    $total += $value->n_20*20;
                    $total += $value->n_10*10;
                @endphp
                <tr>
                    <td>{{ date('d-M-Y',strtotime($value->denomination_date)) }}</td>
                    <td>{{ $value->online }}</td>
                    <td>{{ $value->n_500*500 }}</td>
                    <td>{{ $value->n_200*200 }}</td>
                    <td>{{ $value->n_100*100 }}</td>
                    <td>{{ $value->n_50*50 }}</td>
                    <td>{{ $value->n_20*20 }}</td>
                    <td>{{ $value->n_10*10 }}</td>
                    <td><b>{{ amountFormat($total) }}</b></td>
                    @if ($loggedInUserId)
                        <td>
                            <a href="{{ route('agent.edit_denomination',['id'=>$value->id]) }}" class="btn btn-theme btn-sm">Edit</a>
                            <a class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    @endif
                </tr>        
                @endforeach
                
            @else
                <tr class="text-center"><td colspan="10">No Record Found</td></tr>
            @endif
        </tbody>
    </table>
    @if($denomination->count() > 0)
        {{ $denomination->links('agents.pagination.default') }}
    @endif
</div>