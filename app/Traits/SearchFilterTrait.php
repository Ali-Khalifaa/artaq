<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\LanguageTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait SearchFilterTrait
{

    public function scopeSearchAndFilter($query)
    {
        return $query->where(function ($q) {
            $search = json_decode(request()->search);

            $q->when($searchKey = $search?->searchKey, function ($q) use ($search, $searchKey) {

                foreach ($search?->columns ?? [] as $index => $column){
                    if($index == 0)
                        $q->where($column, 'LIKE', "%$searchKey%");
                    else
                        $q->orWhere($column, 'LIKE', "%$searchKey%");
                }

                if ($search?->searchInTranslations)
                    $q->orWhereHas('translations', function ($q) use ($searchKey) {
                        $q->where('title', 'LIKE', "%$searchKey%");
                        $q->orWhere('description', 'LIKE', "%$searchKey%");
                    });


                // search in relations and relation translations
                if ($search?->searchInRelations) {
                    foreach ($search?->searchInRelations ?? [] as $relation) {
                        $q->orWhereHas($relation->relation, function ($q) use ($searchKey, $relation) {
                            foreach ($relation?->columns ?? [] as $index => $column){
                                if($index == 0)
                                    $q->where($column, 'LIKE', "%$searchKey%");
                                else
                                    $q->orWhere($column, 'LIKE', "%$searchKey%");
                            }
                            if ($relation->searchInRelationTranslations)
                                $q->orWhereHas('translations', function ($q) use ($searchKey) {
                                    $q->where('title', 'LIKE', "%$searchKey%");
                                    $q->orWhere('description', 'LIKE', "%$searchKey%");
                                });
                        });
                    }
                }
            });

            if(request()->service_type)
                $q->where('service_type', request()->service_type);

        })
        ->where(function ($q) {
            $q->when(request()->filterColumns, function ($q) {
                foreach (request()->filterColumns['columns'] ?? [] as $row) {
                    if(isset($row['value'])){
                        if($row['searchType'] == 'whereIn')
                            $q->whereIn($row['column'], $row['value']);
                        elseif($row['searchType'] == 'date')
                            $q->whereDate($row['column'], $row['opreator'], $row['value']);
                        elseif($row['searchType'] == 'whereRelation')
                            $q->whereRelation($row['relation_name'],$row['column'], $row['opreator'], $row['value']);
                        else
                            $q->where($row['column'], $row['opreator'], $row['value']);
                    }
                }
            });
        });
    }
}
