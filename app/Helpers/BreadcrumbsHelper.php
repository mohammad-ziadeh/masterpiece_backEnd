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
        } elseif ($routeName === 'tables') {
            $breadcrumbs[] = ['label' => 'Dashboard', 'url' => route('dashboard')];
            $breadcrumbs[] = ['label'=> 'Tables','url'=> route('tables')];
        } elseif ($routeName === 'users.index') {
            $breadcrumbs[] = ['label' => 'Dashboard', 'url' => route('dashboard')];
            $breadcrumbs[] = ['label'=> 'Tables','url'=> route('tables')];
            $breadcrumbs[] = ['label'=> 'Users','url'=> route('users.index')];
        }elseif ($routeName === 'tasks.index') {
            $breadcrumbs[] = ['label' => 'Dashboard', 'url' => route('dashboard')];
            $breadcrumbs[] = ['label'=> 'Tables','url'=> route('tables')];
            $breadcrumbs[] = ['label'=> 'Tasks','url'=> route('tasks.index')];
        }elseif ($routeName === 'attendance.index') {
            $breadcrumbs[] = ['label' => 'Dashboard', 'url' => route('dashboard')];
            $breadcrumbs[] = ['label'=> 'Tables','url'=> route('tables')];
            $breadcrumbs[] = ['label'=> 'Attendance','url'=> route('attendance.index')];
        }

        return $breadcrumbs;
    }
}
