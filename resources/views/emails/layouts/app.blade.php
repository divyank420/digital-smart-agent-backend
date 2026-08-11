<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>@yield('title', config('app.name'))</title>
</head>

<body style="margin:0;padding:0;background:#f4f6fb;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:28px 12px;">
        <tr>
            <td align="center">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:560px;background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 18px 40px -22px rgba(0,29,65,.35);">
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#001d41 0%,#3a0a26 55%,#870a30 100%);padding:26px 28px;">
                            <table role="presentation" width="100%">
                                <tr>
                                    <td width="48" valign="middle" style="padding-right:12px;">
                                        <img src="{{ asset('images/app-icon.png') }}" width="44" height="44" alt="DSA"
                                            style="display:block;width:44px;height:44px;border:0;border-radius:12px;background:#ffffff;" />
                                    </td>
                                    <td valign="middle" style="color:#ffffff;font-family:'Segoe UI',Arial,sans-serif;">
                                        <div style="font-size:18px;font-weight:800;letter-spacing:.2px;">Digital Smart
                                            Agent</div>
                                        <div style="font-size:12px;color:rgba(255,255,255,.7);margin-top:2px;">We make
                                            your work easy</div>
                                    </td>
                                    <td align="right" valign="middle"
                                        style="color:rgba(255,255,255,.85);font-size:11px;font-weight:600;">
                                        SECURE LOGIN
                                    </td>
                                </tr>
                            </table>
                            <div style="display:inline-block;margin-top:14px;padding:6px 12px;border-radius:999px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);color:#ffd7a8;font-size:11px;font-weight:700;">⏳ UNDER PROCESS</div>
                        </td>
                    </tr>
                    @yield('content')
                    <tr>
                        <td
                            style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:18px 28px;text-align:center;">
                            <div style="font-size:12px;color:#94a3b8;">© <span>{{ date('Y') }}</span> Digital Smart Agent</div>
                            <div style="font-size:11px;color:#cbd5e1;margin-top:6px;">This is an automated message,
                                please do not reply.</div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
</body>

</html>