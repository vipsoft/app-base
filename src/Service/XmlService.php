<?php
/**
 * @copyright 2024 Anthon Pang
 */
namespace App\Service;

/**
 * XML service
 *
 * @author Anthon Pang <apang@softaredevelopment.ca>
 */
class XmlService
{
    /**
     * Serialize
     *
     * @param string $name
     * @param array  $parameterList
     *
     * @return string
     */
    public function serialize($name, array $parameterList)
    {
        $xml = new \SimpleXMLElement('<\?xml version="1.0" encoding="UTF-8"?><' . $name . ' />');

        $f = function ($node, $key, &$value) use (&$f) {
            if ( ! is_array($value)) {
                $node->addChild($key, htmlspecialchars($value));

                return;
            }

            $list = $key === null ? $node : $node->addChild($key);

            foreach ($value as $k => $v) {
                $f($list, strlen($key) > 4 && substr($key, -4) === 'List' ? substr($key, 0, -4) : $k, $v);
            }
        };

        $f($xml, null, $parameterList);

        return $xml->asXML();
    }

    /**
     * Unserialize
     *
     * @param string $name
     * @param string $xmlString
     *
     * @return array|null
     */
    public function unserialize(&$name, $xmlString)
    {
        $useErrors = libxml_use_internal_errors(true);

        $params = null;
        $xml = @simplexml_load_string($xmlString);

        // fallback for mis-encoded xml content
        if ($xml === false && ! strncasecmp($xmlString, '<\?xml version="1.0" encoding="UTF-8"?>', 38)) {
            $xmlString = utf8_encode($xmlString);

            $xml = @simplexml_load_string($xmlString);
        }

        libxml_use_internal_errors($useErrors);

        if ($xml === false) {
            return null;
        }

        $f = function ($iter, &$root) use (&$f) {
            foreach ($iter as $key => $value) {
                if ($iter->hasChildren()) {
                    if (strlen($key) > 4 && substr($key, -4) === 'List') {
                        $root[$key] = [];
                        $f($value, $root[$key]);
                        continue;
                    }

                    $root[] = null;
                    $f($value, $root[count($root) - 1]);
                    continue;
                }

                $root[$key] = trim(strval($value));
            }
        };

        $f(new \SimpleXMLIterator($xmlString), $params);

        $name = $xml->getName();

        return $params;
    }
}
