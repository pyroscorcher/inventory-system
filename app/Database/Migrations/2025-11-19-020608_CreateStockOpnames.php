<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockOpnames extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'opname_date'=>['type'=>'DATE','null'=>true],
            'notes'=>['type'=>'TEXT','null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('stock_opnames');

        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'opname_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'item_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'system_qty'=>['type'=>'INT','default'=>0],
            'physical_qty'=>['type'=>'INT','default'=>0],
            'difference'=>['type'=>'INT','default'=>0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('opname_id','stock_opnames','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('item_id','items','id','RESTRICT','CASCADE');
        $this->forge->createTable('stock_opname_items');
    }

    public function down()
    {
        $this->forge->dropTable('stock_opname_items');
        $this->forge->dropTable('stock_opnames');
    }
}
