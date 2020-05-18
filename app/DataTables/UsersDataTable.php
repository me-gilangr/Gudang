<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', function($data) {
                // $btn = '<a href="#" class="btn btn-danger btn-sm">'. $data->id .'</a>';
                $btn = '
                <div class="btn-group"> 
                    <a href="'.route('User.show', $data->id).'" class="btn btn-outline-info btn-sm flat mr-1">
                        <i class="fa fa-user"></i>
                    </a>
                    <a href="'.route('User.edit', $data->id).'" class="btn btn-outline-warning btn-sm flat">
                        <i class="fa fa-edit"></i>
                    </a>    
                    
                    <form action="'.route('User.destroy', $data->id).'" method="post">
                        '.csrf_field().'
                        '.method_field('delete').'
                        <button type="submit" class="btn btn-outline-danger btn-sm flat ml-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
                ';
                return $btn;
            })
            ->addColumn('level', function($data) {
                return $data->roles->first()->name;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom($dom)
            ->orderBy(1)
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
            Column::make('gender'),
            Column::make('level'),
            Column::make('created_at'),
            Column::make('updated_at'), 
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
        return 'Users_' . date('YmdHis');
    }
}
