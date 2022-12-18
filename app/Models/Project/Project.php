<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasExternalEntity;

/**
 * Class Project
 * @package App\Models
 */
class Project extends BaseModel
{
    use HasExternalEntity;

    public const MIN_AMOUNT = 1;

    public const MAX_AMOUNT = 100;

    /**
     * @var array
     */
    protected $fillable = ['title', 'address', 'user_id', 'project_status_id', 'session_key', 'total_price'];

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'int'
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(ProjectStatus::class, 'id', 'project_status_id');
    }

    /**
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(ProjectContact::class, 'project_id')->orderBy('name', 'asc');
    }

    /**
     * @return HasMany
     */
    public function projectsAttributes(): HasMany
    {
        return $this->hasMany(ProjectAttributesProject::class, 'project_id')->orderBy('id', 'desc');
    }

    /**
     * @return BelongsToMany
     */
    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'project_product_categories');
    }

    /**
     * @return belongsToMany
     */
    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class, 'project_products')
            ->withPivot([
                'amount', 'not_used_amount', 'in_stock', 'discount', 'active',
                'id', 'real_price', 'price_with_discount'
            ])
            ->orderBy('rank', 'desc');
    }

    /**
     * @return hasMany
     */
    public function specifications(): hasMany
    {
        return $this->hasMany(ProjectSpecification::class,'project_id',  'id')->orderBy('id', 'desc');
    }

    /**
     * Изменение в получении спецификации из-за того, что клиент сказал что пока не нужна версионость
     * спицификаций. Что она будет всегда одна. Но я ему ен верю, знаю след спринты. Поэтому пока
     * такая штука.
     *
     * @return ProjectSpecification|null
     */
    public function specification(): ?ProjectSpecification
    {
        return $this->specifications()->get()->first();
    }

    /**
     * @param array $params
     * @return Project
     */
    public static function create(array $params = []): self
    {
        if (!isset($params['project_status_id'])) {
            $status = ProjectStatus::query()->select(['id'])->where(['slug' => 'in_work'])->first();

            if ($status) {
                $params['project_status_id'] = $status->id;
            }
        }

        $model = new self($params);

        /**
         * Нужно для определения проектов у не залогиненных юзверов
         */
        if ($session = Auth::guard()->getSession()) {
            $model->session_key = $session->getId();
        }

        $model->trySaveModel();

        return $model;
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return static
     */
    public static function updateProject(int $projectId, array $params = []): self
    {
        DB::beginTransaction();

        $project = self::query()->findOrFail($projectId);
        $project->fill($params);
        $project->trySaveModel();

        $project->contacts()->delete();
        if (isset($params['contacts'])) {
            self::updateContacts($projectId, $params['contacts']);
        }

        $project->projectsAttributes()->delete();
        if (isset($params['attributes'])) {
            self::updateAttributes($projectId, $params['attributes']);
        }

        DB::commit();

        return $project;
    }

    /**
     * Прикрепляем контакты
     *
     * @param int $projectId
     * @param array $contacts
     * @return bool
     */
    public static function updateContacts(int $projectId, array $contacts): bool
    {
        $project = self::query()->findOrFail($projectId);

        foreach ($contacts as $contact) {
            $project->contacts()->create($contact);
        }

        return true;
    }

    /**
     * @param int $projectId
     * @param array $attributes
     * @return bool
     */
    public static function updateAttributes(int $projectId, array $attributes): bool
    {
        $project = self::query()->findOrFail($projectId);

        foreach ($attributes as $attribute) {
            $projectAttributeValue = ProjectAttributeValue::query()->findOrFail($attribute);

            $project->projectsAttributes()->create([
                'project_attribute_id' => $projectAttributeValue->project_attribute_id,
                'project_attribute_value_id' => $projectAttributeValue->id,
            ]);
        }

        return true;
    }

    /**
     * @return array
     */
    public static function getConditionsForOwner(): array
    {
        $conditions = [];

        $user = Auth::user();
        if (!empty($user)) {
            $conditions['user_id'] = $user->getAuthIdentifier();
        }

        if (!$user && $session = Auth::guard()->getSession()) {
            $conditions['session_key'] = $session->getId();
        }

        return $conditions;
    }

    /**
     * @return bool
     */
    public function checkOwnerPermission(): bool
    {
        $hasPermission = false;

        foreach (self::getConditionsForOwner() as $conditionKey => $conditionValue) {
            if ($this[$conditionKey] === $conditionValue) {
                $hasPermission = true;
            } else {
                $hasPermission = false;
            }
        }

        if (!empty($this->user_id) && Auth::guest()) {
            $hasPermission = false;
        }

        return $hasPermission;
    }

    /**
     * @param int $productId
     * @param array $projects
     * @return bool
     */
    public static function addProductToProjects(int $productId, array $projects): bool
    {
        $product = Product::query()->findOrFail($productId);

        DB::beginTransaction();

        foreach ($projects as $project) {
            self::addCategory($project['project'], $product->category_id);

            $amount = $project['amount'] ?? 1;
            self::addProduct($project['project'], $productId, $product->recommended_retail_price, $amount);
        }

        DB::commit();

        return true;
    }

    /**
     * Привязываем категорию товара к проекту
     *
     * @param int $projectId
     * @param int $productCategoryId
     * @return bool
     */
    public static function addCategory(int $projectId, int $productCategoryId): bool
    {
        return ProjectProductCategory::query()->firstOrNew([
            'product_category_id' => $productCategoryId,
            'project_id' => $projectId,
        ])->trySaveModel();
    }

    /**
     * Добавляем товар к проету
     *
     * @param int $projectId
     * @param int $productId
     * @param float $productPrice
     * @param int $amount
     * @return bool
     */
    public static function addProduct(int $projectId, int $productId, float $productPrice, int $amount = 1): bool
    {
        if ($amount < static::MIN_AMOUNT) {
            $amount = static::MIN_AMOUNT;
        }

        if ($amount > static::MAX_AMOUNT) {
            $amount = static::MAX_AMOUNT;
        }

        return ProjectProduct::query()->firstOrNew([
            'product_id' => $productId,
            'project_id' => $projectId,
        ])->fill([
            'amount' => $amount,
            'not_used_amount' => $amount,
            'real_price' => $productPrice,
            'price_with_discount' => $productPrice,
        ])->trySaveModel();
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @return bool
     * @throws \Exception
     */
    public static function deleteProductFromProject(int $projectId, int $productId): bool
    {
        $projectProduct = ProjectProduct::query()->where([
            'product_id' => $productId,
            'project_id' => $projectId,
        ])->first();

        $result = true;
        if ($projectProduct) {
            $result = $projectProduct->delete();
        }

        return $result;
    }

    /**
     * @param int $projectId
     * @return ProjectSpecification
     */
    public static function createSpecification(int $projectId): ProjectSpecification
    {
        $project = self::query()->findOrFail($projectId);

        DB::beginTransaction();

        $specification = $project->specification();
        if ($specification === null) {
            $specification = $project->specifications()->create();
        }

        DB::commit();

        return $specification;
    }

    /**
     * @param int $projectId
     * @return bool
     * @throws \Exception
     */
    public static function deleteProject(int $projectId): bool
    {
        $project = self::query()->findOrFail($projectId);

        return $project->delete();
    }

    /**
     * @param int $projectId
     * @param int $productId
     * @param array $params
     * @return bool
     */
    public static function updateProjectProduct(int $projectId, int $productId, array $params): bool
    {
        return ProjectProduct::query()->where([
            'product_id' => $productId,
            'project_id' => $projectId,
        ])->firstOrFail()->fill($params)->trySaveModel();
    }

    /**
     * @param int $projectId
     * @param array $params
     * @return $this
     */
    public static function updateOnlyProject(int $projectId, array $params = []): self
    {
        $project = self::query()->findOrFail($projectId);
        $project->fill($params);
        $project->saveQuietly();

        return $project;
    }

    /**
     * @param int $projectId
     * @param int $productCategoryId
     * @return bool
     * @throws \Exception
     */
    public static function deleteCategoryFromProject(int $projectId, int $productCategoryId): bool
    {
        return ProjectProductCategory::query()->where([
            'product_category_id' => $productCategoryId,
            'project_id' => $projectId,
        ])->delete();
    }
}
