<?php

// return [
// 	/**
// 	 * API Token Key (string)
// 	 * Accepted value:
// 	 * Live Token: https://myfatoorah.readme.io/docs/live-token
// 	 * Test Token: https://myfatoorah.readme.io/docs/test-token
// 	 */
// 	'MYFATOORAH_API_URL' => 'default',
// 	'MYFATOORAH_API_KEY' => 'default',
// 	/**
// 	 * Test Mode (boolean)
// 	 * Accepted value: true for the test mode or false for the live mode
// 	 */
// 	'MYFATOORAH_TEST_MODE' => true,
// 	/**
// 	 * Country ISO Code (string)
// 	 * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
// 	 */
// 	'MYFATOORAH_COUNTRY_ISO' => 'default'
// ];
return [
    /**
     * API Token Key
     * Live Token: https://myfatoorah.readme.io/docs/live-token
     * Test Token: https://myfatoorah.readme.io/docs/test-token
     */
    'api_key' => env('MYFATOORAH_API_KEY') ?? '',
    
    /**
     * Test Mode
     * Accepted value: 'true' for the test mode or 'false' for the live mode
     */
    'test_mode' => 'true',
    
    /**
     * Country ISO Code
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => 'KWT'
];
