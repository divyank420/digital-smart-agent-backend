<div class="modal-panel p-5 sm:p-7 md:p-9">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <div class="text-[10px] font-bold uppercase tracking-[.2em] text-accent">Get Started</div>
            <h3 class="font-display font-extrabold text-xl sm:text-2xl text-primary mt-1">Request Digital Smart Agent
            </h3>
            <p class="text-primary/60 text-xs sm:text-sm mt-1">Tell us about your firm and we'll set up your account.
            </p>
        </div>
        <button onclick="closeRequestModal()"
            class="w-9 h-9 flex-shrink-0 rounded-full bg-slate-100 text-primary hover:bg-slate-200"><i
                class="fa-solid fa-xmark"></i></button>
    </div>

    <!-- Stepper -->
    <div class="flex items-center gap-1.5 sm:gap-3 mt-5 sm:mt-6 mb-5 sm:mb-6">
        <div class="flex items-center gap-2"><span id="dot1" class="step-dot gradient-bg text-white">1</span><span
                class="hidden md:inline text-xs font-bold text-primary">Basic</span></div>
        <div class="flex-1 h-[2px] bg-slate-200 rounded">
            <div id="stepBar" class="h-full w-[10%] rounded gradient-bg transition-all"></div>
        </div>
        <div class="flex items-center gap-2"><span id="dot2"
                class="step-dot bg-slate-200 text-slate-500">2</span><span
                class="hidden md:inline text-xs font-bold text-slate-500">OTP</span></div>
        <div class="flex-1 h-[2px] bg-slate-200 rounded"></div>
        <div class="flex items-center gap-2"><span id="dot3"
                class="step-dot bg-slate-200 text-slate-500">3</span><span
                class="hidden md:inline text-xs font-bold text-slate-500">Plan</span></div>
        <div class="flex-1 h-[2px] bg-slate-200 rounded"></div>
        <div class="flex items-center gap-2"><span id="dot4"
                class="step-dot bg-slate-200 text-slate-500">4</span><span
                class="hidden md:inline text-xs font-bold text-slate-500">Payment</span></div>
    </div>

    <!-- STEP 1 -->
    <div id="step1" class="space-y-4">
        <div class="grid sm:grid-cols-2 gap-4">
            <div><label class="fld-label">Company / Firm Name</label><input id="rf_company" class="fld"
                    placeholder="e.g. Kumar & Sons Agency" /></div>
            <div><label class="fld-label">Requestor Name (Owner)</label><input id="rf_owner" class="fld"
                    placeholder="Owner's full name" /></div>
            <div><label class="fld-label">Mobile Number</label><input id="rf_mobile" class="fld"
                    placeholder="10-digit mobile" maxlength="10" /></div>
            <div><label class="fld-label">Email</label><input id="rf_email" type="email" class="fld"
                    placeholder="you@company.com" /></div>
        </div>
        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 sm:gap-3 pt-4">
            <button onclick="closeRequestModal()"
                class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200">Cancel</button>
            <button onclick="rfNext(1)"
                class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">Continue
                <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- STEP 2 : OTP -->
    <div id="step2" class="hidden space-y-4">
        <div class="rounded-2xl p-5 bg-gradient-to-br from-slate-50 to-white border border-slate-200 text-center">
            <div class="w-14 h-14 rounded-full gradient-bg text-white flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-mobile-screen"></i>
            </div>
            <div class="font-display font-bold text-primary mt-3">Verify your mobile</div>
            <div class="text-xs text-primary/60 mt-1">A 6-digit code was sent to <span id="otpTo"
                    class="font-semibold text-primary">—</span></div>
            <div class="flex justify-center flex-wrap gap-1.5 sm:gap-2 mt-5" id="otpWrap">
                <input class="otp-box" maxlength="1" /><input class="otp-box" maxlength="1" /><input class="otp-box"
                    maxlength="1" />
                <input class="otp-box" maxlength="1" /><input class="otp-box" maxlength="1" /><input class="otp-box"
                    maxlength="1" />
            </div>
            <div class="text-[11px] text-primary/50 mt-3">Didn't receive it? <button
                    class="text-accent font-semibold hover:underline" onclick="alert('OTP resent')">Resend</button>
            </div>
        </div>
        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-2 sm:gap-3 pt-2">
            <button onclick="rfBack(2)"
                class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200 inline-flex items-center justify-center"><i
                    class="fa-solid fa-arrow-left mr-1"></i> Back</button>
            <button onclick="rfNext(2)"
                class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">Verify
                & Continue <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- STEP 3 : PLAN + DETAILS -->
    <div id="step3" class="hidden space-y-4">
        <div class="grid sm:grid-cols-2 gap-4">
            <div><label class="fld-label">Total DOP Agents</label><input id="rf_dop" type="number" min="1"
                    class="fld" placeholder="e.g. 5" /></div>
            <div><label class="fld-label">Sub Agents (Ground Floor)</label><input id="rf_sub" type="number"
                    min="0" class="fld" placeholder="e.g. 12" /></div>
            <div class="sm:col-span-2"><label class="fld-label">Post Office (shown on Deposit Slips)</label><input
                    id="rf_po" class="fld" placeholder="e.g. Sector 14 HPO, Chandigarh" /></div>
        </div>

        <!-- PLAN SELECTION -->
        <div>
            <label class="fld-label">Choose your plan</label>
            <div class="space-y-2.5 mt-1">
                <!-- Software (default, locked on) -->
                <div class="plan-card on">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" checked disabled class="mt-1 accent-current" />
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-display font-bold text-primary text-sm">DSA Software</span>
                                <span
                                    class="text-[10px] font-bold uppercase tracking-wider bg-primary text-white px-2 py-0.5 rounded">Included</span>
                            </div>
                            <div class="text-[11px] text-primary/60 mt-0.5">Web admin console, customers,
                                collections, reports</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">Base</div>
                        </div>
                    </div>
                </div>

                <!-- Agents -->
                <div class="plan-card on">
                    <div class="flex items-start gap-3">
                        <input id="pl_agent" type="checkbox" checked class="mt-1 accent-current"
                            onchange="this.closest('.plan-card').classList.toggle('on',this.checked); calcTotal()" />
                        <div class="flex-1 min-w-0">
                            <div class="font-display font-bold text-primary text-sm">DOP Agents</div>
                            <div class="text-[11px] text-primary/60 mt-0.5">₹150 / agent / month</div>
                            <div class="mt-2 flex items-center gap-2">
                                <label class="text-[11px] font-semibold text-primary/70">Agents:</label>
                                <select id="pl_agent_qty" class="fld !py-1.5 !text-xs w-auto" onchange="calcTotal()">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">₹150</div>
                            <div class="text-[10px] text-primary/50">per agent</div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Collection App -->
                <div class="plan-card">
                    <div class="flex items-start gap-3">
                        <input id="pl_mob" type="checkbox" class="mt-1 accent-current"
                            onchange="this.closest('.plan-card').classList.toggle('on',this.checked); document.getElementById('pl_mob_opts').classList.toggle('hidden',!this.checked); calcTotal()" />
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-display font-bold text-primary text-sm">Mobile Collection
                                    App</span>
                                <span
                                    class="text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">3
                                    Months Free Trial</span>
                            </div>
                            <div class="text-[11px] text-primary/60 mt-0.5">₹250 / month · Android app for on-field
                                collections</div>
                            <div id="pl_mob_opts" class="hidden mt-2 flex flex-wrap gap-3 text-[11px]">
                                <label class="inline-flex items-center gap-1.5"><input type="radio"
                                        name="pl_mob_mode" value="trial" checked onchange="calcTotal()" /> Start
                                    Free Trial (3 months)</label>
                                <label class="inline-flex items-center gap-1.5"><input type="radio"
                                        name="pl_mob_mode" value="paid" onchange="calcTotal()" /> Pay now
                                    (₹250/mo)</label>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">₹250</div>
                            <div class="text-[10px] text-primary/50">/ month</div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="plan-card">
                    <div class="flex items-start gap-3">
                        <input id="pl_wa" type="checkbox" class="mt-1 accent-current"
                            onchange="this.closest('.plan-card').classList.toggle('on',this.checked); calcTotal()" />
                        <div class="flex-1 min-w-0">
                            <div class="font-display font-bold text-primary text-sm">WhatsApp Automation</div>
                            <div class="text-[11px] text-primary/60 mt-0.5">₹200 / month · Auto receipts &
                                reminders</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">₹200</div>
                            <div class="text-[10px] text-primary/50">/ month</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Totals -->
            <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                <div>
                    <div class="text-[10px] uppercase font-bold text-primary/50 tracking-wider">Total (Monthly)
                    </div>
                    <div id="rf_total_note" class="text-[11px] text-primary/60"></div>
                </div>
                <div class="text-right">
                    <div class="font-display font-extrabold text-primary text-xl">₹<span id="rf_total">150</span>
                    </div>
                    <div class="text-[10px] text-primary/50">+ GST as applicable</div>
                </div>
            </div>
        </div>

        <div>
            <label class="fld-label">Automation goals (select all that apply)</label>
            <div class="flex flex-wrap gap-2 mt-1">
                <label class="chip-choice"><input type="checkbox" class="hidden"
                        onchange="this.parentElement.classList.toggle('on',this.checked)"><i
                        class="fa-solid fa-briefcase"></i> Workplace Position</label>
                <label class="chip-choice"><input type="checkbox" class="hidden"
                        onchange="this.parentElement.classList.toggle('on',this.checked)"><i
                        class="fa-solid fa-tower-broadcast"></i> Auto DOP Portal Sync</label>
                <label class="chip-choice"><input type="checkbox" class="hidden"
                        onchange="this.parentElement.classList.toggle('on',this.checked)"><i
                        class="fa-solid fa-layer-group"></i> Bulk Lot Builder</label>
                <label class="chip-choice"><input type="checkbox" class="hidden"
                        onchange="this.parentElement.classList.toggle('on',this.checked)"><i
                        class="fa-brands fa-whatsapp"></i> WhatsApp Receipts</label>
                <label class="chip-choice"><input type="checkbox" class="hidden"
                        onchange="this.parentElement.classList.toggle('on',this.checked)"><i
                        class="fa-solid fa-file-invoice-dollar"></i> Commission / TDS</label>
                <label class="chip-choice"><input type="checkbox" class="hidden"
                        onchange="this.parentElement.classList.toggle('on',this.checked)"><i
                        class="fa-solid fa-chart-line"></i> PDF/Excel Reports</label>
            </div>
        </div>
        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-2 sm:gap-3 pt-4">
            <button onclick="rfBack(3)"
                class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200 inline-flex items-center justify-center"><i
                    class="fa-solid fa-arrow-left mr-1"></i> Back</button>
            <button onclick="rfNext(3)"
                class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">Continue
                to Payment <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- STEP 4 : PAYMENT (Razorpay UPI only) -->
    <div id="step4" class="hidden space-y-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <div class="font-display font-bold text-primary text-sm">Razorpay · UPI</div>
                        <div class="text-[11px] text-primary/60">No extra charges · UPI only</div>
                    </div>
                </div>
                <span
                    class="text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">0%
                    fees</span>
            </div>

            <div id="rf_summary" class="mt-4 divide-y divide-slate-100 text-sm"></div>

            <div class="mt-3 flex items-center justify-between border-t border-dashed border-slate-300 pt-3">
                <div class="text-xs font-bold text-primary/70 uppercase tracking-wider">Payable now</div>
                <div class="font-display font-extrabold text-primary text-2xl">₹<span id="rf_payable">0</span>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-[11px] font-bold uppercase tracking-wider text-primary/60 mb-2">Pay using UPI</div>
            <div class="grid grid-cols-4 gap-2">
                <label class="upi-opt"><input type="radio" name="upi_app" value="gpay" checked
                        class="hidden" /><i class="fa-brands fa-google-pay text-lg"></i><span
                        class="text-[10px] mt-1">GPay</span></label>
                <label class="upi-opt"><input type="radio" name="upi_app" value="phonepe" class="hidden" /><i
                        class="fa-solid fa-mobile-screen text-lg"></i><span
                        class="text-[10px] mt-1">PhonePe</span></label>
                <label class="upi-opt"><input type="radio" name="upi_app" value="paytm" class="hidden" /><i
                        class="fa-solid fa-wallet text-lg"></i><span class="text-[10px] mt-1">Paytm</span></label>
                <label class="upi-opt"><input type="radio" name="upi_app" value="other" class="hidden" /><i
                        class="fa-solid fa-qrcode text-lg"></i><span class="text-[10px] mt-1">UPI
                        ID</span></label>
            </div>
            <div class="mt-3">
                <label class="fld-label">UPI ID (optional)</label>
                <input id="rf_upi" class="fld" placeholder="yourname@okhdfc" />
            </div>
            <div class="text-[11px] text-primary/50 mt-2 flex items-center gap-1"><i
                    class="fa-solid fa-shield-halved"></i> Card & wallet not supported · Only UPI accepted</div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-2 sm:gap-3 pt-2">
            <button onclick="rfBack(4)"
                class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200 inline-flex items-center justify-center"><i
                    class="fa-solid fa-arrow-left mr-1"></i> Back</button>
            <button onclick="rfPay()"
                class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">Pay
                ₹<span id="rf_pay_btn">0</span> via UPI <i class="fa-solid fa-lock"></i></button>
        </div>
    </div>

    <!-- SUCCESS -->
    <div id="stepDone" class="hidden text-center py-6">
        <div class="success-tick"><i class="fa-solid fa-check"></i></div>
        <h3 class="font-display font-extrabold text-2xl text-primary mt-5">Request Received!</h3>
        <p class="text-primary/60 mt-2 max-w-md mx-auto">Thank you. Our team will contact you within one business
            day to activate your Digital Smart Agent workspace.</p>
        <button onclick="closeRequestModal()"
            class="btn-primary mt-6 px-6 py-3 rounded-xl text-sm font-semibold">Done</button>
    </div>
</div>
