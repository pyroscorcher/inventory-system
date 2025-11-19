<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalesSaleItems extends Migration
{
    public function up()
    {
        // sales header
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'customer_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'sale_date'=>['type'=>'DATE','null'=>true],
            'total'=>['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('customer_id','customers','id','SET NULL','CASCADE');
        $this->forge->createTable('sales');

        // sale_items
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'sale_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'item_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'qty'=>['type'=>'INT','constraint'=>11,'default'=>0],
            'sale_price'=>['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
            'subtotal'=>['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('sale_id','sales','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('item_id','items','id','RESTRICT','CASCADE');
        $this->forge->createTable('sale_items');
    }

    public function down()
    {
        $this->forge->dropTable('sale_items');
        $this->forge->dropTable('sales');
    }
}
