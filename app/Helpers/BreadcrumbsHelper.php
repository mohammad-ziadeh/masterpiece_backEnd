<?php

namespace App\Helpers;

class BreadcrumbsHelper
{
    public static function generateBreadcrumbs($routeName)
    {
        $breadcrumbs = [];

        if ($routeName === 'dashboard') {
            $breadcrumbs[] = ['label' => 'Dashboard', 'url' => route('dashboard')];
        } elseif ($routeName === 'profile.edit') {
            $breadcrumbs[] = ['label' => 'Dashboard', 'url' => route('dashboard')];
            $breadcrumbs[] = ['label' => 'Profile', 'url' => route('profile.edit')];
        }

        return $breadcrumbs;
    }
}
