<?php
namespace ManyHong\ModernPHP\Url;
use \GuzzleHttp\Client;
use \League\Csv\Reader;
class Scanner
{
	protected $urls;
	protected $httpClient;

	public function __construct(array $urls){
      $this->urls = $urls;
      $this->httpClient = new Client();
	}

	public function getInvalidUrls(){
		$invalidUrls = [];
		foreach ($this->urls as $url) {
			try{
              $statusCode = $this->getStatusCodeForUrl($url));
			}catch(\Exception $e){
              $statusCode = 500;
			}
			if($statusCode >= 400){
				array_push($invalidUrls,[
                   'url'=>$url,
                   'status'=>$statusCode,
			    ]);
			}
		}
		return $invalidUrls;
	}

    protected function getStatusCodeForUrl($url){
    	$httpResponse = $this->httpClient->options($url);
    	return $httpResponse->getStatusCode();
    }
}