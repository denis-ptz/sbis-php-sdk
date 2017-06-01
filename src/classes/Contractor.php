<?php

class Contractor extends Request
{
    /**
     * @param $inn
     * @return array|string
     *
     * Метод ищет в базе Биллинга контрагента с указанным ИНН.
     */
    function FindByINNandKPP($inn)
    {
        $method = __CLASS__ . '.' . __FUNCTION__;
        $params = array(
            "INN" => $inn,
            "KPP" => null
        );
        $this->data["method"] = $method;
        $this->data["params"] = $params;

        $contractorId = $this->Curl($this->data, SBIS_HOST, $this->getSessionId());

        return $contractorId;
    }

    /**
     * @param $id
     * @return array|string
     *
     * Если контрагент с указанным идентификатором существует в базе Биллинга, то возвращается массив с информацией
     * по котрагенту
     */
    function InfoByID($id)
    {
        $method = __CLASS__ . '.' . __FUNCTION__;
        $params = array(
            "ContractorID" => $id
        );
        $this->data["method"] = $method;
        $this->data["params"] = $params;

        $arInfo = $this->Curl($this->data, SBIS_HOST, $this->getSessionId());

        return $arInfo;
    }
}