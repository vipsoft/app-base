<?php
/**
 * @copyright 2022 Anthon Pang
 */
namespace App\Controller;

use Pimple\Psr11\Container;

/**
 * Abstract Controller
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
abstract class AbstractController
{
    /**
     * @var array
     */
    protected $params;

    /**
     * Constructor
     *
     * @param \Pimple\Psr11\Container $container
     */
    public function __construct(
        protected Container $container
    ) {
        session_start();

        if ( ! array_key_exists('lang', $_SESSION)) {
            $_SESSION['lang'] = $this->initializeLanguage();
        }

        $this->params = $_GET;
    }

    /**
     * Render view
     *
     * @param string     $sourceMethod
     * @param array|null $params
     */
    protected function render($sourceMethod, $params = null)
    {
        $lang = $this->getLanguage();

        @list($controller, $action) = explode('::', $sourceMethod);

        if (($pos = strrpos($controller, '\\')) !== false) {
            $controller = substr($controller, $pos + 1);
        }

        if (($pos = strrpos($controller, 'Controller')) !== false) {
            $controller = substr($controller, 0, $pos);
        }

        if (($pos = strrpos($action, 'Action')) !== false) {
            $action = substr($action, 0, $pos);
        }

        $basePath = __DIR__ . '/../../templates/' . $controller . '/' . $action;

        include_once ($lang &&
            file_exists($path = $basePath . '.' . $lang . '.php')
            ? $path
            : ($lang !== 'en' && file_exists($path = $basePath . '.en.php')
            ? $path
            : $basePath . '.php'));
    }

    /**
     * Initialize language
     *
     * @return string
     */
    private function initializeLanguage()
    {
        $mapping = [
            'AG' => 'en',
            'AU' => 'en',
            'BB' => 'en',
            'BJ' => 'fr',
            'BS' => 'en',
            'BZ' => 'en',
            'CA' => 'en',
            'CD' => 'fr',
            'CF' => 'fr',
            'CG' => 'fr',
            'CI' => 'fr',
            'CM' => 'fr',
            'CN' => 'zh',
            'DM' => 'en',
            'FR' => 'fr',
            'GA' => 'fr',
            'GB' => 'en',
            'GD' => 'en',
            'GN' => 'fr',
            'GY' => 'en',
            'HK' => 'zh',
            'HT' => 'fr',
            'IE' => 'en',
            'JM' => 'en',
            'KN' => 'en',
            'LC' => 'en',
            'NE' => 'fr',
            'NZ' => 'en',
            'SG' => 'zh',
            'SN' => 'fr',
            'TG' => 'fr',
            'TT' => 'en',
            'TW' => 'zh',
            'US' => 'en',
            'VC' => 'en',
        ];

        // Accept-Language: header
        if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) {
            if ($count = strspn($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'abcdefghijklmnopqrstuvwyxz')) {
                $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, $count);

                if (in_array($lang, ['en', 'fr'])) {
                    return $lang;
                }
            }
        }

        $country = null;

        // geolocate
        if (array_key_exists('HTTP_CF_IPCOUNTRY', $_SERVER)) {
            $country = $_SERVER['HTTP_CF_IPCOUNTRY'];
        }

        if ($country && array_key_exists($country, $mapping)) {
            return $mapping[$country];
        }

        return 'en';
    }

    /**
     * Get language
     *
     * @return string
     */
    private function getLanguage()
    {
        // override
        if (array_key_exists('lang', $this->params) &&
            is_string($lang = $this->params['lang']) &&
            in_array($lang, ['en', 'fr'])
        ) {
            $_SESSION['lang'] = $lang;
        }

        return $_SESSION['lang'];
    }
}
