<?php
/**
 * @copyright 2022 Anthon Pang
 */

namespace App\Tests\Driver;

use WebDriver\WebDriver as WebDriver;
use WebDriver\Browser;
use WebDriver\LocatorStrategy;

/**
 * Chromedriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class ChromeDriver
{
    /**
     * @var \WebDriver\WebDriver
     */
    private $driver;

    /**
     * @var \WebDriver\Session
     */
    private $session;


    /**
     * @var \WebDriver\Element
     */
    private $element;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->driver = new WebDriver('http://localhost:9515');

        $this->session = $this->driver->session(Browser::CHROME);
    }

    public function open($url)
    {
        return $this->session->open($url);
    }

    public function setValue($selector, $value)
    {
        return $this->session->execute()->sync([
            'script' => "document.querySelector('{$selector}').value = '{$value}';",
            'args' => [],
        ]);
    }

    public function click($selector)
    {
        return $this->session->execute()->sync([
            'script' => "document.querySelector('{$selector}').click();",
            'args' => [],
        ]);
    }

    public function getText($selector)
    {
        $element = $this->session->element(LocatorStrategy::CSS_SELECTOR, $selector);

        return $element->text();
    }

    public function close()
    {
        $this->session->close();
    }
}
