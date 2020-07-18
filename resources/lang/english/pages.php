<?php

return [
    'admin_login' => [
        "app_name1" => "RealTime",
        "app_name2" => "TMS",
        "lang_en" => "English",
        "lang_ja" => "Japanese",
        "title" => "EMR System Reservations",
        "welcome" => "Welcome",
        "fields" => [
            "email" => "Email",
            "password" => "Password",
        ],
        'forgot_password' => "Forgot Password",
        'btn_login' => "Login",
        'errors' => [
            "email" => [
                "mes1" => "Email don't empty",
                "mes2" => "Email invalid"
            ],
            "password" => [
                "mes1" => "Password don't empty",
                "mes2" => "Your password must contain at least one uppercase, lowercase, special character, must be between 8 and 16 characters"
            ],
            "error_all" => "Pls, check all field red",
            'error_require' => "Pls, check all required field",
            "error_all_server" => "These credentials do not match our records.",
        ]
    ],
    'admin_index' => [
        'roles' => "Roles",
        'clinics' => "Clinics",
        'users' => "Admin Users​"
    ],
    'clinic_index' => [
        'calendar' => "Calendar",
        'notices' => "Notices",
        'patients' => "Patients",
        'appointments' => "Appointments",
    ],
    'clinic_setting' => [
        'physicians' => "Physicians",
        'departments' => "Departments",
        'treatments' => "Treatments",
        'zipcodes' => "Zipcodes",
        'users' => 'Users',
        'clinic_setting' => "Clinic Setting",
        'edit_clinic' => "Edit Clinic",
        'clinic_info' => [
            'clinic_info' => "Clinic Infomation",
            'setting_reservable' => 'Reservation Setting',
            'fields' => [
                'clinic_name' => 'Clinic Name',
                'clinic_code' => 'Clinic Code',
                'reservation' => 'Reservation URL for Patient',
                'representative' => 'Representative',
                'postal_code' => 'Postalcode',
                'phone' => 'Phone',
                'address' => 'Address',
                'fax_number' => 'Fax Number',
                'email' => 'Email',
                'description' => 'Description'
            ]
        ],
        'edit' => "Edit"
    ],
    'patient_login' => [
        "title" => "EMR Reserve System",
        "welcome" => "Welcome",
        "fields" => [
            "patient_id" => "Patient ID",
            "birthday" => "Birthday",
        ],
        'forgot_birthday' => "Forgot Password",
        'btn_login' => "Login",
        'errors' => [
            "patient_id" => [
                "mes1" => "Patient ID invalid"
            ],
            "birthday" => [
                "mes2" => "Birthday invalid"
            ],
            "error_all" => "Pls, check all field red",
            'error_require' => "Pls, check all required field",
            "error_all_server" => "These credentials do not match our records.",
        ]
    ],
    'patient_index' => [
        'calendar' => "Calendar",
        "notices" => "Notices"
    ],
    'reset_password' => [
        "modal_title" => "Reset Password",
        "field_email" => "Mail Address",
        "mes_des" => "Please enter a registered email address",
        "mess_error_email" => [
            "mes1" => "Email invalid"
        ],
        "btn" => [
            "close" => "Close",
            "send" => "Send"
        ],
        "mess_error" => [
            "exception_system" => "Exception system, don't send mail"
        ],
        "mess_success" => "Reset password successs, check again info in email"
    ]
];
