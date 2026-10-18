<div class="space-y-4">
    <!-- SUB AGENTS & POST OFFICE INPUTS -->
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="fld-label">Sub Agents (Ground Floor)</label>
            <input id="rf_sub" type="number" min="0" class="fld" placeholder="e.g. 12"
                wire:model.live='fieldAgents' />
        </div>
        <div class="sm:col-span-2">
            <label class="fld-label">Post Office (shown on Deposit Slips)</label>
            <input id="rf_po" class="fld" placeholder="e.g. Sector 14 HPO, Chandigarh"
                wire:model.live="postOffice" />
        </div>
    </div>

    <!-- PLAN SELECTION -->
    <div>
        <label class="fld-label">Choose your plan</label>
        <div class="space-y-2.5 mt-1">

            <!-- Base Plan -->
            @if(isset($plans['DSA Software (Base)']))
                @php $basePlan = $plans['DSA Software (Base)']; @endphp
                <div class="plan-card on" data-plan-id="{{ $basePlan->id }}">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" checked disabled class="mt-1 accent-current" />
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-display font-bold text-primary text-sm">{{ $basePlan->name }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-primary text-white px-2 py-0.5 rounded">Included</span>
                            </div>
                            <div class="text-[11px] text-primary/60 mt-0.5">Web admin console, customers, collections, reports</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">Base</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- DOP Agents Plan -->
            @if(isset($plans['Agents']))
                @php $agentPlan = $plans['Agents']; @endphp
                <div class="plan-card @if($hasAgent) on @endif" data-plan-id="{{ $agentPlan->id }}">
                    <div class="flex items-start gap-3">
                        <input id="pl_agent" type="checkbox" wire:model.live="hasAgent" class="mt-1 accent-current" />
                        <div class="flex-1 min-w-0">
                            <div class="font-display font-bold text-primary text-sm">{{ $agentPlan->name }}</div>
                            <div class="text-[11px] text-primary/60 mt-0.5">₹{{ $agentPlan->price }} / agent / month</div>
                            <div class="mt-2 flex items-center gap-2" @if(!$hasAgent) style="display:none;" @endif>
                                <label class="text-[11px] font-semibold text-primary/70">Agents:</label>
                                <select id="pl_agent_qty" class="fld !py-1.5 !text-xs w-auto" wire:model.live='noOfAgents'>
                                    @for ($var = 1; $var <= 10; $var++)
                                        <option value="{{ $var }}">{{ $var }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">₹{{ $agentPlan->price }}</div>
                            <div class="text-[10px] text-primary/50">per agent</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mobile Collection Application -->
            @if(isset($plans['Mobile Collection Application']))
                @php $mobilePlan = $plans['Mobile Collection Application']; @endphp
                <div class="plan-card @if($hasMobileApp) on @endif" data-plan-id="{{ $mobilePlan->id }}">
                    <div class="flex items-start gap-3">
                        <input id="pl_mob" type="checkbox" wire:model.live="hasMobileApp" class="mt-1 accent-current" />
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-display font-bold text-primary text-sm">{{ $mobilePlan->name }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded">3 Months Free Trial</span>
                            </div>
                            <div class="text-[11px] text-primary/60 mt-0.5">₹{{ $mobilePlan->price }} / month · Android app for on-field collections</div>

                            <div class="mt-2 flex flex-wrap gap-3 text-[11px] @if(!$hasMobileApp) hidden @endif">
                                <label class="inline-flex items-center gap-1.5">
                                    <input type="radio" name="pl_mob_mode" value="trial" wire:model.live="mobileAppMode" /> Start Free Trial (3 months)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- WhatsApp Automation Plan -->
            @if(isset($plans['WhatsApp Automation']))
                @php $waPlan = $plans['WhatsApp Automation']; @endphp
                <div class="plan-card @if($hasWhatsapp) on @endif" data-plan-id="{{ $waPlan->id }}">
                    <div class="flex items-start gap-3">
                        <input id="pl_wa" type="checkbox" wire:model.live="hasWhatsapp" class="mt-1 accent-current" />
                        <div class="flex-1 min-w-0">
                            <div class="font-display font-bold text-primary text-sm">{{ $waPlan->name }}</div>
                            <div class="text-[11px] text-primary/60 mt-0.5">₹{{ $waPlan->price }} / month · Auto receipts & reminders</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-primary text-sm">₹{{ $waPlan->price }}</div>
                            <div class="text-[10px] text-primary/50">/ month</div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- TOTALS SECTION -->
        <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
            <div>
                <div class="text-[10px] uppercase font-bold text-primary/50 tracking-wider">Total (Monthly)</div>
                <div id="rf_total_note" class="text-[11px] text-primary/60">Billed monthly · Cancel anytime</div>
            </div>
            <div class="text-right">
                <div class="font-display font-extrabold text-primary text-xl">₹<span>{{ $this->calculateTotal }}</span></div>
                <div class="text-[10px] text-primary/50">+ GST as applicable</div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-2 sm:gap-3 pt-4">
        <button wire:click="goToStep(2)"
            class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200 inline-flex items-center justify-center">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </button>
        <button wire:click="savePlans"
            class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">
            Continue to Payment <i class="fa-solid fa-arrow-right"></i>
        </button>
    </div>
</div>