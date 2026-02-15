<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #059669; color: #ffffff; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background-color: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .receipt-box { background-color: #f9fafb; padding: 20px; border: 1px dashed #d1d5db; margin: 20px 0; }
        .amount { font-size: 32px; font-weight: bold; color: #059669; text-align: center; }
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PAYMENT RECEIPT</h1>
        </div>
        <div class="content">
            <p>Hello {{ $contribution->member->first_name }},</p>
            <p>Thank you for your contribution. Your payment has been successfully recorded.</p>
            
            <div class="receipt-box">
                <div class="amount">KES {{ number_format($contribution->amount) }}</div>
                <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 15px 0;">
                <p><strong>Reference:</strong> {{ $contribution->reference_number }}</p>
                <p><strong>Type:</strong> {{ ucfirst($contribution->contribution_type) }}</p>
                <p><strong>Date:</strong> {{ $contribution->payment_date->format('F d, Y') }}</p>
                <p><strong>Method:</strong> {{ ucfirst($contribution->payment_method) }}</p>
            </div>
            
            <p>You can view your full contribution history by logging into the portal.</p>
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('contributions.my') }}" style="color: #059669; font-weight: bold;">View My Contributions</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Msomi Clan Management System</p>
        </div>
    </div>
</body>
</html>
