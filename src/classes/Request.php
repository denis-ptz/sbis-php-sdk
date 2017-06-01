<?php

class Request
{
    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->data = array(
            "jsonrpc" => JSONRPC,
            "protocol" => PROTOCOL,
            "id" => 0
        );
    }

    /**
     * @param bool $error
     * @return array|bool|string
     */
    public function getSessionId($error = false)
    {
        $filename = './' . FILE_SESSION_ID;
        if (file_exists($filename) and $error == false) {
            $sessionId = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
            if(empty($sessionId)){
                $this->getSessionId(true);
            }
        } else {
            $params = array(
                "login" => SBIS_LOGIN,
                "password" => SBIS_PASS
            );
            $this->data["method"] = "САП.Аутентифицировать";
            $this->data["params"] = $params;
            $sessionId = $this->Curl($this->data, SBIS_HOST);
            $this->addSessionId($sessionId);

        }
        return $sessionId;
    }

    /**
     * @param $sessionId
     */
    private function addSessionId($sessionId)
    {
        $fp = fopen('./' . FILE_SESSION_ID, 'w+');
        fwrite($fp, $sessionId);
        fclose($fp);
    }

    /**
     * @param $dataPost
     * @param $host
     * @param bool $sessionId
     * @return array|string
     */
    function Curl($dataPost, $host, $sessionId = false)
    {
        $dataString = json_encode($dataPost);

        $arHeader = array(
            'Host: ' . $host,
            'Content-Type: application/json-rpc;charset=utf-8',
            'Accept: application/json-rpc',
            'Content-Length: ' . strlen($dataString)
        );

        if ($sessionId) {
            $param = '/partner_api/service/';

            $strSessionId = 'X-SBISSessionID: ' . $sessionId;
            array_push($arHeader, $strSessionId);
        } else {
            $param = '/auth/service/';
        }

        $server = "https://$host$param";
        $ch = curl_init($server);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arHeader);

        $result = curl_exec($ch);

        $arrCurl = json_decode($result);

        if (!empty($arrCurl->{'result'})) {

            $decodeResult = $arrCurl->{'result'};

        } elseif (!empty($arrCurl->{'error'})) {

            if ($arrCurl->{'error'} == "Not authorized.") {
                $sessionId = $this->getSessionId(true);
                $decodeResult = $this->Curl($dataPost, $host, $sessionId);
            } else {
                $decodeResult = $arrCurl->{'error'}->message;
            }

        } else {

            if ($arrCurl->{'result'} == NULL) {
                $decodeResult = "Пустой ответ";
            } else {
                $decodeResult = $arrCurl->{'error'}->message;
            }

        }
        return $decodeResult;
    }
}