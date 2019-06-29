# web-scraper-php

This is a simple web scraper written in OOP PHP. It needs to be modified per usage as each website is different. It allows scraping past logins (where valid credentials are provided).

## Usage
First, modify the "scrape" function (line 49) with the XPath to the data you are looking to obtain. There are chrome extensions and other websites which can help with this. You will also need to modify the "add_line" function (line 57) and append any variables which you would like to be stored.

Then initizible the web scraper:
```php
$ws = new WebScraper();
$ws->scrape(" url to scrape");
```
## Authentication required?
If login is needed to access the page, call the following method and provide the url and paramaters. 
```php
$ws->login(" login endpoint "," username=hello&password=world");
```
