<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #ff7a00;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            color: #ff7a00;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f2f2f2;
            color: #555;
            width: 30%;
        }

        td {
            background-color: #fafafa;
            color: #333;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 12px;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #999;
            width: 200px;
            float: right;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Prescription</h2>
</div>

<table>
    <tr>
        <th>Patient ID</th>
        <td>{{ $prescription->medical_record->patient_id ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Medicine Name</th>
        <td>{{ $prescription->medicine_name }}</td>
    </tr>
    <tr>
        <th>Dosage</th>
        <td>{{ $prescription->dosage }}</td>
    </tr>
    <tr>
        <th>Frequency</th>
        <td>{{ $prescription->frequency }}</td>
    </tr>
    <tr>
        <th>Refills</th>
        <td>{{ $prescription->refills }}</td>
    </tr>
    <tr>
        <th>Duration</th>
        <td>{{ $prescription->duration }} days</td>
    </tr>
    <tr>
        <th>Instructions</th>
        <td>{{ $prescription->instructions }}</td>
    </tr>
</table>

<div class="footer">
    <div>
        Date: {{ now()->format('Y-m-d') }}
    </div>

    <div class="signature">
        Doctor Signature
        <div class="signature-line"></div>
    </div>
</div>

</body>
</html>
