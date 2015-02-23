<?php

namespace EliasRosaTests;

use Eliasrosa\SafeValue as SafeValue;

class SafeValueTest extends \PHPUnit_Framework_TestCase
{

	private $foo, $bar, $custum_key, $value_original;


	public function __construct(){

		$this->foo = new SafeValue();
		$this->bar = new SafeValue();

		$this->value_original = 'Test1';
	}

	public function testCompareIsEquals()
	{
		//
		$safe_value = $this->foo->encode($this->value_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertEquals($this->value_original, $value_decode);
	}

	public function testCompareIsNotEqualsWithValueDiferent()
	{
		//
		$safe_value = $this->foo->encode($this->value_original);
	    $value_decode = $this->bar->decode('123' . $safe_value);

	    //
		$this->assertNotEquals($this->value_original, $value_decode);
	}

	public function testCompareIsEqualsWithCustonKey(){
		$this->foo->setCustomKey('abcdefg12345');
		$this->bar->setCustomKey('abcdefg12345');

		//
		$safe_value = $this->foo->encode($this->value_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertEquals($this->value_original, $value_decode);
	}


	public function testCompareIsNotEqualsWithCustonKeyDiferent(){
		$this->foo->setCustomKey('aBcdefg12345');
		$this->bar->setCustomKey('abcdefg12345');

		//
		$safe_value = $this->foo->encode($this->value_original);
	    $value_decode = $this->bar->decode($safe_value);

	    //
		$this->assertNotEquals($this->value_original, $value_decode);
	}

}