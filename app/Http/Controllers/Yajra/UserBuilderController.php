<?php

namespace App\Http\Controllers\Yajra;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use App\Models\User;
use Illuminate\View\View;

class UserBuilderController extends Controller
{
    /**
     * function for yajra data-table
     */
    public function index(Builder $builder): View
    {
        $this->authorize('viewAny', User::class);

        $html = $builder
            ->setTableId('users-table')

            ->columns([
                Column::computed('DT_RowIndex')
                    ->title('#')
                    ->orderable(false)
                    ->searchable(false),

                Column::make('name')->title('Name'),
                Column::make('email')->title('Email'),
                // Column::make('email')->title('Mobile'),

                Column::make('roles')
                    ->title('Roles')
                    ->orderable(false)
                    ->searchable(false),

                Column::make('created_at')
                    ->title('Created At')
                    ->orderable(false),

                Column::make('action')
                    ->title('Action')
                    ->orderable(false)
                    ->searchable(false)
                    ->addClass('text-center'),
            ])

            ->ajax([
                'url' => route('users.list'),
                'type' => 'GET',
                'data' => 'function(d) {
                    d.name = $("#name_filter").val();
                    d.from_date = $("#from_date").val();
                    d.to_date = $("#to_date").val();
                    d.roles = $("#role_filter").val();
                }',
            ])

            ->processing(true)
            ->serverSide(true)
            ->orderBy(1, "asc")
            ->pageLength(3)
            ->lengthMenu([3, 10, 50, 100]);

        return view('user.yajra-index', compact('html'));
    }
}
