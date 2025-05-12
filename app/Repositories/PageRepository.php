<?php
namespace App\Repositories;
use App\Interfaces\PageInterface;
use App\Models\Page;

class PageRepository extends BaseRepository implements PageInterface
{

    protected $model;
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

}
