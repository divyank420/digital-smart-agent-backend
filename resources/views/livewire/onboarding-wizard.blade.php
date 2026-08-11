<div class="modal-panel p-5 sm:p-7 md:p-9">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <div class="text-[10px] font-bold uppercase tracking-[.2em] text-accent">Get Started</div>
            <h3 class="font-display font-extrabold text-xl sm:text-2xl text-primary mt-1">Onboarding Request</h3>
            <p class="text-primary/60 text-xs sm:text-sm mt-1">Tell us about your firm and we'll set up your account.
            </p>
        </div>
        <button onclick="closeRequestModal()"
            class="w-9 h-9 flex-shrink-0 rounded-full bg-slate-100 text-primary hover:bg-slate-200"><i
                class="fa-solid fa-xmark"></i></button>
    </div>

    <!-- Stepper -->
    <div class="flex items-center gap-1.5 sm:gap-3 mt-5 sm:mt-6 mb-5 sm:mb-6">
        {{-- Step 1 --}}
        <div class="flex items-center gap-2">
            <span class="step-dot {{ $step >= 1 ? 'gradient-bg text-white' : 'bg-slate-200 text-slate-500' }}">
                1
            </span>
            <span class="hidden md:inline text-xs font-bold {{ $step >= 1 ? 'text-primary' : 'text-slate-500' }}">
                Basic
            </span>
        </div>
        {{-- Line --}}
        <div class="flex-1 h-[2px] bg-slate-200 rounded">
            <div class="h-full rounded gradient-bg transition-all" style="width: {{ $step >= 2 ? '100%' : '10%' }}">
            </div>
        </div>
        {{-- Step 2 --}}
        <div class="flex items-center gap-2">
            <span class="step-dot {{ $step >= 2 ? 'gradient-bg text-white' : 'bg-slate-200 text-slate-500' }}">
                2
            </span>
            <span class="hidden md:inline text-xs font-bold {{ $step >= 2 ? 'text-primary' : 'text-slate-500' }}">
                OTP
            </span>
        </div>
        {{-- Line --}}
        <div class="flex-1 h-[2px] bg-slate-200 rounded">
            <div class="h-full rounded gradient-bg transition-all" style="width: {{ $step >= 3 ? '100%' : '10%' }}">
            </div>
        </div>
        {{-- Step 3 --}}
        <div class="flex items-center gap-2">
            <span class="step-dot {{ $step >= 3 ? 'gradient-bg text-white' : 'bg-slate-200 text-slate-500' }}">
                3
            </span>
            <span class="hidden md:inline text-xs font-bold {{ $step >= 3 ? 'text-primary' : 'text-slate-500' }}">
                Plan
            </span>
        </div>
        {{-- Line --}}
        <div class="flex-1 h-[2px] bg-slate-200 rounded">
            <div class="h-full rounded gradient-bg transition-all" style="width: {{ $step >= 4 ? '100%' : '10%' }}">
            </div>
        </div>
        {{-- Step 4 --}}
        <div class="flex items-center gap-2">
            <span class="step-dot {{ $step >= 4 ? 'gradient-bg text-white' : 'bg-slate-200 text-slate-500' }}">
                4
            </span>
            <span class="hidden md:inline text-xs font-bold {{ $step >= 4 ? 'text-primary' : 'text-slate-500' }}">
                Payment
            </span>
        </div>
    </div>

    @if ($step == 1)
        <!-- STEP 1 -->
        @include('livewire.onboarding.step-one')
    @elseif($step == 2)
        <!-- STEP 2 : OTP -->
        @include('livewire.onboarding.step-two')
    @elseif($step == 3)
        <!-- STEP 3 : PLAN + DETAILS -->
        @include('livewire.onboarding.step-three')
    @elseif($step == 4)
        <!-- STEP 4 : PAYMENT (Razorpay UPI only) -->
        @include('livewire.onboarding.step-four')
    @elseif($step == 5)
        <!-- SUCCESS -->
        @include('livewire.onboarding.success')
    @endif

</div>
