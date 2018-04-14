<?php

class WeightBuild extends CComponent
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

    // корректировка веса
    public function weight($value)
    {
        if (!$this->k) {
            $this->getClientMultiply();
        }

        return $value * $this->k;
    }

    // коэф. клиента
    private function getClientMultiply()
    {
        $val = //$this->isGuest
            //?
        (new Parameter('user', 'default_k_weight'))->value();
            //: UserProfile::getValueByUserField($this->userId, 'price_k');

        $this->k = 1 + $val/100;
    }
}