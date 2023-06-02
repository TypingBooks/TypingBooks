<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDiscordMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messageContent;
    protected $hookToUse;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messageContent, $hookToUse = null)
    {
        $this->messageContent = $messageContent;
        $this->hookToUse = $hookToUse;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // I won't care too much if this is leaked...
        $hookAddress = '';
        
        if(isset($this->hookToUse)) {
            
            $hookAddress = $this->hookToUse;
            
        }
        
        $post = [
            'content' => $this->messageContent,
        ];
        
        $ch = curl_init($hookAddress);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
        $response = curl_exec($ch);
        
        curl_close($ch);
        
    }
}
