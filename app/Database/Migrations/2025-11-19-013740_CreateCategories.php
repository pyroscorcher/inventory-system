<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUnitsCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>50],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('units');

        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');

        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'code' => ['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>255],
            'unit_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'category_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'stock' => ['type'=>'INT','constraint'=>11,'default'=>0],
            'cost_price' => ['type'=>'DECIMAL','constraint'=>'15,2','default'=>0],
            'active' => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('unit_id','units','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('category_id','categories','id','SET NULL','CASCADE');
        $this->forge->createTable('items');
    }

    public function down()
    {
        $this->forge->dropTable('items');
        $this->forge->dropTable('categories');
        $this->forge->dropTable('units');
    }
}
