<div class="table-responsive">
    <table id="datatable" style="text-align: left;"
        class="table table-hover table-bordered table-nowrap table-align-middle card-table">
        <thead class="table-light">
            <tr>
                <th>SR#</th>
                <th>Customer Name</th>
                <th>Taken BY</th>
                <th>Amount</th>
                <th>Recevied Time</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @if($entries->count() > 0)
            @php $i = ($entries->currentpage()-1)* $entries->perpage() + 1; @endphp
                @foreach ($entries as $entry)
                    <tr class="{{ $entry->entry_type == 'penalty'?'text-danger':'' }}">
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $entry->RmDetail->name ?? '' }}<br/>
                            <span class="badge badge-sm badge-{{ $entry->amount_type == 'online'?'success':'info' }}">{{ $entry->amount_type }}</span>
                            @if($entry->entry_type == 'penalty')
                            <span class="badge badge-sm badge-danger">{{ amountFormat($entry->amount) }}</span>
                            @endif
                        </td>
                        <td>{{ $entry->agent->username }}</td>
                        <td>{{ amountFormat($entry->amount) }}</td>
                        <td>{{ date('M d, Y',strtotime($entry->entry_date)) }} {{ date('h:i A',strtotime($entry->created_at)) }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center"><td colspan="10">No Entries Found</td></tr>
            @endif
        </tbody>
    </table>
</div>
@if($entries->count() > 0)
{{ $entries->links('agents.pagination.default') }}
@endif