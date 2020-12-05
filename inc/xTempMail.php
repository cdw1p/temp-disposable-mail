<?php
/**
* 
*/
class xTempMail{
	private $template;
	private $language;
	private $parameter;

	function __construct(){

	}

	public function TEMPLATE($X){
		$this->template=$X;
	}

	public function PARAMETER($X){
		$this->parameter=$X;
	}




	public function LANGUAGE($X){
		$this->language=$X;
	}

	public function LANGUAGE_AUTODETECT(){
		$this->language='en';
	}	

	public function RENDER(){
		if (!file_exists("inc/".$this->template.".php")) exit("Template Error!");
		include("lang/".$this->language.".php");
		if ($this->parameter != '') {
			$source_id = $this->parameter;
		}
		include("inc/".$this->template.".php");
	}
	public function CHECKCHMOD(){
		if (0755 !== (fileperms('pipe.php') & 0777)) {
			chmod('pipe.php', 0755);
		}
	}

}

?>