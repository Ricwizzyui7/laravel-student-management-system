@extends('emails.layout')

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        {{-- Greeting --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:20px; font-weight:600; line-height:1.4;">
                    {{ __('Reset Your Password') }}
                </div>
                <div style="color:#6b7280; font-size:14px; line-height:1.6; margin-top:8px;">
                    {{ __('Hi :name, we received a request to reset your password. Click the button below to create a new one.', ['name' => $userName]) }}
                </div>
            </td>
        </tr>

        {{-- CTA Button --}}
        <tr>
            <td style="text-align:center; padding:32px 0;">
                <a href="{{ $resetUrl }}" style="display:inline-block; background:linear-gradient(135deg,#1d4ed8,#4338ca); color:#ffffff; text-decoration:none; font-weight:600; font-size:15px; padding:14px 36px; border-radius:8px;">
                    {{ __('Reset Password') }}
                </a>
            </td>
        </tr>

        {{-- Expiration Notice --}}
        <tr>
            <td style="text-align:center; padding-bottom:24px;">
                <div style="color:#9ca3af; font-size:12px;">
                    {{ __('This link expires in :minutes minutes.', ['minutes' => $expireMinutes]) }}
                </div>
            </td>
        </tr>

        {{-- Manual Link --}}
        <tr>
            <td style="padding:24px; background-color:#f9fafb; border-radius:8px; margin-bottom:24px;">
                <div style="color:#9ca3af; font-size:11px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                    {{ __('Or copy this link:') }}
                </div>
                <div style="color:#1f2937; font-size:12px; word-break:break-all; font-family:monospace;">
                    {{ $resetUrl }}
                </div>
            </td>
        </tr>

        {{-- Security Alert --}}
        <tr>
            <td style="padding:24px; background-color:#fef3c7; border-left:4px solid #f59e0b; margin-bottom:24px;">
                <div style="color:#92400e; font-size:13px; line-height:1.6;">
                    <strong>{{ __('Security:') }}</strong> {{ __('If you did not request a password reset, ignore this email. Your account remains secure.') }}
                </div>
            </td>
        </tr>

        {{-- Steps --}}
        <tr>
            <td style="padding-bottom:24px;">
                <div style="color:#1f2937; font-size:14px; font-weight:600; margin-bottom:12px;">
                    {{ __('After Resetting Your Password') }}
                </div>
                <div style="color:#6b7280; font-size:13px; line-height:1.8;">
                    <div style="margin-bottom:10px;">
                        <strong>{{ __('1. Log In') }}</strong>{{ __(' — Use your new password to access your account.') }}
                    </div>
                    <div style="margin-bottom:10px;">
                        <strong>{{ __('2. Update Other Services') }}</strong>{{ __(' — Change your password on any related accounts if you use the same password.') }}
                    </div>
                    <div>
                        <strong>{{ __('3. Secure Your Account') }}</strong>{{ __(' — Consider enabling two-factor authentication for added security.') }}
                    </div>
                </div>
            </td>
        </tr>

        {{-- Support --}}
        <tr>
            <td style="padding-top:16px; border-top:1px solid #e5e7eb;">
                <div style="color:#9ca3af; font-size:12px; line-height:1.6; margin-top:16px;">
                    {{ __('Need help? Contact our support team.') }}
                </div>
            </td>
        </tr>
    </table>
@endsection
