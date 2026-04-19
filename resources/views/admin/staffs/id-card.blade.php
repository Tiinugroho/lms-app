<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak ID Card - {{ $staff->user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Pengaturan ukuran kertas untuk Print */
        @media print {
            body { background-color: white; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-area { box-shadow: none !important; border: none !important; }
        }
        
        /* Ukuran standar ID Card Portrait (54mm x 86mm) */
        .id-card-container {
            width: 54mm;
            height: 86mm;
            position: relative;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
            print-color-adjust: exact; /* Memaksa printer mencetak background color */
            -webkit-print-color-adjust: exact;
        }

        /* Desain Background Melengkung */
        .bg-shape {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            border-bottom-left-radius: 50%;
            border-bottom-right-radius: 50%;
            z-index: 0;
        }
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center justify-center min-h-screen py-10">

    <div class="mb-8 flex gap-4 no-print">
        <a href="{{ route('admin.staffs.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-md shadow hover:bg-gray-50 font-medium border border-gray-300">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak ID Card
        </button>
    </div>

    <div class="print-area flex gap-8">
        
        <div class="id-card-container flex flex-col items-center pt-4 relative">
            <div class="bg-shape"></div>
            
            <div class="relative z-10 flex flex-col items-center w-full px-2">
                <img src="{{ $setting->logo_url }}" alt="Logo" class="h-10 w-10 object-contain bg-white p-1 rounded-full shadow-sm mb-1">
                <h1 class="text-[10px] font-bold text-white text-center leading-tight uppercase">{{ $setting->app_name }}</h1>
            </div>

            <div class="relative z-10 mt-3 border-4 border-white rounded-full shadow-md bg-white overflow-hidden" style="width: 25mm; height: 25mm;">
                <img src="{{ $staff->user->avatar_url }}" alt="Foto" class="w-full h-full object-cover">
            </div>

            <div class="relative z-10 mt-3 flex flex-col items-center text-center px-3 w-full">
                <h2 class="text-sm font-bold text-gray-900 leading-tight">{{ strtoupper($staff->user->name) }}</h2>
                <p class="text-[10px] font-semibold text-indigo-600 mt-0.5 tracking-wider">{{ strtoupper($staff->position) }}</p>
                
                <div class="mt-3 w-full border-t border-gray-200 pt-2">
                    <p class="text-[9px] text-gray-500 font-medium">NIP / ID PEGAWAI</p>
                    <p class="text-xs font-bold text-gray-800 tracking-widest">{{ $staff->nip }}</p>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 w-full bg-indigo-600 py-1.5">
                <p class="text-[8px] text-white text-center font-medium tracking-widest">KARTU TANDA PENGENAL</p>
            </div>
        </div>

        <div class="id-card-container flex flex-col pt-6 px-4 bg-white relative">
            <div class="w-full text-center border-b-2 border-indigo-600 pb-2 mb-3">
                <h2 class="text-xs font-bold text-gray-900">KETENTUAN PENGGUNAAN</h2>
            </div>
            
            <ul class="text-[8px] text-gray-700 text-justify list-decimal pl-3 space-y-1.5">
                <li>Kartu ini adalah identitas resmi lingkungan {{ $setting->app_name }}.</li>
                <li>Kartu ini wajib dikenakan selama berada di lingkungan kerja/sekolah.</li>
                <li>Jika menemukan kartu ini, harap kembalikan ke alamat di bawah ini.</li>
            </ul>

            <div class="mt-auto mb-6 text-center">
                <p class="text-[9px] font-bold text-gray-900">ALAMAT SEKOLAH:</p>
                <p class="text-[8px] text-gray-600 leading-tight mt-1 px-2">{{ $setting->school_address ?? 'Alamat belum diatur' }}</p>
                <p class="text-[8px] text-gray-600 font-medium mt-1">Telp: {{ $setting->school_phone ?? '-' }}</p>
            </div>
        </div>

    </div>

</body>
</html>