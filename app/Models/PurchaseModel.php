<?php namespace App\Models;
use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases';
    protected $allowedFields = ['supplier_id','purchase_date','total','created_at'];
    protected $useTimestamps = true;
}
