// ==========================================
// SYSTEM CONFIGURATION AND GLOBAL ENGINES
// ==========================================
const ACCOUNT_SYNC_URL = "http://192.168.1.6:8000/api/dop_accounts_syncing";
const webview = document.getElementById('dop-live-webview');
let stepTracker = "LOGIN_PHASE";

// Global Runtime Cache Layer for Synchronization Re-testing Loops
let lastExtractedBackupPayload = null;

// Core HUD Overlay Graphical Controller 
function updateHUD(statusText, subtextText, isComplete = false) {
    const hud = document.getElementById('automation-hud');
    const status = document.getElementById('hud-status');
    const subtext = document.getElementById('hud-subtext');
    const spinner = document.querySelector('.hud-spinner');

    if (hud) hud.style.display = 'flex';
    if (status) status.innerText = statusText;
    if (subtext) subtext.innerText = subtextText;

    if (isComplete) {
        if (spinner) {
            spinner.style.animation = 'none';
            spinner.style.border = '4px solid #28a745';
            spinner.style.background = '#28a745';
        }
        setTimeout(() => {
            if (hud) hud.style.display = 'none';
        }, 4000);
    }
}

// ==========================================
// WEBVIEW TRACKING ENGINE & LIFECYCLE LISTENERS
// ==========================================
webview.addEventListener('console-message', (e) => {
    console.log(`[WEBVIEW INNER LOG] ${e.message}`);
});

webview.addEventListener('did-fail-load', (e) => {
    updateHUD("Connection Interrupted", "Server timed out. Re-establishing secure handshake link...", false);
});

webview.addEventListener('did-finish-load', () => {
    const currentUrl = webview.getURL();

    // PHASE 1: INITIAL COMPONENT HANDSHAKE
    if (stepTracker === 'LOGIN_PHASE' &&
        (currentUrl.includes("Finacle") || currentUrl.includes("HFormGroup") || currentUrl.includes("dashboard") || currentUrl.includes("AuthenticationController"))) {

        runCaptchaLoaderAutomation(webview);

        webview.executeJavaScript(`
            (function(){
                function findAccountsElement() {
                    let el = document.getElementById("Accounts") || 
                            document.querySelector("a[title*='Accounts']") || 
                            document.querySelector("a[href*='Accounts']");
                    if (el) return true;

                    const frames = document.querySelectorAll('iframe, frame');
                    for (let i = 0; i < frames.length; i++) {
                        try {
                            const frameDoc = frames[i].contentDocument || frames[i].contentWindow.document;
                            if (frameDoc.getElementById("Accounts") || 
                                frameDoc.querySelector("a[title*='Accounts']") || 
                                frameDoc.querySelector("a[href*='Accounts']")) {
                                return true;
                            }
                        } catch(e) {}
                    }
                    return false;
                }
                return findAccountsElement();
            })()
        `).then(accountsTabExists => {
            if (accountsTabExists) {
                updateHUD("1. Handshake Verified", "Security token validated. Setting up environment components...", false);
                stepTracker = "CLICKED_ACCOUNTS";
                runAccountsTabAutomation(webview);
            }
        });

        if (currentUrl.includes("Finacle") || currentUrl.includes("HFormGroup") || currentUrl.includes("dashboard")) {
            return;
        }
    }

    // PHASE 2: ENVIRONMENT EXTRACTION ROUTING
    if (stepTracker === 'CLICKED_ACCOUNTS') {
        updateHUD("2. Preparing Package Installation", "Configuring application workspaces for sync operations...", false);
        stepTracker = "CLICKED_AGENT_ENQUIRY";

        setTimeout(() => {
            runAgentEnquiryAutomation(webview);
        }, 2500);
        return;
    }

    // PHASE 3: COMPILING TARGET RUNTIME
    if (stepTracker === 'CLICKED_AGENT_ENQUIRY') {
        updateHUD("3. Extracting Package Files", "Decompressing data arrays into dynamic session pools...", false);
        stepTracker = "PARSING_PDF_DATA";

        setTimeout(() => {
            startPdfDataExtraction(webview);
        }, 2000);
        return;
    }
});

// Intercept structured telemetry messages and swap them into professional installation text
webview.addEventListener('console-message', (e) => {
    const logMessage = e.message;

    // Standard HUD signals updates
    if (logMessage.includes("HUD_SIGNAL:EXTRACTING_PAYLOAD")) {
        updateHUD("4. Parsing Core Dependencies", "Analyzing structural schema frameworks. Processing elements...", false);
    }
    
    // Catch the raw data payload passing over our custom communications bridge (Bypasses Portal CSP)
    if (logMessage.startsWith("DATA_PAYLOAD_BRIDGE:")) {
        try {
            // Extract the raw string layout following our prefix marker token
            const rawJsonString = logMessage.substring("DATA_PAYLOAD_BRIDGE:".length);
            
            // Local Memory Cache Assignment
            lastExtractedBackupPayload = JSON.parse(rawJsonString);
            
            // Hide standard retry triggers on fresh ingestion runs
            document.getElementById('hud-retry-container').style.display = 'none';

            // Transfer directly into the API network sync engine
            executeDatabaseSynchronization(lastExtractedBackupPayload);

        } catch (jsonError) {
            console.error("Data serialization pipeline failure:", jsonError);
            updateHUD("❌ Process Aborted", "Data translation failure in app runtime layer.", false);
        }
    }
});

