# install
composer require rss-az/array-to-xml

``"require": {
         "rss-az/array-to-xml": "dev-master"
     }``
# rss_generator
Rss generator for rss.az

## usage

``` 
 * key : write category of your website
 * value : catergory of Rss.az
 
 
  $generate = new RssGenerator([
    'category'=>[
        "Maliyyə"=>"Biznes və maliyyə",
        "Hadisə"=>"Hadisə",
        "Siyasət"=>"Cəmiyyət və siyasət",
        "Cəmiyyət"=>"Cəmiyyət və siyasət",
        "Xarici siyasət"=>"Cəmiyyət və siyasət",
        "Mədəniyyət siyasəti"=>"Cəmiyyət və siyasət",
        "Daxili siyasət"=>"Cəmiyyət və siyasət",
        "Elm və təhsil"=>"Elm və təhsil",
        "Səhiyyə"=>"Sağlamlıq və Fitness",
        "Şou-biznes"=>"Məşhurlar",
        "Futbol"=>"İdman",
        "İdman"=>"İdman",
        "Mədəniyyət"=>"Mədəniyyət",
    ],
    'query'=>Post::get()->toArray()
]);

// Please write information for rss parent tags. It's required 
$generate->title = 'Your rss title';
$generate->link = 'Your rss link';
$generate->description = 'Your rss description';
$generate->language = 'Your rss language';
$generate->image_url = 'Your rss full photo url (etc : https://development.az/images/logo.png)';
$generate->image_link = 'set link for your logo';
$generate->image_title = 'set title for your logo';

// For feed items from your post columns
$generate->title('title');
$generate->link('slug'); // auto insert HTTP_HOST  begin of the slug 
$generate->description('description'); 
$generate->pubDate('created_date'); 
$generate->enclosure('image'); auto insert HTTP_HOST  begin of the image path 
$generate->category('name'); 

$generate->xmlMake();
echo $generate->write();

