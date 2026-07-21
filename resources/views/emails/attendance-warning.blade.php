@extends('emails.layout')

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        {{-- Greeting --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:20px; font-weight:600; line-height:1.4;">
                    Attendance Alert
                </div>
                <div style="color:#6b7280; font-size:14px; line-height:1.6; margin-top:8px;">
                    Hi {{ $student->fullname }}, your attendance has dropped below the required threshold.
                </div>
            </td>
        </tr>

        {{-- Alert Box --}}
        <tr>
            <td style="padding:24px; background-color:#fef2f2; border-left:4px solid #dc2626; margin-bottom:24px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="60%">
                            <div style="color:#991b1b; font-size:12px; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Current Attendance</div>
                            <div style="color:#7f1d1d; font-size:32px; font-weight:700; margin-top:8px;">
                                {{ $percentage }}%
                            </div>
                        </td>
                        <td width="40%" style="text-align:right;">
                            <div style="color:#991b1b; font-size:12px; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Required Minimum</div>
                            <div style="color:#7f1d1d; font-size:32px; font-weight:700; margin-top:8px;">
                                {{ $threshold }}%
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Details --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:14px; font-weight:600; margin-bottom:12px;">
                    Course Information
                </div>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border-radius:8px;">
                    <tr>
                        <td style="padding:12px; border-bottom:1px solid #e5e7eb;">
                            <div style="color:#9ca3af; font-size:11px; text-transform:uppercase;">Course</div>
                            <div style="color:#1f2937; font-size:14px; font-weight:500; margin-top:2px;">
                                {{ $student->course }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:12px;">
                            <div style="color:#9ca3af; font-size:11px; text-transform:uppercase;">Student ID</div>
                            <div style="color:#1f2937; font-size:14px; font-weight:500; margin-top:2px;">
                                {{ $student->student_number }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Action Steps --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:14px; font-weight:600; margin-bottom:12px;">
                    What You Should Do
                </div>
                <div style="color:#6b7280; font-size:13px; line-height:1.8;">
                    <div style="margin-bottom:10px;">
                        <strong>1. Review Your Records</strong> — Check the attendance dashboard to see your current status.
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>2. Attend Classes</strong> — Make it a priority to attend all upcoming classes.
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>3. Contact Your Instructor</strong> — If you have extenuating circumstances, reach out to discuss options.
                    </div>
                    <div>
                        <strong>4. Talk to Support</strong> — Our student support team is here to help you get back on track.
                    </div>
                </div>
            </td>
        </tr>

        {{-- CTA Button --}}
        <tr>
            <td style="text-align:center; padding:24px 0;">
                <a href="{{ config('app.url') }}/attendance/student/{{ $student->id }}" style="display:inline-block; background:linear-gradient(135deg,#1d4ed8,#4338ca); color:#ffffff; text-decoration:none; font-weight:600; font-size:14px; padding:12px 32px; border-radius:8px;">
                    View Attendance
                </a>
            </td>
        </tr>

        {{-- Support --}}
        <tr>
            <td style="padding-top:16px; border-top:1px solid #e5e7eb;">
                <div style="color:#9ca3af; font-size:12px; line-height:1.6; margin-top:16px;">
                    Questions? Our support team is available to assist you.
                </div>
            </td>
        </tr>
    </table>
@endsection
