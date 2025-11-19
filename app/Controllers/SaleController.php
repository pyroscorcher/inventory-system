<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Models\SaleItemModel;   
use App\Models\ItemsModel;

class SaleController extends BaseController
{
    protected $saleModel;
    protected $saleItemModel;
    protected $itemModel;
    protected $db;

    public function __construct()
    {
        $this->saleModel = new \App\Models\SaleModel();
        $this->saleItemModel = new \App\Models\SaleItemModel();
        $this->itemModel = new ItemsModel();
        $this->db = \Config\Database::connect();
    }

    public function create()
    {
        $data = $this->request->getPost();
        $items = $data['items'];

        // Validate stock first
        foreach($items as $it) {
            $item = $this->itemModel->find($it['item_id']);
            if (!$item) return $this->response->setStatusCode(404)->setJSON(['error'=>'Item not found']);
            if ($item['stock'] < (int)$it['qty']) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error'=>"Insufficient stock for item {$item['name']}. Available {$item['stock']}"
                ]);
            }
        }

        $this->db->transStart();

        $saleId = $this->saleModel->insert([
            'customer_id'=>$data['customer_id'] ?? null,
            'sale_date'=>$data['sale_date'],
            'total'=>$data['total'] ?? 0,
        ]);

        foreach($items as $it) {
            $subtotal = $it['qty'] * $it['sale_price'];
            $this->saleItemModel->insert([
                'sale_id'=>$saleId,
                'item_id'=>$it['item_id'],
                'qty'=>$it['qty'],
                'sale_price'=>$it['sale_price'],
                'subtotal'=>$subtotal,
            ]);
            // decrement stock
            $item = $this->itemModel->find($it['item_id']);
            $newStock = $item['stock'] - (int)$it['qty'];
            $this->itemModel->update($it['item_id'], ['stock'=>$newStock]);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>'Failed to save sale']);
        }

        return $this->response->setJSON(['success'=>true,'id'=>$saleId]);
    }
}
