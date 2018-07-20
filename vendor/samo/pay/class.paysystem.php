<?php

abstract class PaySystem implements ISamoPaySystem {

    const PAY_STATUS_STR_PAYED = 'payed';
    const PAY_STATUS_STR_WAIT = 'wait';
    const PAY_STATUS_STR_CANCEL = 'cancel';
    const PAY_STATUS_STR_HOLD = 'hold';
    const PAY_STATUS_STR_ERROR = 'error';

    const PAY_STATUS_INT_PAYED = 1;
    const PAY_STATUS_INT_WAIT = 2;
    const PAY_STATUS_INT_CANCEL = 3;
    const PAY_STATUS_INT_HOLD = 4;
    const PAY_STATUS_INT_ERROR = 5;

    const PAY_OK = 1;

    protected function getValidCurrency($sCurrency) {
        return $sCurrency != '' ? $sCurrency : 'USD';
    }

    function getLang($sLang) {
        return (!empty($sLang) ? $sLang : 'ru');
    }

    protected function getValidPrice($fPrice, $aParams) {
        return ($fPrice > 0 ? number_format(floatval($fPrice), 2, '.', '') : 0);
    }

    protected function getReturnUrl($sReturnUrl, $aParams) {
        $return = urldecode($sReturnUrl);
        if (empty($return)) {
            $return = Samo_Url::route('self');
        };
        return $return;
    }

    protected function getCorrectParams(array $aParams, array $aValidParams) {
        foreach ($aValidParams as $sParamName => $vDefaultVal) {
            if (is_array($vDefaultVal)) {
                if (!empty($vDefaultVal[1]) && method_exists($vDefaultVal[0], $vDefaultVal[1])) {
                    $val = (!empty($aParams[$sParamName]) ? $aParams[$sParamName] : null);
                    $aParams[$sParamName] = call_user_func($vDefaultVal, $val, $aParams);
                } else {
                    if (!isset($aParams[$sParamName])) {
                        $aParams[$sParamName] = $vDefaultVal;
                    };
                };
            } else {
                if (!isset($aParams[$sParamName])) {
                    $aParams[$sParamName] = $vDefaultVal;
                };
            };
        };
        return $aParams;
    }

    protected function sendData($sURL, $sPostData) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sURL);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sPostData);
        $httpResponse = curl_exec($ch);
        curl_close($ch);
        if (empty($httpResponse)) {
            throw new Samo_Exception('CURL ERROR: ' . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }
        return $httpResponse;
    }

}

;
