<div class=" space-y-4">
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
            <label class="upi-opt"><input type="radio" name="upi_app" value="gpay" checked class="hidden" /><i
                    class="fa-brands fa-google-pay text-lg"></i><span class="text-[10px] mt-1">GPay</span></label>
            <label class="upi-opt"><input type="radio" name="upi_app" value="phonepe" class="hidden" /><i
                    class="fa-solid fa-mobile-screen text-lg"></i><span class="text-[10px] mt-1">PhonePe</span></label>
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
        <div class="text-[11px] text-primary/50 mt-2 flex items-center gap-1"><i class="fa-solid fa-shield-halved"></i>
            Card & wallet not supported · Only UPI accepted</div>
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
