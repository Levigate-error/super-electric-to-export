<?php

namespace App\Services\User;

use App\Domain\Dictionaries\Users\RolesDictionary;
use App\Exceptions\CanNotSaveException;
use App\Exceptions\NotFoundException;
use App\Exceptions\CanNotDeleteException;
use App\Http\Resources\UserResource;
use App\Services\BaseService;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Domain\Repositories\User\UserRepositoryContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Validators\User\UserCompletenessValidator;
use App\Validators\BaseValidator;
use App\Http\Resources\User\ElectricianResource;
use App\Models\Image;
use App\Models\UserPersonalData;
//use App\Traits\ImagePrepare;
use Carbon\Carbon;

/**
 * Class UserService
 * @package App\Services\User
 */
class UserService extends BaseService implements UserServiceContract
{
//    use ImagePrepare;

    private const USER_PROFILE_DIR = 'user' . DIRECTORY_SEPARATOR;

    /**
     * @var UserRepositoryContract
     */
    private $repository;

    /**
     * UserService constructor.
     * @param UserRepositoryContract $repository
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return UserRepositoryContract
     */
    public function getRepository(): UserRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserProfile(int $userId): array
    {
        $user = $this->repository->getUser($userId);
        if ($user === null) {
            throw new NotFoundException();
        }

        return UserResource::make($user)->resolve();
    }

    /**
     * @param int $userId
     * @param array $params
     * @return bool
     */
    public function updateUserProfile(int $userId, array $params): bool
    {
        return $this->repository->getSource()::updateUser($userId, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function updateAndGetCurrentUserProfile(array $params): array
    {
        $userId = Auth::user()->getAuthIdentifier();

        if (!$this->updateUserProfile($userId, $params)) {
            throw new CanNotSaveException();
        }

        return $this->getUserProfile($userId);
    }

    /**
     * @param string $newPassword
     * @return array
     */
    public function updateCurrentUserPassword(string $newPassword): array
    {
        return $this->updateAndGetCurrentUserProfile([
            'password' => Hash::make($newPassword),
        ]);
    }

    /**
     * @param  UploadedFile  $file
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ImagickException
     */
    public function updateCurrentUserProfilePhoto(UploadedFile $file): array
    {
        $userId = Auth::user()->getAuthIdentifier();

        $photoPath = $this->generateUserProfilePhotoPath($file);
        Storage::disk('public')->put($photoPath, $file->get());

        $this->rotateImageToTopLeft($photoPath);

        if (!$this->updateUserProfile($userId, ['photo' => $photoPath])) {
            throw new CanNotSaveException();
        }

        return $this->getUserProfile($userId);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function generateUserProfilePhotoPath(UploadedFile $file): string
    {
        return static::USER_PROFILE_DIR . time() . '_' . $file->getBasename() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @param array $params
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function checkAndUpdateCurrentUserProfilePublished(array $params)
    {
        $userId = Auth::user()->getAuthIdentifier();

        return $this->checkAndUpdateUserProfilePublished($userId, $params);
    }

    /**
     * @param int $userId
     * @param array $params
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function checkAndUpdateUserProfilePublished(int $userId, array $params)
    {
        $user = $this->getUserProfile($userId);

        if ($user['publish_ban'] === true) {
            return response()->json([
                'errors' => trans('user.errors.publish_ban'),
            ], 422);
        }

        $checkErrors = $this->checkUserDataCompleteness($userId);
        if ($checkErrors->isNotEmpty() === true) {
            return response()->json($checkErrors->first(), 422);
        }

        if (!$this->updateUserProfile($userId, $params)) {
            throw new CanNotSaveException();
        }

        return $this->getUserProfile($userId);
    }

    /**
     * @param  int  $userId
     * @param  BaseValidator|null  $validator
     * @return Collection
     */
    public function checkUserDataCompleteness(int $userId, ?BaseValidator $validator = null): Collection
    {
        if ($validator === null) {
            $validator = new UserCompletenessValidator();
        }

        $user = $this->getUserProfile($userId);
        $errorsCollection = new Collection();

        $errors = $validator->validate($user);
        if (empty($errors) === false) {
            $errorsComments = collect($errors)->map(static function ($errorsArray) {
                return implode("\n", $errorsArray);
            })->implode("\n");

            $errorsCollection->push([
                'errors' => $errorsComments,
            ]);
        }

        return $errorsCollection;
    }

    /**
     * @return array
     */
    public function getPublishedElectrician(): array
    {
        $users = $this->repository->getUsersByParams([
            'role' => RolesDictionary::ELECTRICIAN,
            'published' => true,
            'publish_ban' => false,
            'active_loyalty' => true,
        ]);

        return ElectricianResource::collection($users->untype())->resolve();
    }

    /**
     * @return bool
     */
    public function deleteCurrentUser(): bool
    {
        $userId = Auth::user()->getAuthIdentifier();

        return $this->deleteUser($userId);
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool
    {
        $model = $this->repository->getSource();

        if ($model::deleteUser($userId) === false) {
            throw new CanNotDeleteException();
        }

        Auth::guard()->logout();

        return true;
    }

    public function storePersonalData(array $params) :void
    {
        $user = Auth::user();
        if ($user->personalData()->exists()) {
            abort(422, __('user.personal-data.already-uploaded'));
        }

        $params['issue_date'] = Carbon::createFromFormat('Y-m-d', $params['issue_date']);
        $photos = ['spread_photo', 'registration_photo', 'tax_certificate_photo'];
        $images = [];

        foreach ($photos as $key) {
            $images[] = $params[$key];
            unset($params[$key]);
        }

        $personalData = new UserPersonalData($params);
        $personalData->user()->associate(Auth::user());
        $personalData->save();

        $documents = [];

        foreach ($images as $image) {
            $path = $this->generateDocumentPath($image);
            Storage::disk('documents')->put($path, $image->get());

            $documents[] = new Image([
                'size' => $image->getSize(),
                'path' => $path
            ]);
        }

        $personalData->images()->saveMany($documents);
    }

    private function generateDocumentPath(UploadedFile $file): string
    {
        return 'document' . time() . '_' . $file->getBasename() . '.' . $file->getClientOriginalExtension();
    }
}
