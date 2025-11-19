<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\ItemsModel;

class PurchaseController extends BaseController
{
    protected $purchaseModel;
    protected $purchaseItemModel;
    protected $itemModel;
    protected $db;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
        $this->purchaseItemModel = new PurchaseItemModel();
        $this->itemModel = new ItemsModel();
        $this->db = \Config\Database::connect();
    }

    public function create()
    {
        $data = $this->request->getPost();
        $items = $data['items'];

        $this->db->transStart();

        $purchaseId = $this->purchaseModel->insert([
            'supplier_id'=>$data['supplier_id'] ?? null,
            'purchase_date'=>$data['purchase_date'],
            'total'=>$data['total'] ?? 0,
        ]);
        foreach($items as $it) {
            $subtotal = $it['qty'] * $it['cost_price'];
            $this->purchaseItemModel->insert([
                'purchase_id'=>$purchaseId,
                'item_id'=>$it['item_id'],
                'qty'=>$it['qty'],
                'cost_price'=>$it['cost_price'],
                'subtotal'=>$subtotal
            ]);
            $item = $this->itemModel->find($it['item_id']);
            $newStock = $item['stock'] + (int)$it['qty'];
            $this->itemModel->update($it['item_id'], [
                'stock'=>$newStock,
                'cost_price'=>$it['cost_price'] // simple replace - adjust if you want weighted avg
            ]);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>'Failed to save purchase']);
        }

        return $this->response->setJSON(['success'=>true,'id'=>$purchaseId]);
    }
}
