<?php

namespace Eliasrosa;

use DateTime;
use DateInterval;

class SafeValue
{
    //
    private $custom_key = null;
    private $rand_key = null;
    private $expire = null;


    /**
     * Cria um valor visivel e seguro
     *
     * @param string $value
     * @return string (base64_encode)
     */
    public function encode($value)
    {
        //
        $value = base64_encode($value);

        //
        $sha1 = sha1(join(':', [
            $this->getCustomKey(),
            $this->getRandKey(),
            $value,
            $this->expire
        ]));

        //
        $safeValue = join(':', [
            $value,
            $sha1,
            $this->getRandKey(),
            $this->expire
        ]);

        return $safeValue;
    }



    /**
     * Decodifica o valor
     *
     * @return valor original/FALSE
     */
    public function decode($safeValue)
    {
        //
        $a = explode(':', $safeValue);
        $v = base64_decode($a[0]);

        //
        $this->expire = $a[3];

        // set randon key - hash
        $this->setRandKey($a[2]);

        //
        $b = explode(':', $this->encode($v));

        //
        if ($a[0] == $b[0] &&
            $a[1] == $b[1] &&
            $a[2] == $b[2]) {

            // verifica se está expirado
            if($a[3] != ""){

                $now = new DateTime('now');
                $date_expire = new DateTime(base64_decode($this->expire));

                if($now < $date_expire){
                    return $v;
                }else{
                    return false;
                }

            }

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


    //
    public function setTimeExpire($expire)
    {
        $date = new DateTime('now');
        $date->add(new DateInterval('PT' . $expire . 'S'));
        $this->expire = base64_encode($date->format('Y-m-d H:i:s'));
    }

}
