@extends('layouts.agent')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong>Bank Account</strong>
                </div>

                <div class="card-body">
                    @foreach($accounts as $account)
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $account->title ?? 'No Title' }}</strong>
                                <br>
                                <small class="text-muted">
                                    Status: <span class="{{ $account->is_active ? 'text-success' : 'text-danger' }}">
                                        {{ $account->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-primary"
                                    onclick='editPromotion(@json($account))'>
                                    Edit
                                </button>
                                <form action="{{ route('agent.promotions.destroy', $account->id) }}"
                                    method="POST"
                                    class="d-inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>

                        <p class="mt-2 mb-0">{!! nl2br(e($account->message)) !!}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- RIGHT SIDE : FORM --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <strong id="formTitle">Add Bank Account</strong>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('agent.accounts.store') }}" id="accountForm" data-validation="validate">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <div class="mb-3 form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" data-type="title" class="form-control">
                        </div>

                        <div class="mb-3 form-group">
                            <label>Message *</label>
                            <textarea name="message" id="message"
                                data-type="message"
                                rows="5"
                                class="form-control"
                                required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 form-group">
                                <label>Status</label>
                                <select name="is_active" id="is_active" class="form-control" data-type="status">
                                    <option value="1" {{ (isset($msg) && $msg->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ (isset($msg) && !$msg->is_active) ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 form-group">
                                <label>Position</label>
                                <select name="position" id="position" class="form-control" required data-type="position">
                                    <option value="top" {{ (isset($msg) && $msg->position === 'top') || !isset($msg) ? 'selected' : '' }}>Top</option>
                                    <option value="middle" {{ (isset($msg) && $msg->position === 'middle') ? 'selected' : '' }}>Middle</option>
                                    <option value="bottom" {{ (isset($msg) && $msg->position === 'bottom') ? 'selected' : '' }}>Bottom</option>
                                    <option value="end" {{ (isset($msg) && $msg->position === 'end') ? 'selected' : '' }}>End</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 mb-3 form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="start_date" data-type="start_date"
                                    class="form-control"
                                    value="{{ isset($msg) ? $msg->start_date : '' }}">
                            </div>
                            <div class="col-md-6 mb-3 form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="end_date" data-type="end_date"
                                    class="form-control"
                                    value="{{ isset($msg) ? $msg->end_date : '' }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button"
                                class="btn btn-secondary"
                                onclick="resetForm()">
                                Reset
                            </button>
                            <button type="button" class="btn btn-success" onclick="formValidation('accountForm','submit')">
                                Save
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@push('customjs')
<script>
    function editPromotion(msg) {
        $('#formTitle').text('Edit Promotional Message');
        $('#promoForm').attr('action', "/agent/promotions/" + msg.id);
        $('#formMethod').val('PUT');

        // Automatically fill all form fields that have matching name attributes
        $.each(msg, function(key, value) {
            let $field = $('[name="' + key + '"]');
            if ($field.length) {
                console.log('value', value);
                // For date fields, format as YYYY-MM-DD
                if ($field.attr('type') === 'date' && value) {
                    let date = new Date(value);
                    let month = ("0" + (date.getMonth() + 1)).slice(-2);
                    let day = ("0" + date.getDate()).slice(-2);
                    let formatted = date.getFullYear() + '-' + month + '-' + day;
                    $field.val(formatted);
                } else if ($field.is('select')) {
                    if (key === 'is_active') {
                        $field.val(value ? '1' : '0');
                    } else {
                        $field.val(value);
                    }

                    // Handle normal input/textarea
                } else {
                    $field.val(value);
                }
            }
        });

        // Fallback defaults
        if (!$('[name="position"]').val()) $('[name="position"]').val('top');
        if (!$('[name="is_active"]').val()) $('[name="is_active"]').val('1');
    }
</script>
@endpush