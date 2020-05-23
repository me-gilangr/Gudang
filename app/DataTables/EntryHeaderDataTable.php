<?php

namespace App\DataTables;

use App\EntryHeader;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EntryHeaderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('kode', function($data) {
                return $data->code;
            })
            ->addColumn('tanggal transaksi', function($data) {
                return date('d-m-Y H:i:s', strtotime($data->created_at));
            })
            ->addColumn('jumlah barang', function($data) {
                return count($data->detail) . ' Barang';
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group">  
                    <button class="btn btn-outline-info btn-sm flat ml-1" id="data-edit" data-id="'.$data->id.'">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                ';
                return $btn;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\EntryHeader $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EntryHeader $model)
    {
        return $model->with('detail')->orderBy('created_at', 'DESC')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $dom = "<'row'<'col-md-4 col-lg-4'l><'col-md-8 col-lg-8'f>>rtip";
        return $this->builder()
            ->setTableId('entry-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom($dom)
            ->addTableClass('table')
            ->autoWidth(true)
            ->lengthMenu([10, 25, 50], [10, 25, 50]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('kode'),
            Column::make('tanggal transaksi'), 
            Column::make('supplier'), 
            Column::make('description'), 
            Column::make('jumlah barang'), 
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EntryHeader_' . date('YmdHis');
    }
}
