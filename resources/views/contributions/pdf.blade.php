<!DOCTYPE html>
<html>
<head>
    <title>Financial Report - Msomi Clan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #7c3aed; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; color: #7c3aed; }
        .subtitle { font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f3f4f6; padding: 10px; border: 1px solid #e5e7eb; text-align: left; }
        td { padding: 10px; border: 1px solid #e5e7eb; }
        .total-row { font-weight: bold; background-color: #f9fafb; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; }
        .status-completed { color: #059669; }
        .status-pending { color: #d97706; }
        .status-failed { color: #dc2626; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">MSOMI CLAN MANAGEMENT SYSTEM</div>
        <div class="subtitle">Official Financial Report</div>
        <p>Generated on: {{ date('F d, Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Type</th>
                <th>Reference</th>
                <th>Status</th>
                <th>Amount (TZS)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contributions as $contribution)
            <tr>
                <td>{{ $contribution->created_at->format('Y-m-d') }}</td>
                <td>{{ $contribution->member->full_name }}</td>
                <td>{{ ucfirst($contribution->contribution_type) }}</td>
                <td>{{ $contribution->reference_number ?? '-' }}</td>
                <td class="status-{{ $contribution->status }}">{{ ucfirst($contribution->status) }}</td>
                <td style="text-align: right;">{{ number_format($contribution->amount) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">TOTAL COLLECTED</td>
                <td style="text-align: right;">{{ number_format($total) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated report. Msomi Clan © {{ date('Y') }}</p>
    </div>
</body>
</html>
