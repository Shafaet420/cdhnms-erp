<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify — CDHNMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-sm p-8 max-w-sm w-full text-center">
        <div class="text-emerald-500 text-3xl mb-2">✓</div>
        <h1 class="font-semibold text-lg mb-1">Identity Verified</h1>
        <p class="text-sm text-slate-400 mb-6">{{ $student->institution->name_en }}</p>

        <dl class="text-left text-sm space-y-2">
            <div class="flex justify-between"><dt class="text-slate-400">Name</dt><dd class="font-medium">{{ $student->name_en }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-400">Student ID</dt><dd class="font-medium">{{ $student->student_id }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-400">Class</dt><dd class="font-medium">{{ $student->schoolClass->name_en ?? '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-400">Status</dt><dd class="font-medium">{{ ucfirst($student->status) }}</dd></div>
        </dl>
    </div>
</body>
</html>
