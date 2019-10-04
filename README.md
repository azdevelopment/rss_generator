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
