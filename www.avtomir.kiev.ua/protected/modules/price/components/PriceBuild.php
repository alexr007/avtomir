<?php

class PriceBuild extends CComponent
{
	private $isGuest;
	private $userId;
	private $k;
	
	public function __construct(IRuntimeUser $user)
	{
		$this->isGuest = $user->isGuest();
		$this->userId = $user->id();
		$this->k = null;
	}

	// цена клиента
	public function price($value)
	{
		if (!$this->k) {
            $this->getClientMultiply();
        }

		return $value * $this->k;
	}

    // коэф. клиента
    private function getClientMultiply()
    {
        $val = $this->isGuest
            ? (new Parameter('user', 'default_k'))->value()
            : UserProfile::getValueByUserField($this->userId, 'price_k');

        $this->k = 1 + $val/100;
    }
}