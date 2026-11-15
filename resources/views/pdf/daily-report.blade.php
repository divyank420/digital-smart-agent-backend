<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Today's Collection Report</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 5mm 5mm 5mm 5mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #333333;
            margin: 0;
            padding: 0 0 0 10px;
            background-color: #ffffff;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Layout Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .header-table td {
            border: none;
            padding-bottom: 0px;
            vertical-align: middle;
        }

        .header-table td:first-child {
            text-align: left;
        }

        .meta-info {
            text-align: right;
        }

        .meta-info div {
            font-weight: bold;
        }

        /* Agent Section Heading */
        .agent-section-title {
            font-size: 11px;
            font-weight: bold;
            background-color: #e9ecef;
            padding: 4px 8px;
            margin-top: 10px;
            margin-bottom: 5px;
            border: 1px solid #ced4da;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            padding: 2px 4px;
            text-align: left;
            font-size: 10px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            border-top: 1px solid #dddddd;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Summary Rows */
        .total-row td {
            font-weight: bold;
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            background-color: #fdfdfd;
        }

        .grand-total-row td {
            font-weight: bold;
            font-size: 10px;
            border-top: 1px solid #000000;
            border-bottom: 2px solid #000000;
            background-color: #f1f3f5;
        }

        /* Bottom Grid Table (Side-by-Side Sections) */
        .bottom-grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .bottom-grid-table td {
            vertical-align: top;
            border: none;
            padding: 0 5px 0 0;
        }

        .bottom-grid-table td:last-child {
            padding-right: 0;
        }

        .section-box {
            border: 1px solid #dddddd;
            padding: 0px;
            background-color: #ffffff;
            margin-bottom: 5px;
        }

        .section-box h3 {
            margin: 0px;
            padding: 5px;
            font-size: 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dddddd;
        }

        .sr {
            font-weight: 900;
        }

        .inner-table {
            width: 97%;
            margin-bottom: 0;
        }

        .inner-table td {
            border-bottom: 1px solid #eeeeee;
            padding: 2px 4px;
        }

        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border-bottom-width: 2px;
        }

        .table-bordered>tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
        }

        .watermark {
            position: fixed;
            transform: translate(-50%, -50%);
            opacity: 0.3;
            font-size: 14px;
            color: #a0a0a0ae;
        }

        .watermark_1 {
            top: 10%;
            left: 50%;
        }

        .watermark_2 {
            top: 50%;
            left: 50%;
            opacity: 0.2;
        }

        .watermark_3 {
            top: 80%;
            left: 50%;
            opacity: 0.1;
        }
    </style>
</head>

