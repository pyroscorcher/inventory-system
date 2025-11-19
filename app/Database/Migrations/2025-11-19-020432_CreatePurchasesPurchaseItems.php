<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesPurchaseItems extends Migration
{
    public function up()
    {
        // purchases (header)
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'supplier_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'purchase_date'=>['type'=>'DATE','null'=>true],
            'total'=>['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('supplier_id','suppliers','id','SET NULL','CASCADE');
        $this->forge->createTable('purchases');

        // purchase_items
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'purchase_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'item_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'qty'=>['type'=>'INT','constraint'=>11,'default'=>0],
            'cost_price'=>['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
            'subtotal'=>['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_id','purchases','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('item_id','items','id','RESTRICT','CASCADE');
        $this->forge->createTable('purchase_items');
    }

    public function down()
    {
        $this->forge->dropTable('purchase_items');
        $this->forge->dropTable('purchases');
    }
}
