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

	public function saveEditable(){
		$inputs = Input::all();
		// $this->pre_print($inputs);
		$modelName = trim(TemplateFunction::originalName($inputs["model"]));
		$modelId = trim(TemplateFunction::originalName($inputs["id"]));
		$columnName = trim(TemplateFunction::originalName($inputs["column"]));
		$value = trim($inputs["value"]);
		$saveData = true;
		if(class_exists($modelName)){
			if($modelName == "User" && $columnName == "carry_forward_leaves"){
				$year = date("Y");
				$maxCarryForwardLeave = Leaveconfig::where("year", $year)->where("leave_type","carry_forward_leaves")->first();
				if($maxCarryForwardLeave){
					$maxCarryForwardLeave = (int)($maxCarryForwardLeave->leave_days);
				}
				else{
					$maxCarryForwardLeave = 5;
				}
				$value = (int)$value;
				if($value > $maxCarryForwardLeave){
					$saveData = false;
				}
			}
			if($saveData){
				$modelObj = $modelName::find($modelId);
				$modelObj->$columnName = $value;
				$modelObj->save();
				return Response::json(array("status" => true));
			}
			else{
				return Response::json(array("status" => false));
			}
		}
		else{
			return Response::json(array("status" => false));
		}
		
		
	}

}
