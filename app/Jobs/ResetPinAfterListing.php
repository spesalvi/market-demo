<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\GiftCard;
use App\StoredValue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt; 
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPinAfterListing extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $card;
	protected $card_number;
	protected $pin;

    public function __construct($card_id, $card_number, $pin)
	{
		$this->card = GiftCard::find($card_id);
		Log::notice("card_id:" .  $this->card->id);
		$this->card_number = $card_number;
		$this->pin = $pin;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(StoredValue $sv)
	{
		$card_num = $this->card_number;
		$pin = Crypt::decrypt($this->pin);

		$checkBalanceResponse = $sv->checkBalance($card_num, $pin);
		if($checkBalanceResponse->getErrorCode() != 0)
		{
			//fail the job.	

		}

		$resetResponse = $sv->changePin($card_num);
		if($resetResponse->getErrorCode() != 0) {
			//retry?	
		}

		$pin = $resetResponse->getCardPin();

		Log::info('new pin ' . $pin);
		$this->card->pin = Crypt::encrypt($pin);
		$this->card->save();

		$this->delete();	
	}
}
