@extends('layouts.agent')
@section('title', 'Today\'s Collection')
@section('content')

    <div class="py-8 flex oskasdadiaa rounded-xl bg-white dark:bg-gray-900">
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Entry ID</th>
                    <th>RM ID</th>
                    <th>Customer</th>
                    <th>Mobile</th>
                    <th>Total Entries</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td>
                        <td>{{ $entry->rm_id }}</td>
                        <td>{{ $entry->customer_name ?? 'Unknown' }}</td>
                        <td>{{ $entry->mobile ?? '-' }}</td>
                        <td>{{ $entry->amount }}</td>
                        <td>{{ $entry->entry_date }}</td>

                        <td>
                            @if (!$entry->rm_exists)
                                Missing RM
                            @elseif($entry->deleted_at)
                                Soft Deleted
                            @endif
                        </td>

                        <td>

                            @if (!$entry->rm_exists)
                                <form method="POST" action="{{ url('admin/recreate-rm') }}">
                                    @csrf
                                    <input type="hidden" name="rm_id" value="{{ $entry->rm_id }}">
                                    <button>Create RM</button>
                                </form>
                            @elseif($entry->deleted_at)
                                <form method="POST" action="{{ url('admin/restore-rm') }}">
                                    @csrf
                                    <input type="hidden" name="rm_id" value="{{ $entry->rm_id }}">
                                    <button>Restore RM</button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
