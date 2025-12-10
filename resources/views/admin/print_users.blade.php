<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Data Pengguna - Cupid AI</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 10px; color: #666; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        tr:nth-child(even) { background-color: #fafafa; }
        
        .badge { padding: 2px 5px; border-radius: 3px; font-size: 9px; font-weight: bold; border: 1px solid #ddd; }
        .approved { background-color: #d1fae5; color: #065f46; border-color: #a7f3d0; }
        .pending { background-color: #fef3c7; color: #92400e; border-color: #fde68a; }

        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #333; color: #fff; border: none; cursor: pointer; border-radius: 5px;">Cetak Dokumen</button>
    </div>

    <div class="header">
        <h1>Laporan Data Pengguna Aplikasi Cupid AI</h1>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} | Oleh: Admin</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Nama Lengkap</th>
                <th style="width: 10%">Gender</th>
                <th style="width: 10%">Agama</th>
                <th style="width: 15%">Domisili</th>
                <th style="width: 15%">Penghasilan</th>
                <th style="width: 15%">Pendidikan</th>
                <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $eduMap = [1=>'SMA', 2=>'D3', 3=>'S1', 4=>'S2', 5=>'S3']; 
            @endphp
            
            @foreach($users as $index => $user)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $user->name }}</strong><br>
                    <span style="font-size: 9px; color: #888;">{{ $user->email }}</span>
                </td>
                <td>{{ $user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $user->religion }}</td>
                <td>{{ $user->domisili }}</td>
                <td>Rp {{ number_format($user->income_level, 0, ',', '.') }}</td>
                <td>{{ $eduMap[$user->education_level] ?? '-' }}</td>
                <td style="text-align: center;">
                    <span class="badge {{ $user->status == 'approved' ? 'approved' : 'pending' }}">
                        {{ strtoupper($user->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Administrator Cupid AI</strong></p>
    </div>

</body>
</html>