// ==========================================
// OUTBOUND COMMUNICATIONS PIPELINE SUBSYSTEM
// ==========================================
function executeDatabaseSynchronization(payloadArray) {
    if (!payloadArray || payloadArray.length === 0) {
        updateHUD("❌ Process Aborted", "No structured payload data discovered to send.", false);
        return;
    }

    updateHUD("5. Synchronizing System Database", "Writing configuration files and updating core registries...", false);

    // Structure wrapped array parameters matching Laravel Input specs
    const wrappedPayload = {
        data: payloadArray
    };

    fetch(ACCOUNT_SYNC_URL, {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'Accept': 'application/json' 
        },
        body: JSON.stringify(wrappedPayload)
    })
    .then(res => {
        if (!res.ok) throw new Error("Server backend rejection response status code.");
        return res.json();
    })
    .then(data => {
        // Success: Wipe active error hooks from layout view and complete loop
        document.getElementById('hud-retry-container').style.display = 'none';
        updateHUD("🎉 Configuration Successfully Completed!", "All system modules have been successfully synchronized.", true);
    })
    .catch(err => {
        console.error("Outbound API Delivery Aborted:", err);
        updateHUD("❌ Process Aborted", "Database storage sync failed. Installation sequence terminated.", false);
        
        // Expose testing manual override action selector element
        const retryContainer = document.getElementById('hud-retry-container');
        if (retryContainer) {
            retryContainer.style.display = 'block';
        }
    });
}

// Manual Test Injection Handler
function retryLastCachedPayload() {
    console.log("🔄 Dispatching sync transaction using cache memory context storage...");
    if (lastExtractedBackupPayload) {
        // Reset loader graphics state back to loading spinner behavior 
        const spinner = document.querySelector('.hud-spinner');
        if (spinner) {
            spinner.style.animation = 'spin 1s linear infinite';
            spinner.style.border = '4px solid #f3f3f3';
            spinner.style.borderTop = '4px solid #0056b3';
            spinner.style.background = 'none';
        }
        executeDatabaseSynchronization(lastExtractedBackupPayload);
    } else {
        alert("Active memory contains no data packets. Run full pipeline automation sequence first.");
    }
}

// ==========================================
// BACKGROUND INJECTION AUTOMATION CORE ACTIONS
// ==========================================
function runCaptchaLoaderAutomation(webview) {
    webview.executeJavaScript(`
        (function() {
            const capImg = document.getElementById('IMAGECAPTCHA') || document.getElementById('bpcaptcha') || document.querySelector('img[src*="captcha"]');
            if (!capImg) return null;
            
            const canvas = document.createElement('canvas');
            canvas.width = capImg.naturalWidth || capImg.width;
            canvas.height = capImg.naturalHeight || capImg.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(capImg, 0, 0);
            
            return canvas.toDataURL('image/png');
        })()
    `).then(base64Data => {
        const loadingText = document.getElementById('loading-text');
        const previewImg = document.getElementById('custom-captcha-preview');
        if (base64Data && base64Data !== "data:," && base64Data.startsWith("data:image")) {
            if (loadingText) loadingText.style.display = 'none';
            if (previewImg) {
                previewImg.src = base64Data;
                previewImg.style.display = 'block';
            }
        }
    }).catch(err => {
        console.error("[CAPTCHA PREVIEW ERROR]:", err);
    });
}

function runAccountsTabAutomation(webview) {
    webview.executeJavaScript(`
        (function(){
            let accountsRetryCount = 0;
            const maxAccountsRetries = 30;

            function findElementEverywhere(selector) {
                let el = document.querySelector(selector);
                if (el) return el;
                const frames = document.querySelectorAll('iframe, frame');
                for (let i = 0; i < frames.length; i++) {
                    try {
                        const frameDoc = frames[i].contentDocument || frames[i].contentWindow.document;
                        let frameEl = frameDoc.querySelector(selector);
                        if (frameEl) return frameEl;
                    } catch (e) {}
                }
                return null;
            }

            function tryClickAccountsTab() {
                const accountsTab = findElementEverywhere("#Accounts, a[title*='Accounts'], a[href*='Accounts'], span[id*='Accounts']");
                if (accountsTab) {
                    if (accountsTab.focus) accountsTab.focus();
                    accountsTab.click();
                    return "ACCOUNTS_CLICKED";
                }
                if (accountsRetryCount < maxAccountsRetries) {
                    accountsRetryCount++;
                    setTimeout(tryClickAccountsTab, 300); 
                }
            }
            tryClickAccountsTab();
        })()
    `);
}

