@extends('emails.layouts.app')
@section('title', 'Email Verification')
@section('content')
    <tr>
        <td style="padding:32px 28px 8px 28px;">
            <h1 style="margin:0;font-size:21px;color:#001d41;font-weight:800;">Verify your email</h1>
            <p style="margin:10px 0 0;font-size:14px;line-height:22px;color:#475569;">
                Hi <strong style="color:#001d41;">{{ ucwords($name) }}</strong>, use the one-time password below to continue
                your Digital Smart Agent registration.
            </p>
        </td>
    </tr>

    <tr>
        <td style="padding:22px 28px;">
            <div
                style="border:1px dashed rgba(135,10,48,.35);background:#fff5f7;border-radius:16px;padding:20px;text-align:center;">
                <div style="font-size:11px;letter-spacing:.14em;color:#870a30;font-weight:700;">ONE-TIME PASSWORD</div>
                <div style="margin-top:10px;font-size:36px;letter-spacing:.34em;font-weight:800;color:#001d41;">
                    {{ $otp }}</div>
                <div style="margin-top:10px;font-size:12px;color:#64748b;">This code expires in <strong
                        style="color:#800000;">10 minutes</strong>.</div>
            </div>
        </td>
    </tr>
@endsection
