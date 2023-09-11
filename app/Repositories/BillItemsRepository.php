<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\BillItem;

class BillItemsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'medicine_id',
        'bill_id',
        'qty',
        'price',
        'amount',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BillItem::class;
    }

    /**
     * @param  array  $billItemInput
     * @param  int  $billId
     *
     * @throws \Exception
     */
    public function updateBillItem($billItemInput, $billId)
    {
        /** @var Bill $bill */
        $bill = Bill::find($billId);
        $billItemIds = [];
        foreach ($billItemInput as $key => $data) {
            if (isset($data['id']) && ! empty($data['id'])) {
                $billItemIds[] = $data['id'];
                $this->update($data, $data['id']);
            } else {
                /** @var BillItem $billItem */
                $billItem = new BillItem($data);
                $billItem = $bill->billItems()->save($billItem);
                $billItemIds[] = $billItem->id;
            }
        }

        if (! (isset($billItemIds) && count($billItemIds))) {
            return;
        }
        BillItem::whereNotIn('id', $billItemIds)->whereBillId($bill->id)->delete();
    }
}
