<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>appointment status - {{ $clinicName }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            line-height: 1.8;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .header .subtitle {
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 20px;
            margin-bottom: 25px;
            color: #2c3e50;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }
        .greeting strong {
            color: #4CAF50;
        }
        .action-badge {
            display: inline-block;
            padding: 8px 20px;
            background: {{ $actionType == 'new' ? '#e3f2fd' : '#fff3cd' }};
            color: {{ $actionType == 'new' ? '#0d47a1' : '#856404' }};
            border-radius: 50px;
            font-weight: bold;
            margin-bottom: 25px;
            border: 2px dashed {{ $actionType == 'new' ? '#bbdefb' : '#ffeaa7' }};
        }
        .status-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-right: 5px solid;
            border-right-color:
                @if($appointment->status == 'scheduled') #2196F3
                @elseif($appointment->status == 'completed') #4CAF50
                @elseif($appointment->status == 'cancelled') #f44336
                @else #9C27B0
                @endif;
        }
        .status-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        .status-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color:
                @if($appointment->status == 'scheduled') #1565C0
                @elseif($appointment->status == 'completed') #2E7D32
                @elseif($appointment->status == 'cancelled') #C62828
                @else #6A1B9A
                @endif;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
            background: #f1f8e9;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }
        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .detail-icon {
            width: 40px;
            height: 40px;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            font-size: 18px;
        }
        .detail-text {
            flex: 1;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .detail-value {
            color: #333;
            font-size: 16px;
            font-weight: 600;
        }
        .instructions {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
            border-right: 4px solid #4CAF50;
        }
        .instructions h3 {
            color: #2E7D32;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .instructions ul {
            padding-right: 20px;
        }
        .instructions li {
            margin-bottom: 8px;
            color: #444;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
            margin-top: 30px;
        }
        .footer h3 {
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .copyright {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #bdc3c7;
            font-size: 14px;
        }
        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
            .details-grid {
                grid-template-columns: 1fr;
                padding: 15px;
            }
            .contact-info {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="header">
            <h1>🏥 {{ $clinicName }}</h1>
            <div class="subtitle">High-quality medical care and a compassionate heart.</div>
        </div>

        <div class="content">
            <div class="greeting">
               Dear Mr/Mrs <strong>{{ $patient->name ?? 'patient'}}</strong>,
            </div>

            <div class="action-badge">
                @if($actionType == 'new')
                    📅 Confirmation of a new appointment booking
                @else
                    🔄 Update your appointment status
                @endif
            </div>

            <div class="status-card">
                <div class="status-icon">
                    @if($appointment->status == 'scheduled') 📅
                    @elseif($appointment->status == 'completed') ✅
                    @elseif($appointment->status == 'cancelled') ❌
                    @else ⏳
                    @endif
                </div>
                <div class="status-title">
                    @if($actionType == 'new')

                    📅 Confirmation of a new appointment booking

                    @else

                    🔄 Update your appointment status

                    @endif
                </div>
                <p>Current appointment status:<strong>{{ $statusText }}</strong></p>

                @if($appointment->status == 'scheduled')
                    <p style="color: #2196F3; margin-top: 10px;">Please arrive 15 minutes early💛😊.</p>
                @elseif($appointment->status == 'cancelled')
                    <p style="color: #f44336; margin-top: 10px;">You can book a new appointment later💛😊.</p>
                @elseif($appointment->status == 'completed')
                    <p style="color: #4CAF50; margin-top: 10px;">Thank you for your visit, we wish you a speedy recovery.💛💛</p>
                @endif
            </div>

            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-icon">📅</div>
                    <div class="detail-text">
                        <div class="detail-label">date</div>
                        <div class="detail-value">{{ date('Y-m-d', strtotime($appointmentDate)) }}</div>
                    </div>
                </div>



                <div class="detail-item">
                    <div class="detail-icon">👨‍⚕️</div>
                    <div class="detail-text">
                        <div class="detail-label">The Doctor</div>
                        <div class="detail-value">{{ $doctorName }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">🔢</div>
                    <div class="detail-text">
                        <div class="detail-label">appointment number </div>
                        <div class="detail-value">#{{ $appointment->id }}</div>
                    </div>
                </div>
            </div>

            <div class="instructions">
                <h3>📋 Important Instructions:</h3>
                <ul>
                    @if($appointment->status == 'scheduled')
                        <li>Please bring all previous medical reports</li>
                        <li>Ensure you have your National ID or passport</li>
                        <li>You can cancel the appointment up to 24 hours before the scheduled time.</li>
                        <li>If you are more than 15 minutes late, the appointment may be cancelled.</li>
                    @elseif($appointment->status == 'completed')
                        <li>Keep a copy of the medical report.</li>
                        <li>Follow the doctor's instructions carefully.</li>
                        <li>You can schedule a follow-up appointment if necessary.</li>
                    @elseif($appointment->status == 'cancelled')
                        <li>>You can book a new appointment at a convenient time.</li>
                        <li>For inquiries regarding cancellation reasons, please contact us.</li>
                    @endif
                </ul>
            </div>


            @if($appointment->notes)
                <div style="background: #fff8e1; padding: 15px; border-radius: 8px; border-right: 4px solid #ffb300; margin: 20px 0;">
                    <strong>📝An additional notes :</strong>
                    <p>{{ $appointment->notes }}</p>
                </div>
            @endif
        </div>


        <div class="footer">
            <h3>📍Contact info</h3>
            <div class="contact-info">

                <div class="contact-item">
                    <span>📧</span>
                    <span>info@clinic.com</span>
                </div>

            </div>
            <div class="copyright">
                <p>© {{ date('Y') }} {{ $clinicName }}All Rights Are Saved</p>
                <p>This is an automated message, please do not reply to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
