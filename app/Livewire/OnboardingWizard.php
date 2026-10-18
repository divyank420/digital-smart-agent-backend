<?php

namespace App\Livewire;

use App\Mail\OtpMail;
use App\Mail\UnderProcessMail;
use App\Models\DopAgent;
use App\Models\OnboardingRequest;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

class OnboardingWizard extends Component
{
    public $step = 1;

    public $company_name;
    public $owner_name;
    public $mobile;
    public $email;
    public $otp;
    public $dop_id;
    public $dop_password;
    public $resendAvailable = false;
    public $noOfAgents = 1;
    public $fieldAgents = 1;
    public $postOffice = '';

    public $hasAgent = true; // Checked by default in your UI
    public $hasMobileApp = false;
    public $mobileAppMode = 'trial'; // 'trial' or 'paid'
    public $hasWhatsapp = false;


    public function submitStepOne()
    {
        $this->validate([
            'company_name' => ['required', 'min:3', 'max:150'],
            'owner_name' => ['required', 'min:3', 'max:150'],
            'mobile' => ['required', 'digits:10', 'regex:/^[6-9][0-9]{9}$/'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'dop_id' => ['required', 'max:255'],
            'dop_password' => ['required', 'max:255']
        ]);
        $existing = OnboardingRequest::where('mobile', $this->mobile)
            ->where('status', '!=', 'expired')
            ->latest()
            ->first();

        if ($existing && $existing->expires_at > now()) {
            $this->addError('mobile', 'An OTP request already exists. Please verify your OTP.');
            return;
        }

        $agents = DopAgent::where('dop_id', $this->dop_id)->first();
        if ($agents) {
            $this->addError('dop_id', 'DOP Agent already registered, Try with different agent id ');
            return;
        }

        $otp = random_int(100000, 999999);
        /*
        |--------------------------------------------------------------------------
        | Save Temporary Request
        |--------------------------------------------------------------------------
        */

        $request = OnboardingRequest::create([

            'uuid' => Str::uuid(),
            'company_name' => $this->company_name,
            'owner_name' => $this->owner_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'dop_id' => $this->dop_id,
            'dop_password' => $this->dop_password,
            'otp_hash' => Hash::make($otp),
            'otp_sent_at' => now(),
            'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0,
            'otp_verified' => false,
            'status' => 'started',
            'current_step' => 2,
            'expires_at' => now()->addMinutes(10),
        ]);
        /*
        |--------------------------------------------------------------------------
        | Send OTP
        |--------------------------------------------------------------------------
        */
        $this->sendEmailOtp(
            $this->owner_name,
            $otp,
            $this->email
        );

        session()->put(
            'onboarding_uuid',
            $request->uuid
        );
        $this->step = 2;
        $this->dispatch(
            'otp-sent',
            mobile: $this->mobile
        );
    }

    public function resendOtp()
    {
        $request = OnboardingRequest::where(
            'uuid',
            session('onboarding_uuid')
        )->first();


        if (!$request) {
            $this->addError('otp', 'Request expired.');
            return;
        }

        // Generate new OTP
        $otp = random_int(100000, 999999);

        $request->update([
            'otp_hash' => Hash::make($otp),
            'otp_sent_at' => now(),
            'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0,
        ]);

        $this->sendEmailOtp(
            $request->mobile,
            $otp,
            $this->email
        );

        $this->dispatch(
            'otp-reset'
        );
    }
    private function sendMobileOtp($mobile, $otp)
    {
        Mail::to('divyank@mailinator.com')->send(
            new OtpMail(
                name: 'Virat Gandhi',
                otp: '458721'
            )
        );
    }
    private function sendEmailOtp($name, $otp,$email)
    {
        Mail::to($email)->send(
            new OtpMail(
                name: $name,
                otp: $otp
            )
        );
    }
    private function sendUnderProgressEmail($name, $otp)
    {
        Mail::to('divyank@mailinator.com')->send(
            new OtpMail(
                name: $name,
                otp: $otp
            )
        );
    }

    public function goToStep($step)
    {
        $this->step = $step;
    }

    public function verifyOtp()
    {
        $this->validate([
            'otp' => ['required', 'digits:6']
        ]);

        $request = OnboardingRequest::where(
            'uuid',
            session('onboarding_uuid')
        )->first();

        if (!$request) {
            $this->addError('otp', 'Your onboarding session has expired. Please start again.');
            $this->step = 1;
            return;
        }
        if ($request->otp_verified) {
            $this->step = 3;
            return;
        }
        if (
            !$request->otp_expires_at ||
            now()->greaterThan($request->otp_expires_at)
        ) {
            $this->addError(
                'otp',
                'OTP has expired. Please resend a new OTP.'
            );

            return;
        }
        if ($request->otp_attempts >= 5) {
            $this->addError(
                'otp',
                'Maximum OTP attempts exceeded. Please resend OTP.'
            );

            return;
        }
        if (!Hash::check($this->otp, $request->otp_hash)) {

            $request->increment('otp_attempts');

            $remainingAttempts = 5 - ($request->otp_attempts + 1);

            if ($remainingAttempts > 0) {

                $this->addError(
                    'otp',
                    "Invalid OTP. {$remainingAttempts} attempt(s) remaining."
                );
            } else {

                $this->addError(
                    'otp',
                    'Maximum OTP attempts exceeded. Please resend OTP.'
                );
            }

            return;
        }
        $request->update([
            'otp_verified' => true,
            'otp_hash' => null,
            'otp_attempts' => 0,
            'current_step' => 3,
            'status' => 'otp_verified',
        ]);
        $this->reset('otp');
        $this->step = 3;
    }

    #[Computed]
    public function calculateTotal()
    {
        $total = 0;
        if ($this->hasAgent) {
            $total += 150 * max(1, (int)$this->noOfAgents);
        }
        if ($this->hasMobileApp && $this->mobileAppMode === 'paid') {
            $total += 250;
        }
        if ($this->hasWhatsapp) {
            $total += 200;
        }
        return $total;
    }

    public function savePlans()
    {
        $request = OnboardingRequest::where(
            'uuid',
            session('onboarding_uuid')
        )->first();

        // Fetch all active plans indexed by name for quick lookup
        $plans = Plan::all()->keyBy('name');

        $selectedPlans = [];

        // Base Software
        $basePlan = $plans->get('DSA Software (Base)');
        if ($basePlan) {
            $selectedPlans[] = [
                'plan_id'      => $basePlan->id,
                'name'         => $basePlan->name,
                'type'         => $basePlan->type,
                'price'        => $basePlan->price,
                'billing_type' => 'Included',
                'quantity'     => 1,
            ];
        }

        // DOP Agents
        if ($this->hasAgent && isset($plans['Agents'])) {
            $agentPlan = $plans['Agents'];
            $qty       = max(1, (int)$this->noOfAgents);

            $selectedPlans[] = [
                'plan_id'      => $agentPlan->id,
                'name'         => $agentPlan->name,
                'type'         => $agentPlan->type,
                'price'        => $agentPlan->price,
                'billing_type' => $agentPlan->billing_type,
                'quantity'     => $qty,
                'total'        => $agentPlan->price * $qty,
            ];
        }

        // Mobile Collection Application
        if ($this->hasMobileApp && isset($plans['Mobile Collection Application'])) {
            $mobilePlan = $plans['Mobile Collection Application'];

            $selectedPlans[] = [
                'plan_id'      => $mobilePlan->id,
                'name'         => $mobilePlan->name,
                'type'         => $mobilePlan->type,
                'price'        => $this->mobileAppMode === 'paid' ? $mobilePlan->price : 0,
                'billing_type' => $this->mobileAppMode === 'trial' ? 'Free (3 mo trial)' : $mobilePlan->billing_type,
                'quantity'     => 1,
                'mode'         => $this->mobileAppMode,
            ];
        }

        // WhatsApp Automation
        if ($this->hasWhatsapp && isset($plans['WhatsApp Automation'])) {
            $waPlan = $plans['WhatsApp Automation'];

            $selectedPlans[] = [
                'plan_id'      => $waPlan->id,
                'name'         => $waPlan->name,
                'type'         => $waPlan->type,
                'price'        => $waPlan->price,
                'billing_type' => $waPlan->billing_type,
                'quantity'     => 1,
            ];
        }

        $request->update([
            'selected_plans' => $selectedPlans,
            'current_step'   => 3,
            'status'         => 'submitted',
            'post_office'   => $this->postOffice,
            'dop_agents'    => max(1, (int)$this->noOfAgents),
            'sub_agents'     => max(1, (int)$this->fieldAgents),
        ]);

        $this->step = 5;
    }

    public function render()
    {
        $plans = Plan::all()->keyBy('name');
        return view('livewire.onboarding-wizard',compact('plans'));
    }
}
