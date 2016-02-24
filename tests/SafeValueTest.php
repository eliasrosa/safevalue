<?php

namespace EliasRosaTests;

use Eliasrosa\SafeValue as SafeValue;

class SafeValueTest extends \PHPUnit_Framework_TestCase
{

	private $foo, $bar, $custum_key, $valor_original;


	public function __construct(){

		$this->foo = new SafeValue();
		$this->bar = new SafeValue();

		$this->valor_original = 'texto exemplo!';
	}

	public function testSimples()
	{
		//
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertEquals($this->valor_original, $value_decode);
	}

	public function testAlterandoSafeValue()
	{
		//
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode('123' . $safe_value);

	    //
		$this->assertNotEquals($this->valor_original, $value_decode);
	}

	public function testAlterandoSafeValue2()
	{
		//
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode('12211212:DASDSD');

	    //
		$this->assertNotEquals($this->valor_original, $value_decode);
	}

	public function testAlterandoSafeValue3()
	{
		//
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode(null);

	    //
		$this->assertNotEquals($this->valor_original, $value_decode);
	}



	public function testSetCustomKey(){
		$this->foo->setCustomKey('abcdefg12345');
		$this->bar->setCustomKey('abcdefg12345');

		//
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertEquals($this->valor_original, $value_decode);
	}


	public function testSetCustomKeyDiferente(){
		$this->foo->setCustomKey('aBcdefg12345');
		$this->bar->setCustomKey('ABCDEFG12345');

		//
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertNotEquals($this->valor_original, $value_decode);
	}


	public function testSetTimeExpire5Segundos(){

		// set 2 segunds
		$this->foo->setTimeExpire(5);
		$safe_value = $this->foo->encode($this->valor_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertEquals($this->valor_original, $value_decode);
	}


	public function testSetTimeExpire5SegundosComSlep5(){

		// set 2 segunds
		$this->foo->setTimeExpire(5);

		//
		$safe_value = $this->foo->encode($this->valor_original);

		sleep(6);

	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertNotEquals($this->valor_original, $value_decode);
	}


}
