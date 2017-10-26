<?php

namespace App\DataTables;

use App\Models\GiftCard;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Services\DataTable;

class GiftCardsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\Datatables\Engines\BaseEngine
     */
    public function dataTable()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('created_at', function ($record) {
                return date('m/d/Y', strtotime($record->created_at));
            })
            ->filterColumn('gift_cards.created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(gift_cards.created_at, '%m/%d/%Y') like ?", ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($record) {
                $viewLink = '<div style="text-align: center"><a href="' . url('admin/orders/' . $record->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a></div>';
                return $viewLink;
            });
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        // $query = GiftCard::query()->select($this->getColumns());
        $query = GiftCard::leftJoin('delivery_types', function ($join) {
                    $join->on('delivery_types.id', '=', 'gift_cards.delivery_id');
                })
                ->leftJoin('shipping_methods', function($join) {
                    $join->on('shipping_methods.id', '=', 'gift_cards.shipping_id');
                })
                ->select(['gift_cards.id AS id', 'gift_cards.order_number AS order_number', 'gift_cards.code AS order_code', 'gift_cards.reference AS order_reference', 'gift_cards.amount AS amount', 'gift_cards.quantity AS quantity', 'gift_cards.shipping AS shipping', 'gift_cards.total AS total', 'gift_cards.sendto AS sendto', 'gift_cards.name AS name', 'gift_cards.email AS email', 'gift_cards.phone AS phone', 'gift_cards.address AS address', 'gift_cards.address2 AS address2', 'gift_cards.city AS city', 'gift_cards.state AS state', 'gift_cards.zip AS zip', 'gift_cards.country AS country', 'gift_cards.cctype AS cctype', 'gift_cards.ccnumber AS ccnumber', 'gift_cards.created_at AS created_at', 'delivery_types.name AS delivery_type', 'shipping_methods.name AS shipping_method'])
                ->where('gift_cards.status', 'Approved');

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            // ->columns($this->getColumns())
            ->addColumn(['data' => 'id', 'name' => 'gift_cards.id', 'title' => 'Id', 'visible' => false])
            ->addColumn(['data' => 'order_number', 'name' => 'gift_cards.order_number', 'title' => 'Order #'])
            ->addColumn(['data' => 'order_code', 'name' => 'gift_cards.code', 'title' => 'Order Code', 'visible' => false])
            ->addColumn(['data' => 'order_reference', 'name' => 'gift_cards.reference', 'title' => 'Order Ref.', 'visible' => false])
            ->addColumn(['data' => 'amount', 'name' => 'gift_cards.amount', 'title' => 'Amount', 'visible' => false])
            ->addColumn(['data' => 'quantity', 'name' => 'gift_cards.quantity', 'title' => 'Qty', 'visible' => false])
            ->addColumn(['data' => 'shipping', 'name' => 'gift_cards.shipping', 'title' => 'Shipping', 'visible' => false])
            ->addColumn(['data' => 'total', 'name' => 'gift_cards.total', 'title' => 'Total'])
            // ->addColumn(['data' => 'sendto', 'name' => 'gift_cards.sendto', 'title' => 'Send To'])
            ->addColumn(['data' => 'delivery_type', 'name' => 'delivery_types.name', 'title' => 'Delivery Type'])
            ->addColumn(['data' => 'shipping_method', 'name' => 'shipping_methods.name', 'title' => 'Shipping Method', 'visible' => false])
            ->addColumn(['data' => 'name', 'name' => 'gift_cards.name', 'title' => 'Name'])
            ->addColumn(['data' => 'email', 'name' => 'gift_cards.email', 'title' => 'Email'])
            ->addColumn(['data' => 'phone', 'name' => 'gift_cards.phone', 'title' => 'Phone', 'visible' => false])
            ->addColumn(['data' => 'address', 'name' => 'gift_cards.address', 'title' => 'Address'])
            ->addColumn(['data' => 'address2', 'name' => 'gift_cards.address2', 'title' => 'Address 2', 'visible' => false])
            ->addColumn(['data' => 'city', 'name' => 'gift_cards.city', 'title' => 'City'])
            ->addColumn(['data' => 'state', 'name' => 'gift_cards.state', 'title' => 'State'])
            ->addColumn(['data' => 'zip', 'name' => 'gift_cards.zip', 'title' => 'Zip Code', 'visible' => false])
            ->addColumn(['data' => 'country', 'name' => 'gift_cards.country', 'title' => 'Country', 'visible' => false])
            ->addColumn(['data' => 'cctype', 'name' => 'gift_cards.cctype', 'title' => 'CC Type', 'visible' => false])
            ->addColumn(['data' => 'ccnumber', 'name' => 'gift_cards.ccnumber', 'title' => 'CC Number', 'visible' => false])
            ->addColumn(['data' => 'created_at', 'name' => 'gift_cards.created_at', 'title' => 'Date', 'type' => 'date'])
            ->minifiedAjax('')
            ->addAction(['width' => '80px'])
            ->parameters([
                // 'dom'     => 'Bfrtip',
                'dom' => 'lBfrtip',
                'order' => [[0, 'desc']],
                'buttons' => ['csv', 'excel', 'print', 'reset', 'reload']
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'total',
            'name',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'giftcardsdatatable_' . time();
    }
}
