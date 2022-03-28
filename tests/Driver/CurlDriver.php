<?php
/**
 * @copyright 2022 Anthon Pang
 */

namespace App\Tests\Driver;

/**
 * Curl Driver for Web Testing
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class CurlDriver
{
    /**
     * @var \CurlHandle
     */
    private $ch;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ch = curl_init();

        curl_setopt_array(
            $this->ch,
            [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4758.102 Safari/537.36',
                CURLOPT_RETURNTRANSFER => true,
            ]
        );
    }

    /**
     * HEAD request
     *
     * @param string     $url
     * @param array|null $headers
     *
     * @return string
     */
    public function head($url, $headers = null)
    {
        curl_setopt($this->ch, CURLOPT_NOBODY, true);

        return $this->exec($url, $headers);
    }

    /**
     * GET request
     *
     * @param string     $url
     * @param array|null $headers
     *
     * @return string
     */
    public function get($url, $headers = null)
    {
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);

        return $this->exec($url, $headers);
    }

    /**
     * POST request
     *
     * @param string     $url
     * @param array|null $data
     * @param array|null $headers
     *
     * @return string
     */
    public function post($url, $data = null, $headers = null)
    {
        curl_setopt($this->ch, CURLOPT_POST, true);

        if (is_array($data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif (is_string($data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        }

        return $this->exec($url, $headers);
    }

    /**
     * PUT request
     *
     * @param string     $url
     * @param array|null $data
     * @param array|null $headers
     *
     * @return string
     */
    public function put($url, $data = null, $headers = null)
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');

        if (is_array($data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif (is_string($data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        }

        return $this->exec($url, $headers);
    }

    /**
     * DELETE request
     *
     * @param string     $url
     * @param array|null $headers
     *
     * @return string
     */
    public function delete($url, $headers = null)
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return $this->exec($url, $headers);
    }

    /**
     * Get information about the last transfer
     *
     * @return array|null
     */
    public function info()
    {
        return curl_getinfo($this->ch);
    }

    /**
     * Perform curl request
     *
     * @param string     $url
     * @param array|null $headers
     *
     * @return string
     */
    private function exec($url, $headers)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);

        if (is_array($headers)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }

        return curl_exec($this->ch);
    }
}
