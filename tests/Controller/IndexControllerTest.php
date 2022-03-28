<?php
/**
 * @copyright 2022 Anthon Pang
 */

namespace App\Tests\Controller;

use App\Tests\Driver\CurlDriver;
use PHPUnit\Framework\TestCase;

/**
 * Index controller test
 *
 * @group functional
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class IndexControllerTest extends TestCase
{
    /**
     * Test English
     */
    public function testEnglish()
    {
        $driver   = new CurlDriver;
        $response = $driver->get('http://localhost/');

	    $this->assertTrue(strpos($response, 'Hello world') !== false);
    }

    /**
     * Test French
     */
    public function testFrench()
    {
        $driver   = new CurlDriver;
        $response = $driver->get('http://localhost/?lang=fr');

	    $this->assertTrue(strpos($response, 'Bonjour le monde') !== false);
    }
}
