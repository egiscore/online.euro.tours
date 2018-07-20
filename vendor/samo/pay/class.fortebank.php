<?php

class ForteBank extends PaySystem {

    private $aStatusCode = [
        0 => 'Success',
        10 => 'Shop unregistered in Forte Bank',
        30 => 'Invalid request format',
        54 => 'Invalid operation',
        96 => 'System error',
    ];
    private $aPayStatusCode = [
        'CREATED' => 'ожидает оплаты',
        'ON-LOCK' => 'заблокирован для исключения дублирования оплаты товара',
        'ON-PAYMENT' => 'на оплате',
        'APPROVED' => 'оплата прошла успешно',
        'CANCELED' => 'отменен клиентом',
        'DECLINED' => 'отказ в оплате банком',
        'REVERSED' => 'реверсирован',
        'REFUNDED' => 'осуществлен возврат',
        'PREAUTH-APPROVED' => 'зарезервированы средства для оплаты',
        'EXPIRED' => 'истек срок действия заказа',
        'ERROR' => 'ошибка; ошибка соединения с БД TWPG, POS-драйвером TWO или TPTP-терминалом TranzAxis',
    ];
    private $aPayStatusOk = [
        'APPROVED'
    ];
    private $aPayStatusCancel = [
        'DECLINED',
        'CANCELED',
        'REFUNDED',
        'EXPIRED',
    ];
    private $aPayStatusWait = [
        'ON-PAYMENT',
        'ON-LOCK',
        'CREATED',
        'PREAUTH-APPROVED',
    ];

    public function Pay(array $aParams) {
        $aValidParams = [
            'fPrice' => [$this, 'getValidPrice'],
            'sCurrencyId' => [$this, 'getValidCurrency'],
            'sReturnUrl' => [$this, 'getReturnUrl'],
            'sLang' => [$this, 'getLang'],
            'iSamoPayId' => null,
            'sDescription' => "Reservation " . $aParams['iSamoPayId'],
        ];
        $aParams = $this->getCorrectParams($aParams, $aValidParams);
        if (empty($aParams['iSamoPayId'])) {
            throw new Samo_Exception('Empty parameter: iSamoPayId');
        };
        if (empty($aParams['URL'])) {
            throw new Samo_Exception('Empty parameter: URL');
        };
        if (empty($aParams['sReturnUrl'])) {
            throw new Samo_Exception('Empty parameter: sReturnUrl');
        };
        if (empty($aParams['fPrice'])) {
            throw new Samo_Exception('Empty parameter: fPrice');
        };
        if (empty($aParams['sCurrencyId'])) {
            throw new Samo_Exception('Empty parameter: sCurrencyId');
        };
        if (!isset($aParams['sLang'])) {
            throw new Samo_Exception('Empty parameter: sLang');
        };
        if (!isset($aParams['MERCHANTID'])) {
            throw new Samo_Exception('Empty parameter: MERCHANTID');
        };

        $postData = '<?xml version="1.0" encoding="UTF-8"?>
		<TKKPG>
			<Request>
				<Operation>CreateOrder</Operation>
				<Language>' . strtoupper($aParams['sLang']) . '</Language>
				<Order>
					<OrderType>Purchase</OrderType>
					<Merchant>' . $aParams['MERCHANTID'] . '</Merchant>
					<Amount>' . intval($aParams['fPrice'] * 100) . '</Amount>
					<Currency>' . $aParams['sCurrencyId'] . '</Currency>
					<Description>' . htmlspecialchars($aParams['sDescription']) . '</Description>
					<ApproveURL>' . htmlspecialchars($aParams['sReturnUrl']) . '</ApproveURL>
					<CancelURL>' . htmlspecialchars($aParams['sReturnUrl']) . '</CancelURL>
					<AddParams>
						<OrderExpirationPeriod>30</OrderExpirationPeriod>
					</AddParams>
					<Fee></Fee>
				</Order>
			</Request>
		</TKKPG>';
        $sResponse = $this->sendData($aParams['URL'], $postData);


        $xml = $this->parseResponse($sResponse);

        $oResponse = $xml->Response;

        $iStatus = (int)$oResponse->Status;
        $oOrder = $oResponse->Order;

        $return['redirect'] = '';
        $return['iSamoPayId'] = $aParams['iSamoPayId'];
        $OrderID = (string)$oOrder->OrderID;
        $SessionID = (string)$oOrder->SessionID;
        if (empty($iStatus) && !empty($OrderID)) {
            $return['info'] = 'Success';
            $return['code'] = parent::PAY_OK;
            $return['status'] = 'Transaction Start';
            $return['redirect'] = $oOrder->URL . '?' . http_build_query(['ORDERID' => $OrderID, 'SESSIONID' => $SessionID]);
            $return['paySystemData']['sLang'] = $aParams['sLang'];
            $return['paySystemData']['OrderID'] = $OrderID;
            $return['paySystemData']['SessionID'] = $SessionID;
        } else {
            $return['info'] = 'Error';
            $return['code'] = $iStatus;
            $return['status'] = $this->aStatusCode[$iStatus];
        }
        $return['request'] = $postData;
        $return['responce'] = $sResponse;
        return $return;
    }

