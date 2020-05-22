<?php

namespace App\DataTables;

use App\Stuff;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StuffDataTable extends DataTable
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
            ->addColumn('nama', function($data) {
                return $data->name;
            })
            ->addColumn('kategori', function($data) { 
                return $data->category->name;
            })
            ->addColumn('lokasi barang', function($data) {
                return $data->storage->name;
            })
            ->addColumn('action', function($data) {
                $btn = '
                <div class="btn-group"> 
                    <a href="'.route('Stuff.show', $data->id).'" class="btn btn-outline-info btn-sm flat mr-1">
                        <i class="fa fa-info"></i>
                    </a>
                    <a href="'.route('Stuff.edit', $data->id).'" class="btn btn-outline-warning btn-sm flat">
                        <i class="fa fa-edit"></i>
                    </a>    
                    
                    <form action="'.route('Stuff.destroy', $data->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('delete').'
                        <button type="submit" class="btn btn-outline-danger btn-sm flat ml-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
                ';
                return $btn;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Stuff $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Stuff $model)
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
            ->setTableId('stuff-table')
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
            Column::make('nama'),
            Column::make('kategori'),
            Column::make('lokasi barang'),
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
        return 'Stuff_' . date('YmdHis');
    }
}
