<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 05.03.2017
 * Time: 20:11
 */
class DealerResponse
{
    private $dealer;

    function __construct($dealer) {
        $this->dealer = $dealer;
    }

    private function put($code, $type) {
        $dbDealerLog = new DbDealerLog();
        $dbDealerLog->dl_date = new DbCurrentTimestamp();
        $dbDealerLog->dl_dealer = $this->dealer;
        $dbDealerLog->dl_status = (int)$code;
        $dbDealerLog->dl_type = (int)$type;
        //new DumpExit($dbDealerLog->attributes, false);
        $dbDealerLog->save();
    }

    function putRequest($code, $strict = false) {
        if ($strict||$code) {
            $this->put($code, 0); // 0 - mean standard request
        }
    }

    function putToken($code, $strict = false) {
        if ($strict||$code) {
            $this->put($code, 1); // 1 - mean token request
        }
    }
}