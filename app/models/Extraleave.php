<?php
  class Extraleave extends Eloquent{
    
    public function user(){
      return $this->belongsTo("User");
    }
    public static function getPaternityLeaveInfo($userId, $forYear){
      return Extraleave::where("user_id", $userId)->where("for_year", $forYear)->where("description", "LIKE", "%Paternity%")->first();
    }
    
    public static function getMaternityLeaveInfo($userId, $forYear){
      return Extraleave::where("user_id", $userId)->where("for_year", $forYear)->where("description", "LIKE", "%Maternity%")->first();
    }
    
    public static function getExtraLeavesInfo($userId, $forYear){
      return Extraleave::where("user_id", $userId)->where("for_year", $forYear)->get();
    }
  }
?>