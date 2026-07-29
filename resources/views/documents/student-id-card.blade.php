<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; margin: 0; padding: 8px; }
        .card { border: 2px solid #4338ca; border-radius: 10px; padding: 10px; }
        .header { text-align: center; font-size: 10px; font-weight: bold; color: #4338ca; }
        .name { font-size: 13px; font-weight: bold; margin-top: 6px; }
        .meta { font-size: 9px; color: #444; margin-top: 2px; }
        .qr { float: right; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">{{ $institution->name_en }}</div>
        <div class="qr">{!! $qrSvg !!}</div>
        <div class="name">{{ $student->name_en }}</div>
        <div class="meta">Student ID: {{ $student->student_id }}</div>
        <div class="meta">Class: {{ $student->schoolClass->name_en ?? '-' }}</div>
        <div class="meta">Session: {{ $student->academicSession->name ?? '-' }}</div>
    </div>
</body>
</html>
