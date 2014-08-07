<?php
	class Leaveconfig extends Eloquent{
		protected $table = 'leaveconfig';

		public static function getConfig($leaveType,$year){
			// print_r(Leaveconfig::where("leave_type",$leaveType)->where("year",$year)->get());exit;
			$config = Leaveconfig::where("leave_type",$leaveType)->where("year",$year)->get()->first();
			if(!$config){
				$config = new Leaveconfig();
				$config->leave_type = $leaveType;
				$config->leave_days = 0;
				$config->year = date('Y');
			}
			return $config;
		}
	}
?>