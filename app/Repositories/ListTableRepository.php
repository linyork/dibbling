<?php

namespace App\Repositories;

use App\Model\ListTable;
use Yish\Generators\Foundation\Repository\Repository;

class ListTableRepository extends Repository
{
    /**
     * @var ListTable
     */
    protected $model;

    /**
     * ListTableRepository constructor.
     * @param ListTable $listTable
     */
    public function __construct(ListTable $listTable)
    {
        $this->model = $listTable;
    }
}
