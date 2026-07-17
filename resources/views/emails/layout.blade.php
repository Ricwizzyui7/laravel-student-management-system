<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Notification' }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:'Segoe UI', Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#1d4ed8,#4338ca); background-color:#1d4ed8; border-radius:16px 16px 0 0; padding:28px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="48" style="vertical-align:middle;">
                                        <div style="width:44px; height:44px; background-color:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25); border-radius:12px; text-align:center; line-height:44px; color:#ffffff; font-size:22px; font-weight:bold;">
                                            {{ strtoupper(substr($institution ?? config('app.institution_name', 'Global Institute of Technology'), 0, 1)) }}
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle; padding-left:14px;">
                                        <div style="color:#ffffff; font-size:17px; font-weight:bold; letter-spacing:0.5px;">
                                            {{ $institution ?? config('app.institution_name', 'Global Institute of Technology') }}
                                        </div>
                                        <div style="color:#bfdbfe; font-size:11px; text-transform:uppercase; letter-spacing:2px; margin-top:2px;">
                                            Student Management System
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 32px;">
                            @yield('content')
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#111827; border-radius:0 0 16px 16px; padding:20px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="color:#9ca3af; font-size:11px; line-height:1.6;">
                                        This is an automated message from {{ $institution ?? config('app.institution_name', 'Global Institute of Technology') }}.<br>
                                        Please do not reply directly to this email.
                                    </td>
                                    <td align="right" style="color:#6b7280; font-size:11px; vertical-align:bottom;">
                                        &copy; {{ date('Y') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
