<div class="space-y-4" x-data="{
    seconds: 60,
    timer: null,
    startTimer() {
        clearInterval(this.timer);
        this.seconds = 60;
        this.timer = setInterval(() => {
            if (this.seconds > 0) {
                this.seconds--;
            } else {
                clearInterval(this.timer);
            }
        }, 1000);

    }
}" x-init="startTimer()" @otp-reset.window="startTimer()">

    <div class="rounded-2xl p-5 bg-gradient-to-br from-slate-50 to-white border border-slate-200 text-center">
        <div class="w-14 h-14 rounded-full gradient-bg text-white flex items-center justify-center mx-auto text-xl">
            <i class="fa-solid fa-email-screen"></i>
        </div>
        <div class="font-display font-bold text-primary mt-3">Verify your Email Address</div>
        <div class="text-xs text-primary/60 mt-1">A 6-digit code was sent to <span id="otpTo"
                class="font-semibold text-primary">{{ $this->email }}</span></div>
        <div class="flex justify-center flex-wrap gap-1.5 sm:gap-2 mt-5" x-data="{
            otp: ['', '', '', '', '', ''],
        
            getInputs() {
                return this.$root.querySelectorAll('.otp-box');
            },
        
            updateOtp() {
                $wire.set('otp', this.otp.join(''));
            },
        
            focusNext(index) {
        
                this.updateOtp();
        
                let inputs = this.getInputs();
        
                if (
                    this.otp[index] &&
                    index < inputs.length - 1
                ) {
                    inputs[index + 1].focus();
                }
            },
        
            focusBack(index, event) {
        
                if (event.key !== 'Backspace') {
                    return;
                }
        
                let inputs = this.getInputs();
        
                if (
                    !this.otp[index] &&
                    index > 0
                ) {
                    inputs[index - 1].focus();
                }
        
                this.updateOtp();
            },
            pasteOtp(event) {
        
                event.preventDefault();
        
                let value = event.clipboardData
                    .getData('text')
                    .replace(/[^0-9]/g, '')
                    .substring(0, 6);
        
        
                let digits = value.split('');
        
        
                this.otp = [
                    ...digits,
                    ...Array(6 - digits.length).fill('')
                ];
        
        
                this.updateOtp();
        
        
                let inputs = this.getInputs();
        
        
                setTimeout(() => {
        
                    if (value.length < 6) {
        
                        inputs[value.length]?.focus();
        
                    } else {
        
                        inputs[5]?.focus();
        
                    }
        
                }, 50);
        
            }
        }">


            <template x-for="(digit,index) in otp" :key="index">

                <input class="otp-box text-center" maxlength="1" inputmode="numeric" x-model="otp[index]"
                    @input="
            otp[index] = $event.target.value.replace(/[^0-9]/g,'');
            focusNext(index);
        "
                    @keydown.backspace="
            focusBack(index,$event)
        " @paste="pasteOtp($event)">

            </template>


        </div>
        <div class="text-[11px] text-primary/50 mt-3">
            <span>
                Didn't receive it?
            </span>
            <span x-show="seconds > 0" class="inline-flex items-center gap-1">
                Resend OTP in
                <span class="text-accent font-semibold">
                    00:<span x-text="String(seconds).padStart(2, '0')"></span> sec
                </span>
            </span>
            <button x-show="seconds === 0" wire:click="resendOtp" class="text-accent font-semibold hover:underline">
                Resend OTP
            </button>
        </div>
    </div>
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-2 sm:gap-3 pt-2">
        <button wire:click="goToStep(1)"
            class="px-5 py-3 rounded-xl text-sm font-semibold text-primary bg-slate-100 hover:bg-slate-200 inline-flex items-center justify-center"><i
                class="fa-solid fa-arrow-left mr-1"></i> Back</button>
        <button wire:click="verifyOtp" wire:loading.attr="disabled"
            class="btn-primary px-6 py-3 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">
            <span wire:loading.remove>
                Verify & Continue
            </span>
            <span wire:loading>
                Verifying...
            </span>
            <i class="fa-solid fa-arrow-right"></i></button>
    </div>
</div>
