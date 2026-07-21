@extends('emails.layout')

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        {{-- Greeting --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:20px; font-weight:600; line-height:1.4;">
                    Welcome, {{ $student->fullname }}!
                </div>
                <div style="color:#6b7280; font-size:14px; line-height:1.6; margin-top:8px;">
                    Your student registration is now complete.
                </div>
            </td>
        </tr>

        {{-- Details Box --}}
        <tr>
            <td style="padding:24px; background-color:#f9fafb; border-radius:12px; margin-bottom:24px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50%" style="padding-bottom:16px; padding-right:12px;">
                            <div style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Student ID</div>
                            <div style="color:#1f2937; font-size:15px; font-weight:600; margin-top:4px;">
                                {{ $student->student_number }}
                            </div>
                        </td>
                        <td width="50%" style="padding-bottom:16px; padding-left:12px;">
                            <div style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Course</div>
                            <div style="color:#1f2937; font-size:15px; font-weight:600; margin-top:4px;">
                                {{ $student->course }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="padding-right:12px;">
                            <div style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Email</div>
                            <div style="color:#1f2937; font-size:15px; font-weight:600; margin-top:4px;">
                                {{ $student->email }}
                            </div>
                        </td>
                        <td width="50%" style="padding-left:12px;">
                            <div style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Phone</div>
                            <div style="color:#1f2937; font-size:15px; font-weight:600; margin-top:4px;">
                                {{ $student->phone ?: 'Not provided' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Next Steps --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:14px; font-weight:600; margin-bottom:12px;">
                    What's Next?
                </div>
                <div style="color:#6b7280; font-size:13px; line-height:1.8;">
                    <div style="margin-bottom:10px;">
                        <strong>1. Review Your Profile</strong> — Log in to your student portal and ensure all information is accurate.
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>2. Check Attendance</strong> — Monitor your attendance through the dashboard to stay on track.
                    </div>
                    <div>
                        <strong>3. Stay Updated</strong> — Check your email regularly for important course announcements and deadlines.
                    </div>
                </div>
            </td>
        </tr>

        {{-- CTA Button --}}
        <tr>
            <td style="text-align:center; padding:24px 0;">
                <a href="{{ config('app.url') }}/dashboard" style="display:inline-block; background:linear-gradient(135deg,#1d4ed8,#4338ca); color:#ffffff; text-decoration:none; font-weight:600; font-size:14px; padding:12px 32px; border-radius:8px;">
                    Go to Dashboard
                </a>
            </td>
        </tr>

        {{-- Support --}}
        <tr>
            <td style="padding-top:16px; border-top:1px solid #e5e7eb;">
                <div style="color:#9ca3af; font-size:12px; line-height:1.6; margin-top:16px;">
                    If you have any questions, please reach out to our support team or contact your course administrator.
                </div>
            </td>
        </tr>
    </table>
@endsection
