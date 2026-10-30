<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Portal Mitra - Bintang Global</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: #F9F7F2;">

            <div class="mb-8">
                <a href="/" class="flex flex-col items-center text-center no-underline">
                    <span style="color: #2C4E58; font-weight: 900; font-size: 36px; line-height: 1; letter-spacing: -1px; text-transform: uppercase;">
                        BINTANG GLOBAL
                    </span>
                    <span style="color: #C5A367; font-weight: 800; font-size: 12px; text-transform: uppercase; letter-spacing: 4px; margin-top: 6px;">
                        Partner Wisata Religi
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white shadow-[0_20px_50px_rgba(44,78,88,0.1)] overflow-hidden sm:rounded-[2rem] border-t-8 border-[#2C4E58]">
                {{ $slot }}
            </div>

            <div class="mt-8">
                <p style="color: #2C4E58; font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; opacity: 0.4;">
                    PT Bintang Global Wisata &copy; 2026
                </p>
            </div>
        </div>
    </body>
</html>
