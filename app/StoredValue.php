<?php

namespace App;

use Illuminate\Support\Facades\Log;
require_once '/home/robert/work/projects/gb/gbservermage/SVClientUtility/Utility.php';
require_once '/home/robert/work/projects/gb/gbservermage/lib/SVClient/lib/SVClient/SVResetCardPin.php';

class StoredValue 
{
	const SVPropertiesPath = '/home/robert/work/projects/gb/gbservermage/SVClientUtility/TEST0QA_gc_serverobj.properties';
	public function __construct()
	{
	}
	
	public function checkBalance($card_num, $pin)
	{
		$txnId = (new \Utility())->getTxnId();
		$svProperties = $this->getSVProperties();
		$svRequest = \GCWebPos::balanceEnquiry($svProperties, 
			$card_num, 
			$pin, 
			$txnId, 
			'', 
			''
		);
		$svResponse = $svRequest->execute();
		return $svResponse;
	}

	public function changePin($card_num)
	{
		$txnId = (new \Utility())->getTxnId();
		$svProperties = $this->getSVProperties();
		$svRequest = \GCWebPos::resetCardPin(
			$svProperties, 
			$card_num,
			$txnId
		);

		$svResponse = $svRequest->execute();
		return $svResponse;
	}

	public function deActivateCard($card_num)
	{
		$svProperties = $this->getSVProperties();
		$txnId = (new \Utility())->getTxnId();
		$svRequest = \GCWebPos::deactivate($svProperties, 
			$card_num,  
			$txnId
		);

		$svResponse = $svRequest->execute();

		var_dump($svResponse);
	}

	private function getSVProperties()
	{
		return \SVServerData::load(self::SVPropertiesPath);
	}
}
