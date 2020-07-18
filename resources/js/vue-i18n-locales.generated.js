export default {
    "english": {
        "api_google_maps": {
            "lable": {
                "to": "To",
                "from": "From"
            }
        },
        "auth": {
            "failed": "These credentials do not match our records.",
            "throttle": "Too many login attempts. Please try again in {seconds} seconds."
        },
        "global_config": {
            "status": {
                "not_pickup": "Not Pickup",
                "shipping": "Shipping",
                "delivered": "Delivered"
            }
        },
        "pages": {
            "admin_login": {
                "app_name1": "RealTime",
                "app_name2": "TMS",
                "lang_en": "English",
                "lang_ja": "Japanese",
                "title": "EMR System Reservations",
                "welcome": "Welcome",
                "fields": {
                    "email": "Email",
                    "password": "Password"
                },
                "forgot_password": "Forgot Password",
                "btn_login": "Login",
                "errors": {
                    "email": {
                        "mes1": "Email don't empty",
                        "mes2": "Email invalid"
                    },
                    "password": {
                        "mes1": "Password don't empty",
                        "mes2": "Your password must contain at least one uppercase, lowercase, special character, must be between 8 and 16 characters"
                    },
                    "error_all": "Pls, check all field red",
                    "error_require": "Pls, check all required field",
                    "error_all_server": "These credentials do not match our records."
                }
            },
            "admin_index": {
                "roles": "Roles",
                "clinics": "Clinics",
                "users": "Admin Users​"
            },
            "clinic_index": {
                "calendar": "Calendar",
                "notices": "Notices",
                "patients": "Patients",
                "appointments": "Appointments"
            },
            "clinic_setting": {
                "physicians": "Physicians",
                "departments": "Departments",
                "treatments": "Treatments",
                "zipcodes": "Zipcodes",
                "users": "Users",
                "clinic_setting": "Clinic Setting",
                "edit_clinic": "Edit Clinic",
                "clinic_info": {
                    "clinic_info": "Clinic Infomation",
                    "setting_reservable": "Reservation Setting",
                    "fields": {
                        "clinic_name": "Clinic Name",
                        "clinic_code": "Clinic Code",
                        "reservation": "Reservation URL for Patient",
                        "representative": "Representative",
                        "postal_code": "Postalcode",
                        "phone": "Phone",
                        "address": "Address",
                        "fax_number": "Fax Number",
                        "email": "Email",
                        "description": "Description"
                    }
                },
                "edit": "Edit"
            },
            "patient_login": {
                "title": "EMR Reserve System",
                "welcome": "Welcome",
                "fields": {
                    "patient_id": "Patient ID",
                    "birthday": "Birthday"
                },
                "forgot_birthday": "Forgot Password",
                "btn_login": "Login",
                "errors": {
                    "patient_id": {
                        "mes1": "Patient ID invalid"
                    },
                    "birthday": {
                        "mes2": "Birthday invalid"
                    },
                    "error_all": "Pls, check all field red",
                    "error_require": "Pls, check all required field",
                    "error_all_server": "These credentials do not match our records."
                }
            },
            "patient_index": {
                "calendar": "Calendar",
                "notices": "Notices"
            },
            "reset_password": {
                "modal_title": "Reset Password",
                "field_email": "Mail Address",
                "mes_des": "Please enter a registered email address",
                "mess_error_email": {
                    "mes1": "Email invalid"
                },
                "btn": {
                    "close": "Close",
                    "send": "Send"
                },
                "mess_error": {
                    "exception_system": "Exception system, don't send mail"
                },
                "mess_success": "Reset password successs, check again info in email"
            }
        },
        "pagination": {
            "previous": "&laquo; Previous",
            "next": "Next &raquo;"
        },
        "passwords": {
            "reset": "Your password has been reset!",
            "sent": "We have emailed your password reset link!",
            "throttled": "Please wait before retrying.",
            "token": "This password reset token is invalid.",
            "user": "We can't find a user with that email address."
        },
        "products": {
            "modal_title": {
                "new": "New",
                "edit": "Edit",
                "view": "View"
            },
            "fields": {
                "name": "Name",
                "code": "Code",
                "address": "Address",
                "description": "Description"
            },
            "errors": {
                "name": {
                    "min": "Name must have > 1 character",
                    "max": "Name must have < 15 characters",
                    "invalid": "Name invalid !"
                },
                "code": {
                    "min": "Code must have > 1 character",
                    "max": "Code must have < 15 characters",
                    "invalid": "Code invalid !"
                },
                "error_all": "Check red fields !",
                "required": "Check required fields !"
            },
            "modal_delete": {
                "content": "Confirm that, record will delete",
                "title": "Do you want to delete?",
                "btn_ok": "Yes",
                "btn_no": "No"
            }
        },
        "users": {
            "combo_box": {
                "keySearch": "KeySearch"
            },
            "btn": {
                "new": "New",
                "btn_search": "Search",
                "limit": "Limit"
            },
            "fields": {
                "id": "ID",
                "name": "Name",
                "email": "Email",
                "user_name": "User Name"
            },
            "filter": {
                "all": "All"
            }
        },
        "validation": {
            "accepted": "The {attribute} must be accepted.",
            "active_url": "The {attribute} is not a valid URL.",
            "after": "The {attribute} must be a date after {date}.",
            "after_or_equal": "The {attribute} must be a date after or equal to {date}.",
            "alpha": "The {attribute} may only contain letters.",
            "alpha_dash": "The {attribute} may only contain letters, numbers, dashes and underscores.",
            "alpha_num": "The {attribute} may only contain letters and numbers.",
            "array": "The {attribute} must be an array.",
            "before": "The {attribute} must be a date before {date}.",
            "before_or_equal": "The {attribute} must be a date before or equal to {date}.",
            "between": {
                "numeric": "The {attribute} must be between {min} and {max}.",
                "file": "The {attribute} must be between {min} and {max} kilobytes.",
                "string": "The {attribute} must be between {min} and {max} characters.",
                "array": "The {attribute} must have between {min} and {max} items."
            },
            "boolean": "The {attribute} field must be true or false.",
            "confirmed": "The {attribute} confirmation does not match.",
            "date": "The {attribute} is not a valid date.",
            "date_equals": "The {attribute} must be a date equal to {date}.",
            "date_format": "The {attribute} does not match the format {format}.",
            "different": "The {attribute} and {other} must be different.",
            "digits": "The {attribute} must be {digits} digits.",
            "digits_between": "The {attribute} must be between {min} and {max} digits.",
            "dimensions": "The {attribute} has invalid image dimensions.",
            "distinct": "The {attribute} field has a duplicate value.",
            "email": "The {attribute} must be a valid email address.",
            "ends_with": "The {attribute} must end with one of the following: {values}.",
            "exists": "The selected {attribute} is invalid.",
            "file": "The {attribute} must be a file.",
            "filled": "The {attribute} field must have a value.",
            "gt": {
                "numeric": "The {attribute} must be greater than {value}.",
                "file": "The {attribute} must be greater than {value} kilobytes.",
                "string": "The {attribute} must be greater than {value} characters.",
                "array": "The {attribute} must have more than {value} items."
            },
            "gte": {
                "numeric": "The {attribute} must be greater than or equal {value}.",
                "file": "The {attribute} must be greater than or equal {value} kilobytes.",
                "string": "The {attribute} must be greater than or equal {value} characters.",
                "array": "The {attribute} must have {value} items or more."
            },
            "image": "The {attribute} must be an image.",
            "in": "The selected {attribute} is invalid.",
            "in_array": "The {attribute} field does not exist in {other}.",
            "integer": "The {attribute} must be an integer.",
            "ip": "The {attribute} must be a valid IP address.",
            "ipv4": "The {attribute} must be a valid IPv4 address.",
            "ipv6": "The {attribute} must be a valid IPv6 address.",
            "json": "The {attribute} must be a valid JSON string.",
            "lt": {
                "numeric": "The {attribute} must be less than {value}.",
                "file": "The {attribute} must be less than {value} kilobytes.",
                "string": "The {attribute} must be less than {value} characters.",
                "array": "The {attribute} must have less than {value} items."
            },
            "lte": {
                "numeric": "The {attribute} must be less than or equal {value}.",
                "file": "The {attribute} must be less than or equal {value} kilobytes.",
                "string": "The {attribute} must be less than or equal {value} characters.",
                "array": "The {attribute} must not have more than {value} items."
            },
            "max": {
                "numeric": "The {attribute} may not be greater than {max}.",
                "file": "The {attribute} may not be greater than {max} kilobytes.",
                "string": "The {attribute} may not be greater than {max} characters.",
                "array": "The {attribute} may not have more than {max} items."
            },
            "mimes": "The {attribute} must be a file of type: {values}.",
            "mimetypes": "The {attribute} must be a file of type: {values}.",
            "min": {
                "numeric": "The {attribute} must be at least {min}.",
                "file": "The {attribute} must be at least {min} kilobytes.",
                "string": "The {attribute} must be at least {min} characters.",
                "array": "The {attribute} must have at least {min} items."
            },
            "not_in": "The selected {attribute} is invalid.",
            "not_regex": "The {attribute} format is invalid.",
            "numeric": "The {attribute} must be a number.",
            "password": "The password is incorrect.",
            "present": "The {attribute} field must be present.",
            "regex": "The {attribute} format is invalid.",
            "required": "The {attribute} field is required.",
            "required_if": "The {attribute} field is required when {other} is {value}.",
            "required_unless": "The {attribute} field is required unless {other} is in {values}.",
            "required_with": "The {attribute} field is required when {values} is present.",
            "required_with_all": "The {attribute} field is required when {values} are present.",
            "required_without": "The {attribute} field is required when {values} is not present.",
            "required_without_all": "The {attribute} field is required when none of {values} are present.",
            "same": "The {attribute} and {other} must match.",
            "size": {
                "numeric": "The {attribute} must be {size}.",
                "file": "The {attribute} must be {size} kilobytes.",
                "string": "The {attribute} must be {size} characters.",
                "array": "The {attribute} must contain {size} items."
            },
            "starts_with": "The {attribute} must start with one of the following: {values}.",
            "string": "The {attribute} must be a string.",
            "timezone": "The {attribute} must be a valid zone.",
            "unique": "The {attribute} has already been taken.",
            "uploaded": "The {attribute} failed to upload.",
            "url": "The {attribute} format is invalid.",
            "uuid": "The {attribute} must be a valid UUID.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": []
        }
    },
    "vietnamese": []
}
