<?php
/**

  Class Name					:	TemplateFunctions
  author 						:	Nicolas Naresh
  Date							:	June 16, 2014
  Purpose						:	asts as Template functions library contains functions to be used in laravel
  									templates.
*/

class TemplateFunction{
	public static function getIntegerRangeDropdown($from, $to){
		$arr = array_map(function($i)
			{ 
				return sprintf("%02s",$i); 
			}, 
			range($from, $to)
		);
		$arr1 = array_combine($arr,$arr);
		return $arr1;
	}

	public static function getFullLeaveTypeName($ltype){
		$fullNames = array(
			"LEAVE" => "Full Day Leave",
			"FH" => "First Half",
			"SH" => "Second Half",
			"CSR" => "CSR",
			"LONG" => "Long Leave"
		);
		return $fullNames[$ltype];
	}
}