<?php
/**
 * @copyright 2022 Anthon Pang
 */

namespace App\Tests\Service;

use App\Service\HelloService;
use PHPUnit\Framework\TestCase;

/**
 * Hello service test
 *
 * @group unit
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class HelloServiceTest extends TestCase
{
    /**
     * Test hello()
     */
    public function testHello()
    {
        $service = new HelloService;

        $this->assertEquals('hello', $service->hello());
    }
}
