<?php

use App\Models\User;

if (!function_exists('getCurrentUserInfo')) {
    function getCurrentUserInfo()
    {
        $guards = [
            'isUserAdmin' => \App\Models\User::class,
            'isUserStaff' => \App\Models\UserStaff::class,
            'isUserHospital' => \App\Models\UserHospital::class,
            'isUserCustomer' => \App\Models\UserCustomer::class,
        ];

        foreach ($guards as $guard => $model) {
            if (auth()->guard($guard)->check()) {
                $user = auth()->guard($guard)->user();
                return getUserWithRelationships($model, $user->id, $guard);
            }
        }

        return null;
    }
}

if (!function_exists('getUserWithRelationships')) {
    function getUserWithRelationships($model, $userId, $guard)
    {
        $relationships = [
            'isUserAdmin' => 'employee',
            'isUserStaff' => 'customer',
            'isUserHospital' => 'hospital',
            'isUserCustomer' => 'customer',
        ];

        $relationship = $relationships[$guard] ?? null;

        return $relationship
            ? $model::with($relationship)->find($userId)
            : $model::find($userId);
    }
}
