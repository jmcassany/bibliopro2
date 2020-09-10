<?php

require_once dirname(__FILE__) . '/Redsys/apiRedsys.php';

class Houdini_Services_Tpv_Merchant
{

    /**
     * @var string, Nom del comerç
     */
    private $name;

    /**
     * @var string, Número de comerç (FUC)
     */
    private $code;

    /**
     * @var string, Número de terminal
     */
    private $terminal;

    /**
     * @var string, Moneda del terminal: 978 -> Euros
     */
    private $currency;

    /**
     * @var string, Clau secreta de encriptació de l'entorn de test
     */
    private $testKey;

    /**
     * @var string, Clau secreta de encriptació de l'entorn de producció
     */
    private $realKey = '';

    public function __construct($name, $code, $terminal, $currency, $testKey, $realKey)
    {
        $this->name     = $name;
        $this->code     = $code;
        $this->terminal = $terminal;
        $this->currency = $currency;
        $this->testKey  = $testKey;
        $this->realKey  = $realKey;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getTerminal()
    {
        return $this->terminal;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getTestKey()
    {
        return $this->testKey;
    }

    public function getRealKey()
    {
        return $this->realKey;
    }

    public function testConfig()
    {
        // Merchant -> clau Test i clau Real
        echo '<hr />';
        echo '<p> Merchant: ' . $this->getName() . ' - FUC: ' . $this->getCode() . '</p>';
        echo '<p> Terminal: ' . $this->getTerminal() . '</p>';
        echo '<p> Currency: ' . $this->getCurrency() . '</p>';
        echo '<p> Key Test: ' . ($this->getTestKey() != '' ? 'Ok' : '<strong>Cal indicar la clau</strong>') . '</p>';
        echo '<p> Key Real: ' . ($this->getRealKey() != '' ? 'Ok' : '<strong>Cal indicar la clau</strong>') . '</p>';

    }
}


/**
 * @author antaviano
 *
 */
class Houdini_Services_Tpv
{

    const ENV_PRODUCTION = 1;
    const ENV_TEST = 2;

    /**
     * @var integer, entorn de desenvolupament
     */
    private $environment;

    /**
     * @var Houdini_Services_Tpv_Merchant, comerç
     */
    private $merchant;

    /**
     * @var string, url Callback confirmació operació
     */
    private $urlConfirmCallback;

    /**
     * @var string, url redirecció en cas d'error en tpv
     */
    private $urlError;

    /**
     * @var string, url redirecció en cas de pagament correcte
     */
    private $urlOk;

    /**
     * @var string, número d'ordre de l'últim pagament confirmat
     */
    private $orderId;
    
    /**
     * @var array, dades resposta TPV pagament confirmat
     */
    private $tpvResponse = array();
    

    public function __construct(Houdini_Services_Tpv_Merchant $merchant, $environment = self::ENV_TEST)
    {
        $this->merchant     = $merchant;
        $this->environment  = $environment;
    }

    public function testConfig()
    {
        $this->getMerchant()->testConfig();

        echo '<hr />';
        echo '<p> Environment: ' . ($this->environment == self::ENV_PRODUCTION ? 'REAL' : 'TEST') .'</p>';
        echo '<p> Key: ' . ($this->getMerchantKey() != '' ? 'Ok' : '<strong>Cal indicar la clau</strong>') .'</p>';
        echo '<p> URL callback confirmació : ' . $this->getUrlConfirmCallback() .'</p>';
        echo '<p> URL redirecció Ok : ' . $this->getUrlOk() .'</p>';
        echo '<p> URL redirecció Error : ' . $this->getUrlError() .'</p>';

    }

    public function setUrlConfirmCallback($url)
    {
        $this->urlConfirmCallback = $url;
    }

    public function getUrlConfirmCallback()
    {
        return $this->urlConfirmCallback;
    }

    public function setUrlError($url)
    {
        $this->urlError = $url;
    }

    public function getUrlError()
    {
        return $this->urlError;
    }

    public function setUrlOk($url)
    {
        $this->urlOk = $url;
    }

    public function getUrlOk()
    {
        return $this->urlOk;
    }
    
    public function getOrderId()
    {
    	return $this->orderId;
    }
    
    public function getTpvResponse()
    {
    	return $this->tpvResponse;
    }

    private function getMerchant()
    {
        return $this->merchant;
    }

    private function getMerchantKey()
    {
        if ($this->environment == self::ENV_PRODUCTION) {
            return $this->merchant->getRealKey();
        } else {
            return $this->merchant->getTestKey();
        }
    }

    private function getTpvFormAction()
    {
        if ($this->environment == self::ENV_PRODUCTION) {
            return 'https://sis.redsys.es/sis/realizarPago';
        } else {
            return 'https://sis-t.redsys.es:25443/sis/realizarPago';
        }
    }


    public function confirmacioPagament()
    {

        $debug = false;

        if ($debug) {

            ob_start();

            var_dump($_SERVER);
            var_dump($_POST);
        }

        $error = true;

        if (!empty($_POST) && isset($_POST["Ds_MerchantParameters"]) && isset($_POST["Ds_Signature"])) {
            $miObj = new RedsysAPI;

            $param = $_POST["Ds_MerchantParameters"];
            $signatureRecibida = $_POST["Ds_Signature"];

            $decodec = $miObj->decodeMerchantParameters($param);
            $firma = $miObj->createMerchantSignatureNotif($this->getMerchantKey(), $param);
            $info = json_decode($decodec, true);

            if ($firma === $signatureRecibida) {


                $orderid = $info['Ds_Order'];
                $estado = (int) $info['Ds_Response'];
                $data = $info['Ds_Date'];  // "13/01/2009"
                $hora = $info['Ds_Hour'];  // "10:49"
                $numAutoritzacio = $info['Ds_AuthorisationCode'];

//                 $data = array (
//                     'resposta' => serialize($info),
//                 );

//                 if ($estado >= 0 && $estado <= 99) {

//                     //pagament correcte

//                     $data['num_autoritzacio'] = $numAutoritzacio;
//                     $tmstTransaccio = strtotime(str_replace('/', '-', $data) . ' ' . $hora);

//                     $data['data_autoritzacio'] = ($tmstTransaccio > 0 ? date('Y-m-d H:i:s', $tmstTransaccio) : date('Y-m-d H:i:s'));
//                     $error = false;

//                 }
                $this->orderId = $orderid;
                $this->tpvResponse = $info;
            }

        }

        if ($debug) {

            $content = ob_get_clean();
            echo $content;
            file_put_contents(dirname(__FILE__) . '/log_tpv/' . time() . '.txt', $content);
        }


        return !$error;

    }




    public function getDadesPagament()
    {

        if (!empty($_GET) && isset($_GET["Ds_MerchantParameters"]) && isset($_GET["Ds_Signature"]) ) {
            $miObj = new RedsysAPI;

            $param = $_GET["Ds_MerchantParameters"];
            $signatureRecibida = $_GET["Ds_Signature"];

            $decodec = $miObj->decodeMerchantParameters($param);
            $firma = $miObj->createMerchantSignatureNotif($this->getMerchantKey(), $param);
            $info = json_decode($decodec, true);

            if ($firma === $signatureRecibida) {
                return $info;
            }

        }

        return null;
    }



    function getFormPagament ($orderId, $import, $descripcioProducte, $buttonAttributes = array(), $idioma = 'ca')
    {

        $import             = $import * 100;
        $import             = (int)$import;

        $language = '0';
        /*
         *
0 – Cliente
1 – Castellano
2 – Inglés
3 – Catalán
4 – Francés
5 – Alemán
6 – Holandés
7 – Italiano
8 – Sueco
9 – Portugués
10– Valenciano
11 – Polaco
12 – Gallego
13 – Euskera
         */
        switch ($idioma) {
            case 'ca':
                $language = '3';
                break;
            case 'es':
                $language = '1';
                break;
            case 'en':
                $language = '2';
                break;
            case 'fr':
                $language = '4';
                break;
        }

        $transactionType    = '0';

        if (empty($buttonAttributes)) {
            $buttonAttributes = array('value="Comprar"', 'class="button"');
        }

        if ($this->getUrlConfirmCallback() == '') {
            throw new Exception('Error: Cal indicar una URL de confirmació');
        }

        if ($this->getUrlOk() == '') {
            throw new Exception('Error: Cal indicar una URL per pagaments correctes');
        }

        if ($this->getUrlError() == '') {
            throw new Exception('Error: Cal indicar una URL per pagaments amb error');
        }

        $miObj = new RedsysAPI;
        $miObj->setParameter("DS_MERCHANT_AMOUNT", $import);
        $miObj->setParameter("DS_MERCHANT_ORDER", $orderId);
        $miObj->setParameter("Ds_Merchant_ConsumerLanguage", $language);
        $miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $this->getMerchant()->getCode());
        $miObj->setParameter("DS_MERCHANT_CURRENCY", $this->getMerchant()->getCurrency());
        $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $transactionType);
        $miObj->setParameter("DS_MERCHANT_TERMINAL", $this->getMerchant()->getTerminal());
        $miObj->setParameter("DS_MERCHANT_MERCHANTURL", $this->getUrlConfirmCallback());
        $miObj->setParameter("DS_MERCHANT_URLOK", $this->getUrlOk());
        $miObj->setParameter("DS_MERCHANT_URLKO", $this->getUrlError());
        $miObj->setParameter("Ds_Merchant_ProductDescription", $descripcioProducte);

        $params = $miObj->createMerchantParameters();
        $signature = $miObj->createMerchantSignature($this->getMerchantKey());

        return '
<form action="'.$this->getTpvFormAction().'" method="post">
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1"/>
    <input type="hidden" name="Ds_MerchantParameters" value="'.$params.'"/>
    <input type="hidden" name="Ds_Signature" value="'.$signature.'"/>
    <input type="submit" ' . implode(' ', $buttonAttributes). ' />
</form>
';

    }

}