function runAgentEnquiryAutomation(webview) {
    webview.executeJavaScript(`
        (function() {
            let enquiryRetryCount = 0;
            const maxEnquiryRetries = 30;

            function findElementEverywhere(selector) {
                let el = document.querySelector(selector);
                if (el) return el;
                const frames = document.querySelectorAll('iframe, frame');
                for (let i = 0; i < frames.length; i++) {
                    try {
                        const frameDoc = frames[i].contentDocument || frames[i].contentWindow.document;
                        let frameEl = frameDoc.querySelector(selector);
                        if (frameEl) return frameEl;
                    } catch (e) {}
                }
                return null;
            }

            function tryClickEnquiryLink() {
                const enquiryBtn = findElementEverywhere("a[id='Agent Enquire & Update Screen']");
                if (enquiryBtn) {
                    if (enquiryBtn.focus) enquiryBtn.focus();
                    enquiryBtn.click();
                    return "ENQUIRY_CLICKED";
                }
                if (enquiryRetryCount < maxEnquiryRetries) {
                    enquiryRetryCount++;
                    setTimeout(tryClickEnquiryLink, 300);
                }
            }
            tryClickEnquiryLink();
        })()
    `);
}

function startPdfDataExtraction(webview) {
    webview.executeJavaScript(`
        (function() {
            const frames = document.querySelectorAll('iframe, frame');
            let targetWindow = window;
            let targetDoc = document;

            for (let i = 0; i < frames.length; i++) {
                try {
                    const doc = frames[i].contentDocument || frames[i].contentWindow.document;
                    if (doc.getElementById('HREF_printPreview') || doc.getElementById('printpreview')) {
                        targetDoc = doc;
                        targetWindow = frames[i].contentWindow;
                        break;
                    }
                } catch(e) {}
            }

            targetWindow.open = function(url) {
                console.log("HUD_SIGNAL:EXTRACTING_PAYLOAD");

                fetch(url)
                    .then(response => response.text())
                    .then(htmlString => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(htmlString, 'text/html');
                        let reportRowsLog = [];
                        const tables = doc.querySelectorAll('table');
                        
                        tables.forEach((table, tIndex) => {
                            const rows = table.querySelectorAll('tr');
                            rows.forEach((row, rIndex) => {
                                const cells = Array.from(row.querySelectorAll('td, th')).map(cell => cell.textContent.trim());
                                if (cells.length > 0) {
                                    reportRowsLog.push({
                                        tableIndex: tIndex,
                                        rowIndex: rIndex,
                                        dataFields: cells
                                    });
                                }
                            });
                        });

                        console.log("DATA_PAYLOAD_BRIDGE:" + JSON.stringify(reportRowsLog));
                    });
                return null;
            };

            const printTriggerBtn = targetDoc.getElementById('HREF_printPreview');
            if (printTriggerBtn) {
                printTriggerBtn.click();
            }
        })()
    `);
}

// ==========================================
// INTERACTIVE COMPONENT ASSIGNMENTS
// ==========================================
function executeDopLogin() {
    const agentId = document.getElementById('custom-username').value;
    const agentPass = document.getElementById('custom-password').value;
    const captchaVal = document.getElementById('custom-captcha-input').value;

    updateHUD("Initializing System Configuration", "Loading encryption keys and structural frameworks...", false);

    webview.executeJavaScript(`
        (function() {
            const idInput = document.getElementById('AuthenticationFG.USER_PRINCIPAL');
            const passInput = document.getElementById('AuthenticationFG.ACCESS_CODE');
            const capInput = document.getElementById('AuthenticationFG.VERIFICATION_CODE');
            const submitBtn = document.getElementById('VALIDATE_RM_PLUS_CREDENTIALS_CATCHA_DISABLED');

            if (idInput && passInput && capInput) {
                idInput.value = \`${agentId}\`;
                passInput.value = \`${agentPass}\`;
                capInput.value = \`${captchaVal}\`;

                const events = ['input', 'change', 'blur'];
                events.forEach(ev => {
                    idInput.dispatchEvent(new Event(ev, { bubbles: true }));
                    passInput.dispatchEvent(new Event(ev, { bubbles: true }));
                    capInput.dispatchEvent(new Event(ev, { bubbles: true }));
                });

                if (submitBtn) {
                    submitBtn.click();
                    return "SUBMITTED";
                }
            }
            return "FIELDS_MISSING";
        })()
    `);
}