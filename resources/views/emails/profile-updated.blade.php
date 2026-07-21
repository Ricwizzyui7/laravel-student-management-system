@extends('emails.layout')

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        {{-- Greeting --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:20px; font-weight:600; line-height:1.4;">
                    Your Profile Has Been Updated
                </div>
                <div style="color:#6b7280; font-size:14px; line-height:1.6; margin-top:8px;">
                    Hi {{ $user->name }}, we noticed changes to your account profile.
                </div>
            </td>
        </tr>

        {{-- Change Summary --}}
        @if(count($changedFields) > 0)
            <tr>
                <td style="padding:24px; background-color:#f0fdf4; border-left:4px solid #10b981; margin-bottom:24px;">
                    <div style="color:#166534; font-size:13px; font-weight:600; margin-bottom:12px;">
                        Updated Fields:
                    </div>
                    <div style="color:#15803d; font-size:13px; line-height:1.8;">
                        @foreach($changedFields as $field)
                            <div>• {{ $field }}</div>
                        @endforeach
                    </div>
                </td>
            </tr>
        @endif

        {{-- Security Notice --}}
        <tr>
            <td style="padding:24px; background-color:#fef3c7; border-left:4px solid #f59e0b; margin-bottom:24px;">
                <div style="color:#92400e; font-size:13px; line-height:1.6;">
                    <strong>Security Tip:</strong> If you did not make these changes, please reset your password immediately and contact support.
                </div>
            </td>
        </tr>

        {{-- CTA Buttons --}}
        <tr>
            <td style="text-align:center; padding:24px 0;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                    <tr>
                        <td style="padding-right:12px;">
                            <a href="{{ config('app.url') }}/profile" style="display:inline-block; background:linear-gradient(135deg,#1d4ed8,#4338ca); color:#ffffff; text-decoration:none; font-weight:600; font-size:14px; padding:12px 28px; border-radius:8px;">
                                View Profile
                            </a>
                        </td>
                        <td>
                            <a href="{{ config('app.url') }}/profile#password" style="display:inline-block; background:#e5e7eb; color:#1f2937; text-decoration:none; font-weight:600; font-size:14px; padding:12px 28px; border-radius:8px;">
                                Change Password
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Support --}}
        <tr>
            <td style="padding-top:16px; border-top:1px solid #e5e7eb;">
                <div style="color:#9ca3af; font-size:12px; line-height:1.6; margin-top:16px;">
                    Questions? Contact our support team at any time.
                </div>
            </td>
        </tr>
    </table>
@endsection
