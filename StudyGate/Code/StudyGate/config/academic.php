<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Academic Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the academic settings for the university system.
    |
    */

    'unit_limits' => [
        'min_units_per_semester' => 12,
        'max_units_per_semester' => 18,
        'max_units_per_year' => 36,
    ],

    'grading' => [
        'passing_grade' => 60,
        'max_grade' => 100,
    ],

    'enrollment' => [
        'drop_deadline_days' => 60, // زيادة من 30 إلى 60 يوم لإسقاط المواد
        'add_deadline_days' => 14,  // عدد الأيام المسموح بها لإضافة المواد
    ],

    'prerequisites' => [
        'enforce_prerequisites' => true,
        'minimum_grade_for_prerequisite' => 60,
    ],
]; 