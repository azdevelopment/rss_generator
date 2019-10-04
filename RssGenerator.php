<?php

/**
 * Class RssGenerator
 */
class RssGenerator implements IRssGenerator
{
    /**
     * @var mixed
     */
    private $categories, $query, $rss_customs, $xml;

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
     */

    public function xmlMake(): string
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";

        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";

        // channel required properties
        $xml .= '<channel>' . "\n";
        if (array_key_exists("title", $this->rss_customs['title'])) {
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
            if ($this->getCategory($row['category'])) {
                $feedItem = new ItemGenerator();
                $feedItem->title = $row['title'];
                $feedItem->link = $row['link'];
                $feedItem->description = $row['description'];
                $feedItem->pubDate = $row['created_date'];
                $feedItem->enclosure = $row['image'];
                $feedItem->category = $this->getCategory($row['category']);
                try {
                    $feedItem->xmlMake();
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