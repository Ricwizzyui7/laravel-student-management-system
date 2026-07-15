<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Report' }}</title>
    <style>
        @page {
            margin: 130px 40px 80px 40px;
        }
        * { font-family: 'DejaVu Sans', sans-serif; }
        body { margin: 0; color: #1f2937; font-size: 11px; }

        /* ---- Fixed header (repeats on every page) ---- */
        header {
            position: fixed;
            top: -110px; left: 0; right: 0;
            height: 90px;
        }
        .hdr-table { width: 100%; border-collapse: collapse; }
        .logo-box {
            width: 50px; height: 50px;
            background: #1d4ed8; border-radius: 10px;
            text-align: center;
            color: #fff; font-size: 26px; font-weight: bold;
            line-height: 50px;
        }
        .inst-name { font-size: 17px; font-weight: bold; color: #111827; }
        .inst-sub { font-size: 10px; color: #6b7280; letter-spacing: 1px; text-transform: uppercase; }
        .hdr-right { text-align: right; vertical-align: bottom; }
        .report-title { font-size: 14px; font-weight: bold; color: #1d4ed8; }
        .report-sub { font-size: 10px; color: #6b7280; }
        .hdr-rule { border: none; border-top: 2px solid #1d4ed8; margin: 8px 0 0 0; }

        /* ---- Fixed footer (repeats on every page) ---- */
        footer {
            position: fixed;
            bottom: -60px; left: 0; right: 0;
            height: 40px;
            color: #9ca3af; font-size: 9px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
        }
        .foot-table { width: 100%; border-collapse: collapse; }
        .foot-right { text-align: right; }
        /* dompdf page counter */
        .pagenum:before { content: counter(page); }
        .pagecount:before { content: counter(pages); }

        /* ---- Content tables ---- */
        table.data { width: 100%; border-collapse: collapse; margin-top: 4px; }
        table.data thead th {
            background: #1d4ed8; color: #fff;
            text-align: left; padding: 7px 8px;
            font-size: 10px; text-transform: uppercase; letter-spacing: .3px;
        }
        table.data tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 10.5px; }
        table.data tbody tr:nth-child(even) td { background: #f9fafb; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; }
        .b-green { background: #dcfce7; color: #166534; }
        .b-red { background: #fee2e2; color: #991b1b; }
        .b-yellow { background: #fef9c3; color: #854d0e; }
        .b-blue { background: #dbeafe; color: #1e40af; }
        .muted { color: #6b7280; }
        h2.section { font-size: 13px; color: #111827; margin: 14px 0 4px 0; }
    </style>
</head>
<body>

    <header>
        <table class="hdr-table">
            <tr>
                <td style="width: 60px;">
                    <div class="logo-box">{{ strtoupper(substr($institution, 0, 1)) }}</div>
                </td>
                <td style="vertical-align: middle; padding-left: 10px;">
                    <div class="inst-name">{{ $institution }}</div>
                    <div class="inst-sub">Student Management System</div>
                </td>
                <td class="hdr-right">
                    <div class="report-title">{{ $title }}</div>
                    @isset($subtitle)<div class="report-sub">{{ $subtitle }}</div>@endisset
                </td>
            </tr>
        </table>
        <hr class="hdr-rule">
    </header>

    <footer>
        <table class="foot-table">
            <tr>
                <td>Generated: {{ $generatedAt->format('d M Y, H:i') }}</td>
                <td style="text-align:center;">{{ $institution }}</td>
                <td class="foot-right">Page <span class="pagenum"></span> of <span class="pagecount"></span></td>
            </tr>
        </table>
    </footer>

    <main>
        @yield('content')
    </main>

</body>
</html>
