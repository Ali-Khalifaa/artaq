<?php
namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model =$model;
    }

    public function all(array $columns=['*'],array $relations=[],array $where=[],array $filter=[] , $paginate = 0)
    {
        $data = $this->model->where($where)->with($relations);
        if($paginate){
            return $data->paginate($paginate);
        }
        return $data->get($columns);
    }

    public function find(int $id,array $columns=['*'],array $relations=[])
    {
        return $this->model->select($columns)->with($relations)->find($id) ;
    }

    public function store(array $data)
    {
        $data['status'] = @$data['status'] ? 1 : 0;
        $model = $this->model->create( $data );
        $model->setTranslations($data['translations']);
        return $model->fresh();
    }

    public function update(int $id ,array $data)
    {
        $model = $this->find($id);
        $data['status'] = @$data['status'] ? 1 : 0;
        $model->update( $data );
        $model->setTranslations($data['translations']);
        return $model;
    }

    public function delete(int $id)
    {
        $model = $this->find($id);
        if(!$model){ return false;}
        unlink_image_by_path(@$model->getAttributes()['image']);
        return $model->delete();
    }

    public function storeMany(array $data)
    {
        foreach($data as $row)
        {
            $this->store($row);
        }

    }

    public function query(array $where=[])
    {
        return $this->model->where($where);
    }

    public function changeStatus(int $id)
    {
        $model = $this->find($id);
        $model->status = $model->status == 1 ? 0 : 1 ;
        return $model->save();

    }

    public function languages()
    {
        return Language::where('is_active' , 1)->get();
    }
}