    public function PayStatus(array $aParams) {
        $aValidParams = [
            'paySystemData' => [
                'sLang' => [$this, 'getLang'],
                'OrderID' => null,
                'SessionID' => null,
            ],
        ];
        $aParams = $this->getCorrectParams($aParams, $aValidParams);
        if (empty($aParams['paySystemData'])) {
            throw new Samo_Exception('Empty parameter: paySystemData');
        };
        if (!isset($aParams['paySystemData']['sLang'])) {
            throw new Samo_Exception('Empty parameter: paySystemData.sLang');
        };
        if (!isset($aParams['paySystemData']['OrderID'])) {
            throw new Samo_Exception('Empty parameter: paySystemData.OrderID');
        };
        if (!isset($aParams['paySystemData']['SessionID'])) {
            throw new Samo_Exception('Empty parameter: paySystemData.SessionID');
        };
        if (!isset($aParams['MERCHANTID'])) {
            throw new Samo_Exception('Empty parameter: MERCHANTID');
        };

        $postData = '<?xml version="1.0" encoding="UTF-8"?>
		<TKKPG>
			<Request>
				<Operation>GetOrderStatus</Operation>
				<Language>' . strtoupper($aParams['paySystemData']['sLang']) . '</Language>
				<Order>
					<Merchant>' . $aParams['MERCHANTID'] . '</Merchant>
					<OrderID>' . $aParams['paySystemData']['OrderID'] . '</OrderID>
				</Order>
				<SessionID>' . $aParams['paySystemData']['SessionID'] . '</SessionID>
			</Request>
		</TKKPG>';
        $sResponse = $this->sendData($aParams['URL'], $postData);

        $xml = $this->parseResponse($sResponse);

        $oResponse = $xml->Response;
        
        $iStatus = (int)$oResponse->Status;
        $oOrder = $oResponse->Order;
        $OrderStatus = (string)$oOrder->OrderStatus;

        $return['info'] = parent::PAY_STATUS_STR_ERROR;
        $return['code'] = parent::PAY_STATUS_INT_ERROR;
        if (in_array($OrderStatus, $this->aPayStatusOk)) {
            $return['info'] = parent::PAY_STATUS_STR_PAYED;
            $return['code'] = parent::PAY_STATUS_INT_PAYED;
        };
        if (in_array($OrderStatus, $this->aPayStatusCancel)) {
            $return['info'] = parent::PAY_STATUS_STR_CANCEL;
            $return['code'] = parent::PAY_STATUS_INT_CANCEL;
        };
        if (in_array($OrderStatus, $this->aPayStatusWait)) {
            $return['info'] = parent::PAY_STATUS_STR_WAIT;
            $return['code'] = parent::PAY_STATUS_INT_WAIT;
        };
        $return['transaction'] = $aParams['paySystemData']['OrderID'];
        $return['status'] = $this->aPayStatusCode[$OrderStatus];
        $return['request'] = $postData;
        $return['responce'] = $sResponse;
        return $return;
    }

    protected function getValidCurrency($sCurrency) {
        switch ($sCurrency) {
            case 'RUB':
                $ret = 810;
                break;
            case 'USD':
                $ret = 840;
                break;
            case 'KZT':
                $ret = 398;
                break;
            default:
                throw new Samo_Exception('Parameter sCurrencyId not valid, allow: RUB; USD');
        };
        return $ret;
    }

    private function parseResponse($response) {
        $errorMessage = null;
        $internalErrors = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(true);
        libxml_clear_errors();
        try {
            $xml = new \SimpleXMLElement((string) $response ?: '<root />', LIBXML_NONET);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }
        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);
        libxml_disable_entity_loader($disableEntities);

        if ($errorMessage !== null) {
            throw new Samo_Exception('Unable to parse response body into XML: ' . $errorMessage);
        }
        return $xml;
    }

}
