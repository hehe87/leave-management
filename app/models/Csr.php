<?php

class Csr extends \Eloquent {
	protected $fillable = ['leave_id', 'from_time', 'to_time', 'completion_note'];
  protected $table = "csr";
  public static $rules = [
    'from_time' => 'required|date_format:H:i A',
    'to_time'   => 'required|date_format:H:i A',
    ];
    
  public function leave()
  {
    return $this->belongsTo('leave');
  }
}