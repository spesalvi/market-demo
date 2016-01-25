<?php

namespace App\Jobs;

use App\Jobs\Job;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt; 

use App\User;
use App\StoredValue;
use App\GiftCard;

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
    public function __construct($user_id, $card_id)
	{
		$this->user = User::find($user_id);
		$card = GiftCard::find($card_id);
		$this->card_number = $card->card_number;
		$this->card_pin = $this->resetPin();

		$card->encyrpted_pin = Crypt::encrypt($this->card_pin);
		$card->save();
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

	private function resetPin()
	{
		$sv = new StoredValue();
		$resetResponse = $sv->changePin($this->card_number);
		if($resetResponse->getErrorCode() != 0)
		{
			Log::error('unable to reset pin');
			
			//discard or retry
		}
		Log::notice('pin after reset while sending purchase mail '. $resetResponse->getCardPin());
		return $resetResponse->getCardPin();
	}
}
