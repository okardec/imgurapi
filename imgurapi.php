<?php
/**
 * ImgUR API.
 * @link https://apidocs.imgur.com/?version=latest#intro
 */
class ImgurAPI{
	/**
	 * Object formed by JSON returned by API.
	 *
	 * @var Json
	 */
	protected $response;
	 
	/**
	 * Path to the API.
	 *
	 */
	const PATH_API = "https://api.imgur.com/3/image.json";
	
	/**
	 * to generate a new client_id use the url below
	 * https://api.imgur.com/oauth2/addclient
	 */
	const CLIENT_ID = 'xxxxxxxxxx';
	const CLIENT_SECRET = 'xxxxxxxxxxxx';
		
		
	/**
	 * Builder method
	 *
	 */
	public function __construct(){
		
	}
	/**
	 * set the object
	 *
	 * @param JSON  
	 */
	protected function setResponse($response){
		$this->response = $response;
	}
	/**
	 * Returns the object
	 *
	 * @return JSON
	 */
	public function getResponse(){
		return $this->response;
	}
	
	/**
  * verify that the patch is valid by checking the
  * @param String $path
  * @return boolean
  */
	protected function isImage($path){
		$i = explode('.',strtolower($path));
		$n = count($i);
		$ext = $i[$n-1];
		
				
		$aEx = array('jpg','jpeg','png','gif','bmp');
		
		if (in_array(strtolower($ext),$aEx)){
			return true;
		}  
		return false;
	}

	
	/**
	 * send the image
	 *
	 * @param string $ImageFilePath
	 */
	protected function send($ImageFilePath){
	
		if (strlen($ImageFilePath)<=0){
			throw new Exception('Enter the path of the Image to send');
		}		
		if (!$this->isImage($ImageFilePath)){
			throw new Exception('Path entered is not a valid image');
		}
				 
		$image = file_get_contents($ImageFilePath);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::PATH_API);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( "Authorization: Client-ID ".self::CLIENT_ID ));
		curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = curl_exec($ch);
		
		curl_close($ch);
		
		$response = json_decode($response);
		
		$this->setResponse($response);
	
	
	}
	
	/**
	 * verify that it was sent correctly
	 *
	 * @return boolean
	 */
	protected function isValidResponde(){
		$r = $this->getResponse();
		if (!isset($r->success) || !$r->success){
			//throw new Exception('Não foi possivel enviar a imagem');
			return false;
		} 
		return true;
	}
	
	/**
	 * send the image, return the new path if it is uploaded, return a blank case of error
	 *
	 * @param string $ImageFilePath
	 * @return string
	 */
	public function sendImage($ImageFilePath){
		
		$this->send($ImageFilePath);		
		if ($this->isValidResponde()){	
			
			$r = $this->getResponse();
			return $r->data->link;
			
		}else{
			return '';
		}
		
	}

}

?>
