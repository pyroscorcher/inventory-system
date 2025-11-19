<?php namespace App\Models;
use CodeIgniter\Model;

class ItemsModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code','name','unit_id','category_id','stock','cost_price','active','created_at','updated_at'];
    protected $useTimestamps = true;
}
