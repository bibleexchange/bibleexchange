<?php

class Statement extends Model {

  protected $hidden = ['id', 'created_at', 'updated_at'];
  protected $fillable = ['statement', 'active', 'voided', 'refs', 'lrs_id', 'timestamp', 'stored'];

  public function lrs(){
    return $this->belongsTo('Lrs');
  }

}
