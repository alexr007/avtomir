<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 16.02.2017
 * Time: 11:05
 */
class SOAP {
    private $origin;
    private $ws_path;
    private $ws_params;
    private $ws_access;

    public function __construct($path, $params, $access) {
        $this->origin = new CList();
        $this->ws_path = $path;
        $this->ws_params = $params;
        $this->ws_access = $access;
    }

    protected function SoapConnection()
    {
        if (!$this->origin->count()) {
            $this->origin->add(new SoapClient($this->ws_path, $this->ws_params));
        }
        return $this->origin->itemAt(0);
    }

    public function query($function, $params = []) {
        switch (count($params))	{
            case 0 : $response=$this->SoapConnection()->$function($this->ws_access);
                    break;
            case 1 : $response=$this->SoapConnection()->$function($params[0], $this->ws_access);
                    break;
            case 2 : $response=$this->SoapConnection()->$function($params[0],$params[1], $this->ws_access);
                    break;
            case 3 : $response=$this->SoapConnection()->$function($params[0],$params[1],$params[2], $this->ws_access);
                    break;
        }
        if (is_soap_fault($response)) {
            echo "SOAP error";
            $response = false;
        }
        return $response;
    }
}