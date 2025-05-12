<?php
namespace App\Interfaces;

interface  BaseInterface{
    /**
     * get all models
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns=['*'],array $relations=[],array $where=[],array $filter=[] , $paginate = 0) ;
    /**
     * find model by id
     * @param int $id
     * @param array $columns
     * @param array $relations
     * @return Model
     */
    public function find(int $id,array $columns=['*'],array $relations=[]);
    /**
     * create model
     * @param array $data
     * @return Model
     */
    public function store(array $data);
    /**
     * update existing model by id
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id ,array $data);
    /**
     * delete existing model by id
     * @param int $id
     * @return bool
    */
    public function delete(int $id);
     /**
     * Create Many Objects
     * @param array $data
     * @return bool
    */
    public function storeMany(array $data);

    /**
     * get Languages Collection
     * @return Model
    */
    public function languages();

}
