<?php

App::uses('CakeNumber', 'Utility');

class Currency {

    private static $instance;
    private static $__currencies;
    public static $destinationCurrency = 'EUR';
    public static $sourceCurrency = 'PLN';

    private function __construct() {
        CakeNumber::addFormat('PLN', array(
            'wholeSymbol' => ' ₴',
            'wholePosition' => 'after',
            'zero' => 0,
            'thousands' => ' ',
            'decimals' => ',')
        );
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    public static function setCurrencies($data) {
        self::$__currencies = $data;
    }

    public static function exchange($sourceValue, $destinationCurrency = null, $sourceCurrency = null) {
        if (empty($destinationCurrency)) {
            $destinationCurrency = self::$destinationCurrency;
        }
        if (empty($sourceCurrency)) {
            $sourceCurrency = self::$sourceCurrency;
        }

        if (empty(self::$__currencies[$sourceCurrency])) {
            throw new MissingCurrencyException(array($sourceCurrency));
        }
        if (empty(self::$__currencies[$destinationCurrency])) {
            throw new MissingCurrencyException(array($destinationCurrency));
        }

        return $sourceValue * self::$__currencies[$sourceCurrency]['value'] / self::$__currencies[$destinationCurrency]['value'];
    }

}

class MissingCurrencyException extends CakeException {

    protected $_messageTemplate = 'Currency %s was not configured in table CurrencyExchangeRate.';

}

?>