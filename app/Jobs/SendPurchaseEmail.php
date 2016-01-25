<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\User;

class SendPurchaseEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $user;
    protected $card_number;
    protected $card_pin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $card_number, $card_pin)
	{
		$this->user = User::find($user_id);
		$this->card_number = $card_number;
		$this->card_pin = $card_pin;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
	    $user = $this->user;
	    $email = $this->user->email;

	    $mailer->send('sell.emails.purchased_cards', 
			    [
				    'user' => $user,
				    'cardnumber' => $this->card_number,
				    'pin' => $this->card_pin
			    ], 
			    function ($m) use ($user) {
				    $m->to($user->email, $user->name)
				    	->subject('Your gift cards');
			    }
	     );
	     $this->delete();
    }
}
