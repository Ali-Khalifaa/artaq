<?php
namespace App\Repositories;
use App\Interfaces\LanguageInterface;
use App\Models\Language;

class LanguageRepository extends BaseRepository implements LanguageInterface
{

    protected $model;
    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function all(array $columns=['*'],array $relations=[],array $where=[],array $filter=[] , $paginate = 0)
    {
        $search    = @$filter['search'];
        $is_status = array_key_exists('status' , $filter);
        $status    = @$filter['status'] == 'false' ? 0 : @$filter['status'];
        $status    = (bool)$status;
        $data      = $this->model->where($where)->with($relations)
        ->where(function ($language) use($search){
            $language->when($search, function ($language) use ($search) {
                $language->where('code' , 'LIKE' , "%$search%")
                ->orWhere('id' , 'LIKE' , "%$search%")
                ->orWhereHas('translations' ,function($translatin) use($search){
                    $translatin->where('title' , 'LIKE' , "%$search%");
                });
            });
        })
        ->where(function ($language) use($status , $is_status){
            $language->when($is_status,function ($language) use($status){
                return $language->where('status',$status);
            });
        })
        ->latest();

        if($paginate){
            return $data->paginate($paginate);
        }
        return $data->get($columns);
    }

    public function delete(int $id)
    {
        $model = $this->find($id);
        if(!$model){ return false;}
        unlink_image_by_path($model->flag);
        return $model->delete();
    }


    public function update(int $id ,array $data)
    {
        $model = $this->find($id);
        unlink_image_by_path($model->flag);
        $data['status'] = @$data['status'] ? 1 : 0;
        $model->update( $data );
        return $model;
    }

}
