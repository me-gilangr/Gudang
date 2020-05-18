<?php

namespace App\DataTables;

use App\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->editColumn('detail', function($data) {
                if ($data->detail == null) {
                    return '<i>Belum Ada Data</i>';
                } else {
                    return $data->detail;
                }
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group">  
                    <button class="btn btn-outline-warning btn-sm flat ml-1" id="data-edit" data-id="'.$data->id.'">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button class="btn btn-outline-danger btn-sm flat ml-1" id="data-delete" data-id="'.$data->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                ';
                return $btn;
            })
            ->rawColumns(['detail', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery();
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
            ->setTableId('category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom($dom)
            ->orderBy(0, 'asc')
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
            Column::make('id'),
            Column::make('name'),
            Column::make('detail'), 
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
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
        return 'Category_' . date('YmdHis');
    }
}
