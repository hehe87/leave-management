<?php

class BaseController extends Controller {
	public function __construct(){
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	protected function pre_print($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit;
	}

}
