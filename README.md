<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Borang Permohonan & Senarai Permohonan (Developer Guide)

This branch implements the **Borang Permohonan** (Application Form) and **Senarai Permohonan** (Application List) features for the eLesen2 system.

---

## 1. Borang Permohonan (Application Form)

### **Purpose**
Allows users (pelesen/applicants) to submit new applications for license amendments or new licenses.

### **Main Files & Functions**
- `resources/views/appeals/create.blade.php` — Application form UI (Blade template)
- `app/Http/Controllers/AppealController.php`
  - `create()` — Show the form
  - `store(Request $request)` — Handle form submission and validation
- `app/Models/Appeal.php` — Eloquent model for appeals

### **Key Routes** (see `routes/web.php`)
- `GET /appeals/create` → `AppealController@create` (show form)
- `POST /appeals/store` → `AppealController@store` (submit form)

### **Key Database Fields** (`appeals` table)
- `id` (UUID)
- `applicant_id` (user ID)
- `status` (e.g., submitted, ppl_review, kcl_review, pk_review, approved, rejected)
- `ppl_status`, `kcl_status`, `pk_status` (stage-specific status)
- `ppl_comments`, `kcl_comments`, `pk_comments` (stage-specific comments)

### **How to Add New Fields**
1. Add the field to the `appeals` table (migration).
2. Add the field to `$fillable` in `Appeal.php`.
3. Update the form in `create.blade.php`.
4. Update validation and saving logic in `AppealController@store`.

### **Debugging Tips**
- If form data is not saving, check validation rules in the controller.
- Use `dd($request->all())` or `
Log::info()` for debugging form submissions.
- Check for missing fields in `$fillable` in the model.
- If redirect fails, check route names in `routes/web.php`.

---

## 2. Senarai Permohonan (Application List)

### **Purpose**
Displays a list of all applications, with filtering and action buttons for review, print, and status.

### **Main Files & Functions**
- `resources/views/appeals/list_for_amendment.blade.php` — List UI (responsive table)
- `app/Http/Controllers/AppealController.php`
  - `listApplicationsForAmendment()` — Fetch and display applications
- `app/Models/Appeal.php` — Eloquent model for appeals

### **Key Route**
- `GET /appeals/amendment` → `AppealController@listApplicationsForAmendment`

### **How the List Works**
- If the user is a "pelesen", only their own applications are shown (see role logic in controller).
- For other roles, all applications are listed.
- Table columns and action buttons are defined in the Blade file.
- Status badges and available actions depend on the application's current status and user role.

### **How to Add/Change Table Columns**
- Edit `list_for_amendment.blade.php` to add/remove columns.
- Update the query in `listApplicationsForAmendment()` if you need more data.

### **Debugging Tips**
- If the list is empty, check the query in the controller and database contents.
- If actions (edit, print, etc.) are missing, check the status logic in the Blade file.
- Use `@dd($applications)` in the Blade file to inspect data.

---

## 3. Status & Workflow Logic

### **Status Field Values**
- `submitted` — New application
- `ppl_review`, `ppl_incomplete` — PPL review stage
- `kcl_review`, `kcl_incomplete` — KCL review stage
- `pk_review`, `pk_incomplete` — PK review stage
- `approved`, `rejected` — Final decision

### **How Status Changes**
- Each review stage (PPL, KCL, PK) has its own submit method in `AppealController` (e.g., `pplSubmit`, `kclSubmit`, `pkSubmit`).
- The status is updated based on reviewer input (e.g., "Lengkap", "Disokong", "Diluluskan").
- After each stage, the status moves to the next reviewer or to final decision.

### **Tracing Status Changes**
- Check the relevant submit method in the controller for logic.
- Use logs or add `
Log::info('Status changed to: ' . $appeal->status);` after saving.

---

## 4. Role-Based Logic

- User roles are stored in the `peranan` field of the `users` table.
- The controller uses `strtolower($user->peranan)` and checks for keywords (e.g., "pelesen", "pegawai perikanan", "ketua cawangan", "pengarah kanan").
- Redirection and access to review pages are based on role (see `redirectToRoleReview` in `AppealController`).
- Action buttons in the list view are also role/status dependent.

---

## 5. Common Issues & Solutions

- **RouteNotFoundException**: Check route names and group prefixes in `routes/web.php`.
- **Fields not saving**: Ensure fields are in `$fillable` and present in the form and controller.
- **Role-based access not working**: Check normalization and matching logic for `peranan` in the controller.
- **UI not updating**: Clear cache with `php artisan view:clear` and `php artisan cache:clear`.

---

## 6. Customization & Extension

- To add new review stages, replicate the pattern in the controller and Blade files.
- To add new fields, update the migration, model, form, and controller.
- For new roles, update the role-checking logic in the controller.

---

## 7. Contact & Help

- For further details, see code comments in the controller and Blade files.
- If you encounter issues, use Laravel logs (`storage/logs/laravel.log`) and debug helpers (`dd()`, `dump()`, `Log::info()`).
- For questions, contact the original developer or project maintainer.

---

**Happy coding!**