<body>
    <div class="watermark watermark_1">Digital Smart Agent <br><small style="font-size: 10px;">Contact Us: +91-7665629201</small></div>
    <div class="watermark watermark_2">Digital Smart Agent <br><small style="font-size: 10px;">Contact Us: +91-7665629201</small></div>
    <div class="watermark watermark_3">Digital Smart Agent <br><small style="font-size: 10px;">Contact Us: +91-7665629201</small></div>

    <div class="container">
        <!-- Header Section -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo-area">
                        <img class="img-responsive" alt="Digital Smart Agent"
                            src="{{ public_path() . '/assets/dsa_white_logo.png' }}"
                            style="width: 150px; height: 40px; border-radius: 43px;">
                    </div>
                </td>
                <td class="meta-info">
                    <div><strong>Company Name:</strong> <span>{{ $company->company_name ?? '' }}</span></div>
                    <div><strong>Collection Date:</strong> {{ date('d-M-Y', strtotime($date)) }}</div>
                </td>
            </tr>
        </table>

        <!-- Loop Collections Grouped by Agent -->
        @php
            $groupedCollections = $collectionData->groupBy(function ($item) {
                return optional($item->agent)->name ?? ($item->name ?? 'General');
            });
        @endphp

        @forelse ($groupedCollections as $agentName => $agentCollections)
            <div class="agent-section-title">{{ $agentName }}</div>

            @php
                $collectionList = $agentCollections->values();
                $totalCount = $collectionList->count();
                // Determine actual columns needed (Max 3 columns, but fewer if total count is small)
                $numCols = $totalCount < 3 ? max(1, $totalCount) : 3;
                $chunkSize = ceil($totalCount / $numCols);
                
                $chunks = [];
                for ($c = 0; $c < $numCols; $c++) {
                    $chunks[$c] = $collectionList->slice($c * $chunkSize, $chunkSize)->values();
                }
                $maxRows = $numCols > 0 ? max(array_map(fn($c) => $c->count(), $chunks)) : 0;
            @endphp

            <table class="table-bordered">
                <thead>
                    <tr>
                        @for ($c = 0; $c < $numCols; $c++)
                            <th>Sr.</th>
                            <th>Name</th>
                            <th class="text-right">Amount</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @if ($maxRows > 0)
                        @for ($i = 0; $i < $maxRows; $i++)
                            <tr>
                                @php $runningIndex = 0; @endphp
                                @for ($c = 0; $c < $numCols; $c++)
                                    @php 
                                        $item = $chunks[$c][$i] ?? null;
                                        // Calculate global serial index for this item
                                        $currentIndex = 0;
                                        for($prev = 0; $prev < $c; $prev++) {
                                            $currentIndex += $chunks[$prev]->count();
                                        }
                                        $currentIndex += $i + 1;
                                    @endphp
                                    <td class="sr">{{ $item ? $currentIndex . '.' : '-' }}</td>
                                    <td>{{ $item ? (optional($item->RmDetail)->name ?? 'N/A') : '-' }}</td>
                                    <td class="text-right">
                                        @if ($item)
                                            {{ number_format($item->amount, 0) }}
                                            ({{ strtolower($item->entry_type) === 'online' ? 'U' : 'C' }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="{{ $numCols * 3 }}" class="text-center" style="font-style: italic; color: #718096;">No collections found for this agent.</td>
                        </tr>
                    @endif

                    <!-- Subtotals Row -->
                    <tr class="total-row">
                        @for ($c = 0; $c < $numCols; $c++)
                            <td colspan="2">Total</td>
                            <td class="text-right">{{ number_format($chunks[$c]->sum('amount'), 0) }}</td>
                        @endfor
                    </tr>
                    
                    <!-- Agent Total Row -->
                    <tr class="grand-total-row">
                        <td colspan="{{ ($numCols * 3) - 1 }}">Total Collection ({{ $agentName }})</td>
                        <td class="text-right">{{ number_format($agentCollections->sum('amount'), 0) }}</td>
                    </tr>
                </tbody>
            </table>
        @empty
            <table class="table-bordered">
                <tr>
                    <td colspan="3" class="text-center" style="font-style: italic; color: #718096;">No collections found for this date.</td>
                </tr>
            </table>
        @endforelse

        <!-- Overall Grand Total -->
        <table class="table-bordered">
            <tr class="grand-total-row" style="background-color: #e2e8f0;">
                <td colspan="2">Grand Total (All Agents)</td>
                <td class="text-right" style="width: 15%;">
                    {{ number_format($totalCollection ?? $collectionData->sum('amount'), 0) }}</td>
            </tr>
        </table>

        <!-- Bottom Grid: Side-by-Side Dynamic Denominations & Expenses -->
        <table class="bottom-grid-table">
            <tr>
                @forelse ($denominations as $index => $denomination)
                    <td>
                        @php
                            $totalDenomination = 0;
                            $notes = [
                                2000 => $denomination->n_2000 ?? 0,
                                500 => $denomination->n_500 ?? 0,
                                200 => $denomination->n_200 ?? 0,
                                100 => $denomination->n_100 ?? 0,
                                50 => $denomination->n_50 ?? 0,
                                20 => $denomination->n_20 ?? 0,
                                10 => $denomination->n_10 ?? 0,
                            ];
                        @endphp
                        <div class="section-box">
                            <h3>Deno. {{ optional($denomination->agent)->name ?? 'Agent' }}</h3>
                            <table class="inner-table">
                                <thead>
                                    <tr>
                                        <th>Calculation</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $noteValue => $qty)
                                        @if ($qty > 0)
                                            @php
                                                $rowTotal = $qty * $noteValue;
                                                $totalDenomination += $rowTotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $noteValue }} × {{ $qty }}</td>
                                                <td class="text-right">{{ number_format($rowTotal, 0) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @if (($denomination->online ?? 0) > 0)
                                        @php
                                            $totalDenomination += $denomination->online;
                                        @endphp
                                        <tr>
                                            <td>Online</td>
                                            <td class="text-right">{{ number_format($denomination->online, 0) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="total-row">
                                        <td>Total</td>
                                        <td class="text-right">{{ number_format($totalDenomination, 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                @empty
                    <td>
                        <div class="section-box">
                            <h3>Denomination Detail</h3>
                            <table class="inner-table">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center" style="font-style: italic; color: #718096;">No denominations recorded</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                @endforelse

                <!-- Right Side: Expenses Detail Column -->
                @if ($expenseData->isNotEmpty())
                    <td>
                        <div class="section-box">
                            <h3>Expenses Detail</h3>
                            <table class="inner-table">
                                <thead>
                                    <tr>
                                        <th>Expense Detail</th>
                                        <th>Type</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenseData as $expense)
                                        <tr>
                                            <td>
                                                @if ($expense->reason)
                                                    <span style="font-size: 10px; color: #555;">{{ $expense->reason }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $expense->expenses_type }}</td>
                                            <td class="text-right">{{ number_format($expense->amount, 0) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="total-row">
                                        <td colspan="2">Total Expenses</td>
                                        <td class="text-right">{{ number_format($totalExpenses ?? 0, 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                @endif
            </tr>
        </table>
    </div>
</body>

</html>