<div class="space-y-4">
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="fld-label">Company / Firm Name</label>
            <input type="text" class="fld" wire:model.blur="company_name" placeholder="e.g. Kumar & Sons RD Agency" />
            @error('company_name')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div>
            <label class="fld-label">Requestor Name (Owner)</label>
            <input class="fld" wire:model="owner_name" placeholder="Owner's full name" />
            @error('owner_name')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div>
            <label class="fld-label">Mobile Number</label>
            <input class="fld" wire:model="mobile" placeholder="10-digit mobile" maxlength="10" />
            @error('mobile')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div>
            <label class="fld-label">Email</label>
            <input type="email" wire:model="email" class="fld" placeholder="you@company.com" />
            @error('email')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div>
            <label class="fld-label">DOP ID <small class="text-black-900 text-[9px]">(Make sure DOP.MIG*** is correct)</small></label>
            <input class="fld" wire:model="dop_id" placeholder="DOP.MIG*****" />
            @error('dop_id')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div>
            <label class="fld-label">DOP Password <small class="text-black-900 text-[9px]">(Make sure DOP Password is correct)</small></label>
            <input type="text" wire:model="dop_password" class="fld" placeholder="DOP Portal Password" />
            @error('dop_password')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 sm:gap-3 pt-4">
        <button onclick="closeRequestModal()"
            class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200">Cancel</button>
        <button wire:click="goToStep(3)"
            class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200">3</button>
        <button wire:click="submitStepOne" wire:loading.attr="disabled"
            class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">
            <span wire:loading.remove wire:target="submitStepOne" >
                Continue
                <i class="fa-solid fa-arrow-right"></i>
            </span>

            <span wire:loading wire:target="submitStepOne" class="inline-flex items-center gap-2">
                <i class="fa-solid fa-spinner fa-spin"></i>
                Processing...
            </span>
        </button>
    </div>
</div>
