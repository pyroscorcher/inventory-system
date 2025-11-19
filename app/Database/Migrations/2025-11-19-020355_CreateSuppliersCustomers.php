<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuppliersCustomers extends Migration
{
    public function up()
    {
        // suppliers
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name'=>['type'=>'VARCHAR','constraint'=>255],
            'phone'=>['type'=>'VARCHAR','constraint'=>50,'null'=>true],
            'address'=>['type'=>'TEXT','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('suppliers');

        // customers
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name'=>['type'=>'VARCHAR','constraint'=>255],
            'phone'=>['type'=>'VARCHAR','constraint'=>50,'null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers');
    }

    public function down()
    {
        $this->forge->dropTable('customers');
        $this->forge->dropTable('suppliers');
    }
}
