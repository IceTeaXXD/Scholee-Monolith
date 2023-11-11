<?php
class SOAP{
    private $wsdl;
    private $key;

    private $client;

    private $streamContext;

    public function __construct($wsdl){
        $this->key = SOAP_KEY;
        $this->$wsdl = WSDL;

        $this->streamContext = stream_context_create(
            array(
                'http' => array(
                    'header' => "X-API-KEY: ".SOAP_KEY
                )
            )
        );
        $url = WSDL.$wsdl;
        $this->client = new SoapClient($url, array('trace' => 1, 'stream_context' => $this->streamContext));
    }

    public function doRequest($method, $param){
        try{
            $response = $this->client->$method($param);
            return $response;
        }catch(SoapFault $e){
            return $e->getMessage();
        }
    }
}