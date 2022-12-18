<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectSpecificationSection
 * @package App\Models
 */
class ProjectSpecificationSection extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['project_specification_id', 'title', 'discount', 'active'];

    /**
     * @return HasOne
     */
    public function specification(): HasOne
    {
        return $this->hasOne(ProjectSpecification::class, 'id', 'project_specification_id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProjectSpecificationProduct::class,'project_specification_section_id',  'id')->orderBy('price', 'asc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(['active' => true]);
    }

    /**
     * @param int $specificationSectionId
     * @return bool
     * @throws \Exception
     */
    public static function deleteSection(int $specificationSectionId): bool
    {
        $projectSpecificationSection = self::query()->findOrFail($specificationSectionId);

        DB::beginTransaction();

        foreach ($projectSpecificationSection->products as $product) {
            $product->delete();
        }

        $result = $projectSpecificationSection->delete();

        DB::commit();

        return $result;
    }

    /**
     * @param int $specificationSectionId
     * @param array $params
     * @return bool
     */
    public static function updateSection(int $specificationSectionId, array $params): bool
    {
        $projectSpecificationSection = self::query()->findOrFail($specificationSectionId);

        DB::beginTransaction();

        if (isset($params['discount']) || isset($params['active'])) {
            foreach ($projectSpecificationSection->products as $product) {
                $product->fill(Arr::only($params, ['discount', 'active']))->trySaveModel();
            }
        }

        $result = $projectSpecificationSection->fill($params)->trySaveModel();

        DB::commit();

        return $result;
    }
}
