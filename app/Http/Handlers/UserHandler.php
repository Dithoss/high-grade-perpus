<?php

namespace App\Http\Handlers;

use App\Contracts\Interface\ActivityLogInterface;
use App\Contracts\Interface\AuthInterface;
use App\Helpers\UploadHelper;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\UserResource;
use App\Models\ActivityLog;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserHandler
{
    protected $authInterface;
    protected $activityLogInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function login(array $data)
    {
        $user = $this->authInterface->login($data);
        if (
            !$user ||
            !Hash::check($data['password'], $user->password)
        ) {
            throw new \Exception('Email atau password anda salah.');
        }
        $token = $user->createToken('token')->plainTextToken;
        $user->token = $token;
        return $user;
    }



    public function updateForgotPassword(array $data)
    {
        $result = $this->authInterface->updateForgotPassword($data);
        $user = $result['user'];
        $token = $result['token'];

        if (! $user) {
            throw new \Exception('Email tidak ditemukan');
        }

        if (! $token) {
            throw new \Exception('Token tidak valid atau sudah digunakan');
        }

        DB::beginTransaction();
        try {
            $user->password = Hash::make($data['password']);
            $user->save();

            PasswordResetToken::where('email', $data['email'])
                ->where('token', $data['token'])
                ->delete();

            $this->activityLogInterface->log([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'target_id' => $user->id, 
                'action' => 'update_password',
                'description' => 'User mengganti password melalui fitur lupa password.',
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Terjadi kesalahan, silakan coba lagi');
        }
    }

    public function updatePassword(array $data)
    {
        $user = auth()->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            throw new \Exception('Password lama salah.');
        }

        if ($data['new_password'] !== $data['new_password_confirmation']) {
            throw new \Exception('Konfirmasi password baru tidak sama.');
        }

        DB::beginTransaction();
        try {
            $user->password = Hash::make($data['new_password']);
            $user->save();

            $this->activityLogInterface->log([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'target_id' => $user->id,
                'action' => 'update_password',
                'description' => 'User mengganti password melalui fitur update password.',
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception('Terjadi kesalahan, silakan coba lagi');
        }
    }

    public function storeCustomer(array $data)
    {
        if (isset($data['image']) && $data['image']) {
            $imagePath = UploadHelper::uploadImage($data['image'], 'profile_images');
            $data['image'] = $imagePath;
        }

        $user = $this->authInterface->store($data);

        $user->assignRole('customer');

        return $user;
    }

    public function updateCustomer(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->authInterface->findById($id);

            if (isset($data['image']) && $data['image']) {
                if ($user->image) {
                    UploadHelper::deleteFile($user->image);
                }
                $imagePath = UploadHelper::uploadImage($data['image'], 'profile_images');
                $data['image'] = $imagePath;
            }

            $updatedUser = $this->authInterface->update($id, $data);

            $this->activityLogInterface->log([
                'id' => Str::uuid(),
                'user_id' => auth()->id(), 
                'target_id' => $user->id, 
                'action' => 'update_customer',
                'description' => 'Admin ' . auth()->user()->name . ' mengupdate data customer ' . $user->name,
            ]);

            DB::commit();
            return $updatedUser;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }



}
