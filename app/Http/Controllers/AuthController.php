<?
namespace App\Http\Controllers;

use App\Contracts\Interface\AuthInterface;
use App\Helpers\PaginateHelper;
use App\Helpers\ResponseHelper;
use App\Http\Handlers\UserHandler;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\UpdateForgotPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\UserCreateResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourcePaginate;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authHandler;
    protected $authInterface;
    protected $authService;

    public function __construct(UserHandler $authHandler, AuthInterface $authInterface, AuthService $authService)
    {
        $this->authHandler = $authHandler;
        $this->authInterface = $authInterface;
        $this->authService = $authService;
    }
    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authHandler->login($request->validated());
            return ResponseHelper::success(
                new UserResource($user),
                __('auth.login_success'),
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                __('auth.login_error'),
                $th->getMessage(),
                400
            );
        }
    }
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $user = $this->authService->forgotPassword($request->validated()['email']);
            return ResponseHelper::success(
                $user,
                __('auth.forgot_password_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                __('auth.forgot_password_error'),
                $th->getMessage(),
                400
            );
        }
    }

    public function updateForgotPassword(UpdateForgotPasswordRequest $request)
    {
        try {
            $user = $this->authHandler->updateForgotPassword($request->validated());
            return ResponseHelper::success(
                $user,
                __('auth.update_password_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                __('auth.update_password_error'),
                $th->getMessage(),
                400
            );
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->authHandler->updatePassword($data);
            return ResponseHelper::success(
                $user,
                __('auth.update_password_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                __('auth.update_password_error'),
                $th->getMessage(),
                400
            );
        }
    }

    public function logout()
    {
        try {
            $this->authInterface->logout();
            return ResponseHelper::success(
                null,
                __('auth.logout_success')
            );
        } catch (\Throwable $th) {
            return ResponseHelper::error(
                __('auth.logout_error'),
                $th->getMessage(),
                400
            );
        }
    }
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only([
                'search',
                'sort_by',
                'sort_dir',
                'date_from',
                'date_to',
                'per_page'
            ]);

            $users = $this->authInterface->getAll($filters);
            $paginate = PaginateHelper::getPaginate($users);
            $resourceCollection = new UserResourcePaginate($users, $paginate);

            return ResponseHelper::success(
                $resourceCollection,
                __('alert.data_found'),
                Response::HTTP_OK,
                true
            );
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.fetch_data_failed'), $e->getMessage(), 400);
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $this->authHandler->storeCustomer($data);

            return ResponseHelper::success(
                new UserCreateResource($user),
                __('alert.add_success'),
                Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.add_failed'), $e->getMessage(), 400);
        }
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = $this->authHandler->updateCustomer($id, $data);

            return ResponseHelper::success(
                new UserResource($user),
                __('alert.update_success')
            );
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error(__('alert.data_not_found'), 404);
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.update_failed'), $e->getMessage(), 400);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->authInterface->delete($id);
            return ResponseHelper::success(null, __('alert.delete_success'));
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error(__('alert.data_not_found'), 404);
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.delete_failed'), $e->getMessage(), 400);
        }
    }
    public function restore(string $id): JsonResponse
    {
        try {
            $this->authInterface->restore($id);
            return ResponseHelper::success(null, __('alert.user_restore_success'));
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error(__('alert.data_not_found'), 404);
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.user_restore_failed'), $e->getMessage(), 400);
        }
    }


    public function forceDelete(string $id): JsonResponse
    {
        try {
            $this->authInterface->forceDelete($id);
            return ResponseHelper::success(null, __('alert.delete_success'));
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error(__('alert.data_not_found'), 404);
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.delete_failed'), $e->getMessage(), 400);
        }
    }


    public function trash(Request $request): JsonResponse
    {
        try {
            $filters = $request->only([
                'search',
                'sort',
                'detail',
                'created_from',
                'published_from',
                'per_page',
                'stock_min',
                'stock_max'
            ]);

            $perPage = (int) ($filters['per_page'] ?? 15);
            $users = $this->authInterface->trash($filters);
            $paginate = PaginateHelper::getPaginate($users);
            $resourceCollection = new UserResourcePaginate($users, $paginate);

            return ResponseHelper::success($resourceCollection, __('alert.data_found'));
        } catch (\Throwable $e) {
            return ResponseHelper::error(__('alert.fetch_data_failed'), $e->getMessage(), 400);
        }
    }

}