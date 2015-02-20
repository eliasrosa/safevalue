<?php

class SafeValue
{

    //
    private $custom_key = null;
    private $rand_key = null;
    private $expire_seconds = 0;

    /**
     * Cria um valor visivel e seguro
     * 
     * @param string $value      Valor a ser passado
     * @param string $customKey  Chave opcional de segurança
     * @param type   $expire     Tempo em segundos para expirar, 0 = disable
     * 
     * @return string (base64_encode)
     */
    private function create($value)
    {
        $sha1 = sha1($this->custom_key . $this->getRandKey() . $value . $this->expire_seconds);
        $safeValue = sprintf('%s|%s|%s|%s', $this->getRandKey(), $sha1, $value, $this->expire_seconds);
        
        return base64_encode($safeValue);
    }

    /**
     * Decodifica o valor, retorna false caso inválido
     * ********************************************* */
    public function decode($safeValue)
    {
        // 
        list($rand_key, $sha1, $value, $expire_seconds) = explode('|', base64_decode($safeValue));

        //
        $this->setRandKey($rand_key);

        // 
        if ($safeValue == $this->create($value)) {
            // if ($expire_seconds == 0 || time() <= $expire_seconds) {
                return $value;
            //}
        }

        return false;
    }

    private function getRandKey()
    {
        //
        if (is_null($this->rand_key)) {
            $this->rand_key = sha1(rand());
        }

        return $this->rand_key;
    }

    private function setRandKey($key)
    {
        $this->rand_key = $key;
    }

}
