<?php

namespace App\Jobs;

use App\Helper\Helper;
use App\Models\SavingRm;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRmEntryPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rmId;
    protected $amount;
    /**
     * Create a new job instance.
     */
    public function __construct($rmId, $amount)
    {
        $this->rmId = $rmId;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rmDetail = SavingRm::with('customer')->where('id', $this->rmId)->first();

        if (!$rmDetail || !$rmDetail->customer) {
            return;
        }

        $title = 'Payment Received';
        $body = 'We have received your installment of ₹' . $this->amount . ' for your RD account.';
        $data = [
            'rm_id' => $this->rmId,
            'amount' => $this->amount,
            'redirection' => 'rm_collection_detail'
        ];

        Helper::pushNotification($rmDetail->customer, $title, $body, $data);
    }
}
