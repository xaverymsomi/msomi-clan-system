<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            size: 8.5cm 5.4cm;
            margin: 0;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .card {
            width: 8.5cm;
            height: 5.4cm;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }
        .card-bg {
            position: absolute;
            top: -20px;
            right: -20px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .header {
            padding: 10px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            padding: 10px 15px;
            display: table;
            width: 100%;
        }
        .photo-area {
            display: table-cell;
            width: 60px;
            vertical-align: top;
        }
        .photo {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            border: 2px solid white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        .details {
            display: table-cell;
            padding-left: 15px;
            vertical-align: top;
        }
        .name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .member-number {
            font-size: 10px;
            opacity: 0.8;
            margin-bottom: 10px;
        }
        .info-grid {
            margin-top: 5px;
        }
        .info-label {
            font-size: 8px;
            text-transform: uppercase;
            opacity: 0.7;
        }
        .info-value {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px 15px;
            font-size: 8px;
            background: rgba(0, 0, 0, 0.1);
            text-align: right;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .qr-code {
            position: absolute;
            bottom: 10px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: white;
            padding: 2px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-bg"></div>
        <div class="header">MSOMI CLAN - IDENTITY</div>
        
        <div class="content">
            <div class="photo-area">
                @if($member->profile_photo)
                    <img src="{{ public_path('storage/' . $member->profile_photo) }}" class="photo">
                @else
                    <div class="photo" style="display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        {{ substr($member->first_name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div class="details">
                <div class="name">{{ $member->full_name }}</div>
                <div class="member-number">ID: {{ $member->member_number }}</div>
                
                <div class="info-grid">
                    <div class="info-label">REGION / DISTRICT</div>
                    <div class="info-value">{{ $member->region }} / {{ $member->district }}</div>
                    
                    <div class="info-label">VILLAGE</div>
                    <div class="info-value">{{ $member->village }}</div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            VALID SINCE: {{ $member->joined_date?->format('F Y') ?? $member->created_at->format('F Y') }}
        </div>
    </div>
</body>
</html>
