<?php

/**
 * Class ItemGenerator
 */

class ItemGenerator implements IRssGenerator
{
    public $enclosure_path, $enclosure_ext;
    /**
     * @var
     */
    private $objItem;

    /**
     * @param $name
     * @param $value
     * @return mixed|void
     */
    public function __set($name, $value)
    {
        $this->objItem[$name] = $value;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function xmlMake(): string
    {
        $xml = "<item>";
        if (array_key_exists('title', $this->objItem)) {
            $xml .= '<title>' . $this->objItem['title'] . '</title>' . "\n";
        } else {
            throw new Exception("title does not set for feed item");
        }
        if (array_key_exists('link', $this->objItem)) {
            $xml .= '<link>' . $this->objItem['link'] . '</link>' . "\n";
            $xml .= '<guid isPermaLink="false">' . $this->objItem['link'] . '</guid>' . "\n";
        } else {
            throw new Exception("link does not set for feed item");
        }
        if (array_key_exists('description', $this->objItem)) {
            $xml .= '<description>' . $this->objItem['description'] . '</description>' . "\n";
        } else {
            throw new Exception("description does not set for feed item");
        }
        if (array_key_exists('pubDate', $this->objItem)) {
            $xml .= '<pubDate>' . $this->objItem['pubDate'] . '</pubDate>' . "\n";
        } else {
            throw new Exception("pubDate does not set for feed item");
        }
        if (array_key_exists('enclosure', $this->objItem)) {
            $xml .= '<enclosure url="' . $this->enclosure_path ?? null .$this->objItem['enclosure'] . $this->enclosure_ext ?? null . '" type="image/jpeg" />'. "\n";
        } else {
            throw new Exception("enclosure does not set for feed item");
        }
        if (array_key_exists('category', $this->objItem)) {
            $xml .= '<category>' . $this->objItem['category'] . '</category>' . "\n";
        } else {
            throw new Exception("category does not set for feed item");
        }
        if (array_key_exists('category', $this->objItem)) {
            $xml .= '<category>' . $this->objItem['category'] . '</category>' . "\n";
        } else {
            throw new Exception("category does not set for feed item");
        }
        $xml .= '</item>' . "\n";
        return $xml;
    }
}