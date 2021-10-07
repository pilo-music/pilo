<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        try {
            $client = new Client();
            $result = $client->post("https://rest.payamak-panel.com/api/SendSMS/SendSMS", [
                RequestOptions::JSON => [
                    "username" => config("pilo.melipayamak_username"),
                    "password" => config("pilo.melipayamak_password"),
                    "from" => config("pilo.melipayamak_number"),
                    "to" => $this->phone,
                    "text" => "Pilo code " . $this->code,
                ]
            ])->getBody()->getContents();

            $result = json_decode($result, true, 512, JSON_THROW_ON_ERROR);

            if (!isset($result["RetStatus"]) || $result["RetStatus"] != 1) {
                $this->fail();
            }
        } catch (\Exception | GuzzleException $e) {
            $this->fail($e);
        }
    }
}
