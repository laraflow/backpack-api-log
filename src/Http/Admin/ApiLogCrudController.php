<?php

namespace Laraflow\BackpackApiLog\Http\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ApiLogCrudController
 *
 * @property-read CrudPanel $crud
 */
class ApiLogCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(config('backpack.api-log.model'));
        CRUD::setRoute(config('backpack.base.route_prefix'). config('backpack.api-log'));
        CRUD::setEntityNameStrings('api log', 'api logs');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        $options = [
            'method' => [
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'PATCH' => 'PATCH',
                'DELETE' => 'DELETE',
                'OPTION' => 'OPTION',
            ],
            'host' => [
                'mountainwest.prod.easyaskondemand.com' => 'mountainwest.prod.easyaskondemand.com',
                'internal.mwd1.com' => 'internal.mwd1.com',
                'www.cenpos.net' => 'www.cenpos.net',
            ],
            'code' => [
                '200' => '200',
                '400' => '400',
                '500' => '500',
                '404' => '404',
                '422' => '422',
                '419' => '419',
            ],
        ];

        CRUD::addFilter(
            [
                'name' => 'group',
                'type' => 'dropdown',
                'label' => 'Group',
            ],
            function () use (&$options) {
                return $options['group'];
            },
            function ($value) {
                $this->crud->addClause('where', 'group', '=', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'method',
                'type' => 'dropdown',
                'label' => 'Method',
            ],
            function () use (&$options) {
                return $options['method'];
            },
            function ($value) {
                $this->crud->addClause('where', 'method', '=', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'status_code',
                'type' => 'dropdown',
                'label' => 'Status Code',
            ],
            function () use (&$options) {
                return $options['code'];
            },
            function ($value) {
                $this->crud->addClause('where', 'status_code', '=', $value);
            }
        );

        CRUD::addFilter(
            [
                'type' => 'date_range',
                'name' => 'created_at',
                'label' => 'Created Between',
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'created_at', '>=', $value->from.' 00.00.01');
                $this->crud->addClause('where', 'created_at', '<=', $value->to.' 23:59:59');
            }
        );

        CRUD::column('id');
        CRUD::column('group');
        CRUD::column('method');
        CRUD::column('url')->type('url');
        CRUD::column('status_code')->type('number')->label('Code');
        CRUD::column('type');
        CRUD::column('created_at');
        CRUD::removeButton('update');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::setShowContentClass('col-md-12');

        CRUD::column('group');
        CRUD::column('method');
        CRUD::column('url')->type('text');
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'closure',
            'function' => function ($apiLog) {
                return $apiLog->status_code.' - '.$apiLog->status_text;
            }]);
        CRUD::column('type');
        CRUD::column('response_time')->suffix(' seconds')->label('Time');
        CRUD::column('request_header')->type('json');
        CRUD::column('request_body')->type('json');
        CRUD::column('response_header')->type('json');
        CRUD::column('response_body')->type('json');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }
}
