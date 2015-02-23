<?php

namespace Eliasrosa;

class SafeValue
{
    const DV = ':';

    //
    private $custom_key = null;
    private $rand_key = null;


    /**
     * Cria um valor visivel e seguro
     * 
     * @param string $value     
     * @return string (base64_encode)
     */
    public function encode($value)
    {
        $value = base64_encode($value);


        $sha1 = substr(sha1($this->getCustomKey() . self::DV . $this->getRandKey() . self::DV . $value), 0, 15);
        
        $safeValue = sprintf('%s'. self::DV .'%s'. self::DV .'%s', 
            $value, 
            $sha1, 
            $this->getRandKey()
        );
        
        return $safeValue;
    }



    /**
     * Decodifica o valor
     * 
     * @return retorna valor original ou false
     */
    public function decode($safeValue)
    {

        // 
        $a = explode(self::DV, $safeValue);     
        $v = base64_decode($a[0]);
        
        // set randon key
        $this->setRandKey($a[2]);
        $b = explode(self::DV, $v2 = $this->encode($v));

        // 
        if ($a[0] == $b[0] && 
            $a[1] == $b[1] && 
            $a[2] == $b[2]) {
            
            return $v;
        }

        return false;
    }



    /**
    * Get private var $rand_key
    * 
    * @return string
    */
    private function getRandKey()
    {
        if (is_null($this->rand_key)) {
            $this->rand_key = substr(sha1(rand()), 0, 15);
        }

        return $this->rand_key;
    }



    /**
    * Set private var $rand_key
    * 
    * @return void();
    */
    private function setRandKey($key)
    {
        $this->rand_key = $key;
    }


    /**
    * Get private var $custom_key
    * 
    * @return string
    */
    public function getCustomKey()
    {
        return $this->custom_key;
    }



    /**
    * Set private var $custom_key
    * 
    * @return void();
    */
    public function setCustomKey($key)
    {
        $this->custom_key = $key;
    }

}
