<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Digital Smart Agent Portal</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .mt-4 {
            margin-top: 20px;
        }

        .w-100 {
            width: 100%;
        }

        .btn {
            padding: 10px;
            cursor: pointer;
        }
        
        .hud-spinner {
            border: 4px solid #f3f3f3; 
            border-top: 4px solid #0056b3; 
            border-radius: 50%; 
            width: 40px; 
            height: 40px; 
            animation: spin 1s linear infinite; 
            margin: 0 auto 20px;
        }
    </style>
</head>

<body>
    <div style="display: flex; width: 100%; height: 85vh;">

        <div style="width: 40%; padding: 20px; border-right: 1px solid #ccc;">
            <h3>Link India Post Portal</h3>
            <hr>

            <div class="form-group">
                <label>Agent ID (User ID):</label>
                <input type="text" id="custom-username" class="form-control" placeholder="Enter Agent ID"
                    value="DOP.MIG0032042">
            </div>

            <div class="form-group mt-2">
                <label>Portal Password:</label>
                <input type="password" id="custom-password" class="form-control" placeholder="Enter Password"
                    value="Khatod&5413">
            </div>

            <div class="form-group mt-3">
                <label>Security Verification Code:</label>
                <div id="captcha-container" style="margin: 10px 0;">
                    <span id="loading-text" style="color:gray;">Extracting secure CAPTCHA...</span>
                    <img id="custom-captcha-preview" src=""
                        style="display:none; border:1px solid #999; max-height: 70px;" />
                </div>
                <input type="text" id="custom-captcha-input" class="form-control" placeholder="Enter CAPTCHA text">
            </div>

            <button onclick="executeDopLogin()" class="btn btn-primary w-100 mt-4">Secure Sign In</button>
            <button id="startPortalBtn" class="btn btn-primary mt-2">Open India Post Portal</button>
        </div>

        <div id="automation-hud"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.75); z-index: 99999; font-family: 'Segoe UI', Arial, sans-serif; align-items: center; justify-content: center;">
            <div style="background: #ffffff; padding: 30px; border-radius: 8px; width: 450px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                
                <div class="hud-spinner"></div>

                <h3 id="hud-status" style="margin: 0 0 10px 0; color: #333333; font-size: 1.2rem;">Initializing System...</h3>
                <p id="hud-subtext" style="margin: 0 0 20px 0; color: #666666; font-size: 0.9rem;">Starting background sequence handler.</p>

                <div id="hud-retry-container" style="display: none; margin-bottom: 20px;">
                    <button type="button" onclick="retryLastCachedPayload()" style="background: #dc3545; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        🔄 Retry API Sync Operation
                    </button>
                </div>

                <div style="background: #f8f9fa; padding: 12px; border-radius: 5px; border-left: 4px solid #ffc107; text-align: left;">
                    <span style="font-size: 0.85rem; color: #555555; font-weight: bold; display: block;">⏳ Operational Notice:</span>
                    <span style="font-size: 0.8rem; color: #777777;">Please wait. Configuration & extraction takes roughly 3-4 minutes. Do not close your application.</span>
                </div>
            </div>
        </div>

        <style>
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

        <div style="width: 60%; height: 100%; background: #fafafa;">
            <webview id="dop-live-webview"
                src="https://dopagent.indiapost.gov.in/corp/AuthenticationController?FORMSGROUP_ID__=AuthenticationFG&__START_TRAN_FLAG__=Y&__FG_BUTTONS__=LOAD&ACTION.LOAD=Y&AuthenticationFG.LOGIN_FLAG=3&BANK_ID=DOP&AGENT_FLAG=Y"
                style="width: 100%; height: 100%;"
                useragent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36">
            </webview>
        </div>
    </div>
    <script src="{{ asset('dop/login_account_sync.js') }}"></script>
</body>

</html>