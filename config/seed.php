<?php

use App\Models\Permission;

return [
    'permissions' => [
        [
            'module_name' => 'business_setting',
            'display_name' => 'View Business Settings',
            'guard_name' => 'api',
            'name' => Permission::BUSINESS_SETTING_VIEW
        ],
        [
            'module_name' => 'business_setting',
            'display_name' => 'Add Business Settings',
            'guard_name' => 'api',
            'name' => Permission::BUSINESS_SETTING_WRITE
        ],
        [
            'module_name' => 'business_setting',
            'display_name' => 'Edit Business Settings',
            'guard_name' => 'api',
            'name' => Permission::BUSINESS_SETTING_EDIT
        ],
        [
            'module_name' => 'business_setting',
            'display_name' => 'Delete Business Settings',
            'guard_name' => 'api',
            'name' => Permission::BUSINESS_SETTING_DELETE
        ],
        [
            'module_name' => 'employee',
            'display_name' => 'View Employee List',
            'guard_name' => 'api',
            'name' => Permission::EMPLOYEE_LIST
        ],
        [
            'module_name' => 'employee',
            'display_name' => 'Add Employee',
            'guard_name' => 'api',
            'name' => Permission::EMPLOYEE_WRITE
        ],
        [
            'module_name' => 'employee',
            'display_name' => 'Edit Employee',
            'guard_name' => 'api',
            'name' => Permission::EMPLOYEE_EDIT
        ],
        [
            'module_name' => 'employee',
            'display_name' => 'Delete Employee',
            'guard_name' => 'api',
            'name' => Permission::EMPLOYEE_DELETE
        ],
        [
            'module_name' => 'task',
            'display_name' => 'View Task List',
            'guard_name' => 'api',
            'name' => Permission::TASK_LIST
        ],
        [
            'module_name' => 'task',
            'display_name' => 'Add Task',
            'guard_name' => 'api',
            'name' => Permission::TASK_WRITE
        ],
        [
            'module_name' => 'task',
            'display_name' => 'Edit Task',
            'guard_name' => 'api',
            'name' => Permission::TASK_EDIT
        ],
        [
            'module_name' => 'task',
            'display_name' => 'Delete Task',
            'guard_name' => 'api',
            'name' => Permission::TASK_DELETE
        ],
        [
            'module_name' => 'task',
            'display_name' => 'Show Only Assigned Task',
            'guard_name' => 'api',
            'name' => Permission::TASK_SHOW_ONLY_ASSIGNED
        ],
        [
            'module_name' => 'expense',
            'display_name' => 'View Expense List',
            'guard_name' => 'api',
            'name' => Permission::EXPENSES_LIST
        ],
        [
            'module_name' => 'expense',
            'display_name' => 'Add Expense',
            'guard_name' => 'api',
            'name' => Permission::EXPENSES_WRITE
        ],
        [
            'module_name' => 'expense',
            'display_name' => 'Edit Expense',
            'guard_name' => 'api',
            'name' => Permission::EXPENSES_EDIT
        ],
        [
            'module_name' => 'expense',
            'display_name' => 'Delete Expense',
            'guard_name' => 'api',
            'name' => Permission::EXPENSES_DELETE
        ],
        [
            'module_name' => 'quick_reply',
            'display_name' => 'View Quick Reply List',
            'guard_name' => 'api',
            'name' => Permission::QUICK_REPLY_LIST
        ],
        [
            'module_name' => 'quick_reply',
            'display_name' => 'Add Quick Reply',
            'guard_name' => 'api',
            'name' => Permission::QUICK_REPLY_WRITE
        ],
        [
            'module_name' => 'quick_reply',
            'display_name' => 'Edit Quick Reply',
            'guard_name' => 'api',
            'name' => Permission::QUICK_REPLY_EDIT
        ],
        [
            'module_name' => 'quick_reply',
            'display_name' => 'Delete Quick Reply',
            'guard_name' => 'api',
            'name' => Permission::QUICK_REPLY_DELETE
        ],
        [
            'module_name' => 'expense_category',
            'display_name' => 'View Expense Category List',
            'guard_name' => 'api',
            'name' => Permission::EXPENSE_CATEGORY_LIST
        ],
        [
            'module_name' => 'expense_category',
            'display_name' => 'Add/Edit Expense Category',
            'guard_name' => 'api',
            'name' => Permission::EXPENSE_CATEGORY_WRITE
        ],
        [
            'module_name' => 'expense_category',
            'display_name' => 'Delete Expense Category',
            'guard_name' => 'api',
            'name' => Permission::EXPENSE_CATEGORY_DELETE
        ],
    ],
];
