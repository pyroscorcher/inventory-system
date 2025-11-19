<?php namespace App\Models;
use CodeIgniter\Model;

class PurchaseItemModel extends Model
{
    protected $table = 'purchase_items';
    protected $allowedFields = ['purchase_id','item_id','qty','cost_price','subtotal'];
}
