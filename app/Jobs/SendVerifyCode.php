<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendVerifyCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $phone, private $code)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $result = Http::post("https://rest.payamak-panel.com/api/SendSMS/SendSMS", [
            "username" => config("pilo.melipayamak_username"),
            "password" => config("pilo.melipayamak_password"),
            "from" => config("pilo.melipayamak_number"),
            "to" => $this->phone,
            "text" => "Pilo code " . $this->code,
        ])->json();

        if (!isset($result["RetStatus"]) || $result["RetStatus"] != 1) {
            $this->fail();
        }
    }
}
