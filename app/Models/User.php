<?php

namespace App\Models;

use App\Collections\User\UserCollection;
use App\Domain\Dictionaries\Users\RolesDictionary;
use App\Models\Project\Project;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasExternalEntity;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Models\Loyalty\Loyalty;
use App\Models\Loyalty\LoyaltyUser;
use App\Traits\Translatable;
use App\Domain\Dictionaries\Loyalty\LoyaltyUserStatuses;
use App\Notifications\HasNotificationTransport;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class User
 * @package App\Models
 * @property bool $email_subscription Пользователь согласен получать рекламные рассылки
 */
class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, MustVerifyEmailContract
{
    use Notifiable;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;
    use HasRoleAndPermission;
    use HasExternalEntity;
    use Translatable;
    use HasNotificationTransport;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'city_id', 'phone', 'email', 'password', 'personal_data_agreement_at',
        'photo', 'published', 'show_contacts', 'email_verified_at', 'publish_ban', 'source', 'personal_site',
        'email_subscription', 'birthday', 'sended_to_remote', 'points_awarded'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
        'show_contacts' => 'boolean',
        'publish_ban' => 'boolean',
        'email_subscription' => 'boolean',
        'birthday' => 'date',
    ];

    /**
     * @param array $models
     * @return UserCollection
     */
    public function newCollection(array $models = []): UserCollection
    {
        return new UserCollection($models);
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'user_id')->orderBy('title', 'asc');
    }

    /**
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteProduct::class, 'user_id')->orderBy('id', 'desc');
    }

    /**
     * @return BelongsToMany
     */
    public function loyalties(): BelongsToMany
    {
        return $this->belongsToMany(Loyalty::class, 'loyalty_users')->orderBy('id', 'asc');
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return HasMany
     */
    public function loyaltyUsers(): HasMany
    {
        return $this->hasMany(LoyaltyUser::class);
    }

    /**
     * @return HasMany
     */
    public function projectsActivities(): HasMany
    {
        return $this->hasMany(UserActivity::class)->where(['source_type' => Project::class]);
    }

    /**
     * @return hasOne
     */

     public function personalData(): HasOne
     {
         return $this->hasOne(UserPersonalData::class);
     }

     /**
      * @return HasMany
      */

      public function certificates(): BelongsToMany
      {
          return $this->belongsToMany(Certificate::class);
      }

    /**
     * @return string
     */
    public function getCityNameAttribute(): string
    {
        if ($this->city_id === null) {
            return '';
        }

        return $this->translateField($this->city->title);
    }

    /**
     * @return string
     */
    public function getPhotoPathAttribute(): string
    {
        if ($this->photo === null) {
            return '';
        }

        return Storage::disk('public')->url($this->photo);
    }

    /**
     * @param int $userId
     * @param array $params
     * @return bool
     */
    public static function updateUser(int $userId, array $params): bool
    {
        $user = self::query()->findOrFail($userId);
        $user->fill($params);

        return $user->trySaveModel();
    }

    /**
     * @param array $params
     * @return static
     */
    public static function createUser(array $params): self
    {
        $params['password'] = Hash::make($params['password']);
        $params['personal_data_agreement_at'] = Carbon::now();
        //$params['birthday'] = Carbon::createFromFormat('Y-m-d', $params['birthday']);

        $params['birthday'] = date('Y-m-d', strtotime($params['birthday']));

        $user = new self($params);

        DB::beginTransaction();

        $user->trySaveModel();
        $user->setRole(RolesDictionary::ELECTRICIAN);

        DB::commit();

        return $user;
    }

    /**
     * @param string $role
     * @return bool|null
     */
    public function setRole(string $role): ?bool
    {
        /**
         * TODO
         * Если появяться еще роли, то надо в интеграции с SalesForce учесть с какими ролями пользователей
         * им отправлять
         */
        $userRole = config('roles.models.role')::where('slug', '=', $role)->firstOrFail();

        return $this->attachRole($userRole);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @param Builder $query
     * @param bool $published
     * @return Builder
     */
    public function scopePublished(Builder $query, bool $published = true): Builder
    {
        return $query->where([
            'published' => $published,
        ]);
    }

    /**
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public static function deleteUser(int $userId): bool
    {
        $user = self::query()->findOrFail($userId);

        return $user->delete();
    }

    /**
     * Юзеры у которых заявка на участие в программе лояльности не отменена
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActiveLoyalty(Builder $query): Builder
    {
        return $query->whereHas('loyaltyUsers', static function (Builder $builder) {
            return $builder->where('loyalty_users.status', '!=',  LoyaltyUserStatuses::CANCELED);
        });
    }

    /**
     * @param  Builder  $query
     * @param  bool  $showContacts
     * @return Builder
     */
    public function scopePublishedContacts(Builder $query, bool $showContacts = true): Builder
    {
        return $query->where([
            'show_contacts' => $showContacts,
        ]);
    }

    /**
     * @param  Builder  $query
     * @param  bool  $publishBan
     * @return Builder
     */
    public function scopePublishBan(Builder $query, bool $publishBan = false): Builder
    {
        return $query->where([
            'publish_ban' => $publishBan,
        ]);
    }
}
