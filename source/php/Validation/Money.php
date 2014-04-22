<?php

/**
 * This file is part of the Altumo library.
*
* (c) Steve Sperandeo <steve.sperandeo@altumo.com>
* (c) Juan Jaramillo <juan.jaramillo@altumo.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/




namespace Altumo\Validation;


/**
 * This class contains functions for money validation.
 * 
 * These functions will return the sanitized data too.
 * 
 */
class Money{
	
	
	/**
	 * Asserts a common amount with max. 2 decimals
	 * 
	 * @param mixed $amount
	 * @param string $message
	 *
	 * @throws \Exception if $amount isn't a valid common amount
	 *
	 * @return float
	 */
	static public function assertCommonAmount( $amount, $message = null )
	{
		if ( null === $message ) $message = 'Value passed is not a common amount';
		 
		if ( floatval( $amount ) !== floatval( number_format( $amount, 2, '.', '' ) ) ) throw new \Exception( $message );
		 
		return $amount;
	}
	

	/**
	 * Asserts positive common amount with max. 2 decimals
	 * 
	 * @param mixed $amount
	 * @param string $message
	 * 
	 * @throws \Exception if $amount isn't a valid common amount
	 * @throws \Exception if $amount isn't more than 0
	 * 
	 * @return float
	 */
	static public function assertCommonPositiveAmount( $amount, $message = null )
	{
		if ( null === $message ) $message = 'Value passed is not a common positive amount';
		
		// assert amount first
		static::assertCommonAmount( $amount, $message );

		// assert positive
		if ( $amount > 0 ) return $amount;
		
		throw new \Exception( $message );
	}
	
	
	/**
	 * Asserts non-negative common amount with max. 2 decimals
	 *
	 * @param mixed $amount
	 * @param string $message
	 *
	 * @throws \Exception if $amount isn't a valid common amount
	 * @throws \Exception if $amount is less than 0
	 *
	 * @return float
	 */
	static public function assertCommonNonnegativeAmount( $amount, $message = null )
	{
		if ( null === $message ) $message = 'Valid passed is not a common non-negative amount';
	
		// assert amount first
		static::assertCommonAmount( $amount, $message );
	
		// assert positive
		if ( $amount >= 0 ) return $amount;
	
		throw new \Exception( $message );
	}
	
	
}