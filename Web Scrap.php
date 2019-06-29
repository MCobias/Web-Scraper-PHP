<?php

class WebScraper{

    public function __construct(){}

    # If the site requires login in order to access the scraping url.
    public function login($login_endpoint , $parameters){
        $cookie_file = fopen("cookie.txt", "w");
        $login = curl_init();
        curl_setopt($login, CURLOPT_POST, TRUE);
        curl_setopt($login, CURLOPT_TIMEOUT, 400);
        curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
        curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
        curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($login, CURLOPT_URL, $login_endpoint);
        curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($login, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        ob_start();
        curl_exec ($login);
        ob_end_clean();
        curl_close ($login);
        unset($login);
    }

    
    public function load_page($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 4000);
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie.txt");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        ob_start();
        $site_html = curl_exec($curl);
        if (empty($site_html)){
            return "Site not loaded.";
        }
        $site_dom = new DOMDocument();
        libxml_use_internal_errors(TRUE);
        $site_dom->loadHTML($site_html);
        libxml_clear_errors();
        return new DOMXPath($site_dom);
    }

    # Select elements using xpath
    public function scrape($url){
        $xpath = load_page($url);
        $this->name = $xpath->query('//h3')->item(0)->nodeValue;
        $this->first_word  = $xpath->query('//div')->item(0)->nodeValue;
        add_line();
    }


    # In this example I am storing all information in a CSV, change this to whatever storage is needed.
    public function add_line(){
        $file = fopen("myData.csv","a");
        # add all variables into the csv string here, in any required order.
        $line = $this->name."###". $this->first_word."###";
        fputcsv($file,explode('###',$line));
        fclose($file);
    }

}

?>
