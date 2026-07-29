@props(['title' => 'CDHNMS ERP'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <div class="inline-block font-bold text-xl text-indigo-600">CDHNMS</div>
            <p class="text-xs text-slate-400 mt-1">Enterprise Education ERP</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
