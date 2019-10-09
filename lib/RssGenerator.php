<?php
/**
 * @author : Shahriyar Alizada
 * Required interface and child file
 */
require_once "IRssGenerator.php";
require_once "ItemGenerator.php";

/**
 * Class RssGenerator
 */
class RssGenerator implements IRssGenerator
{
    /**
     * @var mixed
     */
    private $categories, $query, $rss_customs, $xml, $feedItems, $ssl=true;

    /**
     * Parser constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->categories = $array['categories'];
        $this->query = $array['query'];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->rss_customs[$name] = $value;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $this->feedItems[$name] = $arguments[0];
    }

    /**
     * write content
     */
    public function write()
    {
        header('Content-type: application/xml');
        echo $this->xmlMake();

    }

    /**
     * @return string
     */

    public function getXml(): string
    {
        return $this->xml;
    }

    /**
     * @param $category
     * @return bool|mixed
     */

    private function getCategory($category)
    {
        if (isset($this->categories[$category])) {
            return $this->categories[$category];
        }
        return false;
    }

    /**
     * @return string
     * @throws Exception
     */

    public function xmlMake(): string
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";

        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";

        // channel required properties
        $xml .= '<channel>' . "\n";
        if (array_key_exists("title", $this->rss_customs)) {
            $xml .= '<title>' . $this->rss_customs["title"] . '</title>' . "\n";
        } else {
            throw new Exception("title doesn't set");
        }
        if (array_key_exists('link', $this->rss_customs)) {
            $xml .= '<link>' . $this->rss_customs["link"] . '</link>' . "\n";
        } else {
            throw new Exception("link doesn't set");
        }
        if (array_key_exists('description', $this->rss_customs)) {
            $xml .= '<description>' . $this->rss_customs["description"] . '</description>' . "\n";
        } else {
            throw new Exception("description doesn't set");
        }
        // channel optional properties
        if (array_key_exists("language", $this->rss_customs)) {
            $xml .= '<language>' . $this->rss_customs["language"] . '</language>' . "\n";
        } else {
            throw new Exception("language doesn't set");
        }
        if (array_key_exists("image_url", $this->rss_customs)) {
            $xml .= '<image>' . "\n";
            $xml .= '<title>' . $this->rss_customs["image_title"] . '</title>' . "\n";
            $xml .= '<link>' . $this->rss_customs["image_link"] . '</link>' . "\n";
            $xml .= '<url>' . $this->rss_customs["image_url"] . '</url>' . "\n";
            $xml .= '</image>' . "\n";
        } else {
            throw new Exception("image_url doesn't set");
        }

        foreach ($this->query as $row) {
            if ($this->getCategory($row[$this->feedItems['category']])) {
                $feedItem = new ItemGenerator();
                $feedItem->title = $row[$this->feedItems['title']];
                $feedItem->link = $_SERVER['HTTP_HOST'].$row[$this->feedItems['link']];
                $feedItem->description = $row[$this->feedItems['description']];
                $feedItem->pubDate = $row[$this->feedItems['pubDate']];
                $feedItem->enclosure = $_SERVER['HTTP_HOST'].$row['image'];
                $feedItem->category = $this->getCategory($row[$this->feedItems['category']]);
                try {
                    $xml .= $feedItem->xmlMake();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        $xml .= '</channel>';

        $xml .= '</rss>';

        $this->xml = $xml;
        return $this->xml;

    }
}