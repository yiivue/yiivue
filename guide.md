# YiiVue API + Gii Guide

This guide is for this project's setup: Yii2 Advanced Template on the backend and Vue 3 on the frontend.

The short version is:

- `SpaController` is only the bridge that loads the Vue app.
- Vue handles page navigation.
- Yii handles API routes and database logic.
- Your real CRUD endpoints should live in separate API controllers, not inside `SpaController`.
- Gii is still useful, but mostly for generating models and forms of structure, not for classic Yii view-based CRUD.

## 1. Understand How This Project Works

This project uses a decoupled structure:

- Vue pages live in `frontend/resources/js`
- The Vue app is served once by `frontend/controllers/SpaController.php`
- API endpoints are handled by Yii controllers
- Database models should live in `common/models`

That means:

- `/login`, `/dashboard`, `/users/12` can be Vue routes
- `/api/users`, `/api/users/12` should be Yii API routes

Do not mix them up.

## 2. What `SpaController` Is For

File:

- `frontend/controllers/SpaController.php`

Use it only to render the Vue entry page.

Do not put your business CRUD logic there.

Good:

- use `SpaController` to return the Vue shell

Bad:

- use `SpaController` for `create user`, `update post`, `delete product`, etc.

## 3. Where To Put Things In This Project

Use this structure:

- Database table logic: `common/models`
- API controllers: `frontend/controllers/api`
- Vue pages: `frontend/resources/js/pages`
- Vue router config: `frontend/resources/js/router.js`
- API route rules: `frontend/config/main.php`

Recommended pattern:

- Model name: `common/models/User.php`
- API controller: `frontend/controllers/api/UserController.php`
- API base URL: `/api/users`

## 4. REST Pattern You Should Use

For standard CRUD APIs, use:

- `yii\rest\ActiveController`

For custom actions like login, register, report exports, dashboards, or special workflows, use:

- `yii\rest\Controller`

In this repo, `frontend/controllers/AuthController.php` is already a good example of a custom REST controller.

## 5. What To Use In Gii

Gii is still helpful, but you should use the right generator for the right job.

### Best use of Gii here

Use:

- `Model Generator`

Sometimes use:

- `CRUD Generator` only if you want an admin-side Yii rendered interface
- `Controller Generator` only if you want a basic starting PHP controller and you are comfortable editing it after generation

Usually avoid for the Vue SPA API flow:

- classic `CRUD Generator` for frontend app pages

Why avoid classic CRUD here:

- it generates Yii server-rendered views like `index.php`, `create.php`, `update.php`
- your project is Vue-driven, so those PHP views are usually not what you want
- your frontend pages should be Vue components, not Yii CRUD view templates

## 6. What To Type In Gii

### A. When creating a model from a table

Use `Model Generator`.

Recommended values:

- Table Name: your DB table, for example `user`, `post`, `product`
- Model Class: for example `User`, `Post`, `Product`
- Namespace: `common\models`
- Base Class: `yii\db\ActiveRecord`
- Generate Relations: `Yes`
- Generate Labels from DB Comments: `Yes` if your DB comments are clean

Example:

- Table Name: `post`
- Model Class: `Post`
- Namespace: `common\models`

After generation, review the model and add:

- validation rules
- scenarios if needed
- attribute labels
- helper methods
- business logic

Do not assume the generated model is already production-ready.

### B. When creating a controller with Gii

If you still want a generated starting controller, use `Controller Generator`.

Recommended values:

- Controller Class Name: `PostController`
- Namespace: `frontend\controllers\api`
- Base Class: `yii\rest\ActiveController` or `yii\rest\Controller`
- Actions: leave blank or generate minimal actions depending on your setup

Important:

Gii controller templates are often more aligned with regular Yii controllers than REST controllers, depending on your setup and installed templates. Because of that, many teams create API controllers manually instead of relying on Gii for this part.

For this project, manually creating REST controllers is usually cleaner and faster.

## 7. The Best Workflow For This Project

For each new resource like `posts`, `products`, `categories`, `customers`, use this order:

1. Create the table with a migration
2. Generate the model in `common/models` using Gii
3. Review and clean the generated model
4. Create an API controller in `frontend/controllers/api`
5. Register the controller in `frontend/config/main.php`
6. Call the API from Vue using `/api/...`
7. Create Vue pages/components for the UI

That is the clean MVC-friendly flow in this project.

## 8. Example: Creating a `Post` Module

### Step 1. Create the table

Create a migration for a `post` table.

Example columns:

- `id`
- `title`
- `content`
- `status`
- `created_at`
- `updated_at`

### Step 2. Generate model with Gii

Use:

- Table Name: `post`
- Model Class: `Post`
- Namespace: `common\models`

This gives you:

- `common/models/Post.php`

### Step 3. Create the API controller manually

Create:

- `frontend/controllers/api/PostController.php`

Example:

```php
<?php

namespace frontend\controllers\api;

use common\models\Post;
use yii\rest\ActiveController;

class PostController extends ActiveController
{
    public $modelClass = Post::class;
}
```

### Step 4. Register the API route

In `frontend/config/main.php`, add your controller to the REST rule.

Example:

```php
['class' => 'yii\rest\UrlRule', 'controller' => ['api/user', 'api/post']],
```

You can keep adding more:

```php
['class' => 'yii\rest\UrlRule', 'controller' => [
    'api/user',
    'api/post',
    'api/product',
    'api/category',
]],
```

### Step 5. Use it from Vue

From Vue, call:

```js
apiRequest('/api/posts')
```

or:

```js
apiRequest('/api/posts/1')
```

## 9. REST Endpoints Yii Will Give You

When using `yii\rest\ActiveController` with `yii\rest\UrlRule`, Yii provides standard REST actions.

For `api/post`, the URL usually becomes `/api/posts`.

Typical endpoints:

- `GET /api/posts` -> list records
- `GET /api/posts/1` -> view one record
- `POST /api/posts` -> create
- `PUT /api/posts/1` -> full update
- `PATCH /api/posts/1` -> partial update
- `DELETE /api/posts/1` -> delete
- `OPTIONS /api/posts` -> preflight/options

This is the Yii equivalent of the REST style you are used to in Laravel.

## 10. Laravel Route Thinking vs Yii Route Thinking

In Laravel you might think:

- `Route::get('/users/{id}', ...)`
- `Route::post('/users', ...)`

In Yii REST, you usually define the controller once using `UrlRule`, and the HTTP method determines which action is used.

So instead of manually declaring every route one by one, you often do:

```php
['class' => 'yii\rest\UrlRule', 'controller' => ['api/user']]
```

Then Yii maps methods automatically.

This is cleaner for CRUD resources.

## 11. When To Use `ActiveController`

Use `yii\rest\ActiveController` when:

- you want standard CRUD
- the resource maps directly to one model
- you want fast API scaffolding

Examples:

- users
- posts
- products
- categories

## 12. When To Use `Controller` Instead

Use `yii\rest\Controller` when:

- the endpoint is not plain CRUD
- you need custom workflows
- you combine multiple models
- you need special validation or transformation

Examples:

- login
- register
- logout
- dashboard summary
- reports
- checkout
- upload

This is exactly why `AuthController` in this project is a custom REST controller.

## 13. If You Need Custom Actions On A Resource

Sometimes a resource is mostly CRUD but also needs extra actions.

Example:

- `POST /api/posts/1/publish`
- `POST /api/posts/1/archive`

In that case, you can still use a controller like `PostController`, but add custom actions and extra URL rules.

Example custom rule:

```php
'POST api/posts/<id:\\d+>/publish' => 'api/post/publish',
```

Then in the controller:

```php
public function actionPublish($id)
{
    // custom logic here
}
```

## 14. What To Replace And What Not To Replace

### Replace or add

- Add new models in `common/models`
- Add new API controllers in `frontend/controllers/api`
- Add new REST route rules in `frontend/config/main.php`
- Add Vue pages/components for the frontend UI
- Add API helper calls in `frontend/resources/lib`

### Do not replace

- Do not replace `SpaController` with all your APIs
- Do not turn every Vue route into a PHP route manually
- Do not put database logic directly inside Vue
- Do not generate classic Yii CRUD views if your goal is SPA pages
- Do not put shared app models in `frontend/models` if they are true domain/data models used across the app

Use `frontend/models` mainly for frontend-specific form models only when needed.

Use `common/models` for database-backed ActiveRecord models.

## 15. Suggested Folder Structure For APIs

As your app grows, use:

```text
common/models/
    User.php
    Post.php
    Product.php

frontend/controllers/
    SpaController.php
    AuthController.php

frontend/controllers/api/
    UserController.php
    PostController.php
    ProductController.php
```

This keeps your API organized and easy to scale.

## 16. How To Send Requests From Vue

This project already has API helpers in:

- `frontend/resources/lib/auth.js`

You can create a similar reusable helper for other modules, or reuse the same request pattern.

Example:

```js
import { apiRequest, getAuthHeaders } from '@/lib/auth'

export function fetchPosts() {
  return apiRequest('/api/posts', {
    headers: getAuthHeaders(),
  })
}

export function fetchPost(id) {
  return apiRequest(`/api/posts/${id}`, {
    headers: getAuthHeaders(),
  })
}

export function createPost(payload) {
  return apiRequest('/api/posts', {
    method: 'POST',
    headers: getAuthHeaders(),
    body: JSON.stringify(payload),
  })
}

export function updatePost(id, payload) {
  return apiRequest(`/api/posts/${id}`, {
    method: 'PATCH',
    headers: getAuthHeaders(),
    body: JSON.stringify(payload),
  })
}

export function deletePost(id) {
  return apiRequest(`/api/posts/${id}`, {
    method: 'DELETE',
    headers: getAuthHeaders(),
  })
}
```

## 17. Validation Rules Still Belong In Yii

Even if Vue has form validation, always keep real validation in Yii models too.

That means:

- required fields
- string lengths
- email format
- uniqueness
- number rules
- foreign key logic

Frontend validation improves UX.
Backend validation protects data integrity.

You need both.

## 18. Authentication For Protected APIs

This project already has JWT auth wired in `AuthController`.

For protected API controllers, you can add auth behaviors so requests require:

- `Authorization: Bearer <token>`

Typical pieces:

- content negotiator for JSON
- CORS
- bearer auth

If you create many API controllers, it is a good idea later to make a shared base controller like:

- `frontend/controllers/api/BaseApiController.php`

Then let other API controllers extend it.

That avoids repeating the same auth and CORS behavior everywhere.

## 19. A Better Long-Term Pattern

As your project grows, this is a strong pattern:

- `ActiveController` for simple resources
- custom `Controller` for special business actions
- shared base API controller for common behaviors
- all DB models in `common/models`

That gives you Laravel-like productivity while still following Yii structure properly.

## 20. Common Mistakes To Avoid

- Putting all backend logic in `SpaController`
- Using Gii CRUD generator for Vue pages
- Mixing Vue route params and Yii API routes as if they are the same thing
- Storing domain models only under `frontend/models`
- Skipping backend validation because Vue already validates
- Forgetting to register new API controllers in `urlManager`
- Forgetting auth headers on protected endpoints

## 21. Simple Checklist For Every New Resource

- Create migration
- Run migration
- Generate model in Gii under `common\models`
- Review rules and relations
- Create API controller under `frontend/controllers/api`
- Add REST rule in `frontend/config/main.php`
- Test with Postman or Insomnia
- Add Vue API helper
- Build Vue page/component

## 22. Recommended Default Choice

If you are unsure what to do for a normal CRUD module, use this:

1. Gii `Model Generator`
2. Manual `ActiveController` in `frontend/controllers/api`
3. Add `yii\rest\UrlRule`
4. Build Vue UI separately

That is the best match for this repository.

## 23. Final Rule Of Thumb

Use:

- Vue Router for pages
- Yii REST controllers for APIs
- `common/models` for database models
- Gii mostly for models

Avoid:

- classic Yii frontend CRUD pages
- putting API logic in `SpaController`

If you follow that pattern, you can create as many controllers and models as you want while still staying clean, scalable, and aligned with MVC.

## 24. RBAC In This Project

Yes, RBAC should be added the regular Yii2 way.

The difference in this project is only where you use it:

- Yii enforces RBAC on the backend
- Vue can read permissions for UI convenience
- real authorization must always stay in Yii

That means:

- Vue may hide buttons like `Edit`, `Delete`, `Publish`
- Yii must still block the request if the user does not have permission

Never rely on Vue alone for security.

## 25. Recommended RBAC Setup

For this project, use:

- `yii\rbac\DbManager`

This is the standard database-backed Yii2 RBAC setup and is the best fit for a growing app with multiple models, controllers, roles, and permissions.

## 26. Add `authManager`

In `common/config/main.php`, add `authManager` to `components`.

Example:

```php
'components' => [
    'cache' => [
        'class' => \yii\caching\FileCache::class,
    ],
    'authManager' => [
        'class' => \yii\rbac\DbManager::class,
    ],
],
```

This makes RBAC available throughout the app using:

```php
Yii::$app->authManager
```

## 27. Create The RBAC Tables

After adding `DbManager`, run Yii's RBAC migration:

```bash
php yii migrate --migrationPath=@yii/rbac/migrations
```

This creates the RBAC tables used by Yii:

- roles
- permissions
- rule assignments
- user-role assignments

## 28. How To Create Roles And Permissions

You have two good options:

- create them in a custom console command
- create them in your own migration or seed-style setup

For most teams, using a console command or a dedicated initialization script is easier to maintain.

Typical examples:

- roles: `admin`, `editor`, `manager`
- permissions: `viewPosts`, `managePosts`, `manageUsers`

Example setup:

```php
$auth = Yii::$app->authManager;

$viewPosts = $auth->createPermission('viewPosts');
$viewPosts->description = 'View posts';
$auth->add($viewPosts);

$managePosts = $auth->createPermission('managePosts');
$managePosts->description = 'Create, update, and delete posts';
$auth->add($managePosts);

$admin = $auth->createRole('admin');
$auth->add($admin);
$auth->addChild($admin, $viewPosts);
$auth->addChild($admin, $managePosts);

$editor = $auth->createRole('editor');
$auth->add($editor);
$auth->addChild($editor, $viewPosts);

$auth->assign($admin, 1);
```

## 29. Where To Enforce RBAC

In this project, enforce RBAC in Yii API controllers.

Do not enforce real authorization in:

- Vue router alone
- Vue components alone
- `SpaController`

Good places to enforce RBAC:

- `checkAccess()` in REST controllers
- `beforeAction()`
- custom service methods
- explicit `Yii::$app->user->can(...)` checks inside actions

## 30. RBAC With `ActiveController`

If your controller uses:

- `yii\rest\ActiveController`

Then the best place to enforce permissions is usually:

- `checkAccess($action, $model = null, $params = [])`

Example:

```php
<?php

namespace frontend\controllers\api;

use Yii;
use common\models\Post;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class PostController extends ActiveController
{
    public $modelClass = Post::class;

    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['index', 'view'], true)) {
            if (!Yii::$app->user->can('viewPosts')) {
                throw new ForbiddenHttpException('You are not allowed to view posts.');
            }
        }

        if (in_array($action, ['create', 'update', 'delete'], true)) {
            if (!Yii::$app->user->can('managePosts')) {
                throw new ForbiddenHttpException('You are not allowed to modify posts.');
            }
        }
    }
}
```

This is the cleanest standard Yii2 approach for REST CRUD authorization.

## 31. RBAC With Custom REST Controllers

If your controller uses:

- `yii\rest\Controller`

Then you usually check permissions manually inside actions or in `beforeAction()`.

Example:

```php
if (!Yii::$app->user->can('manageUsers')) {
    throw new \yii\web\ForbiddenHttpException('Forbidden.');
}
```

This is useful for:

- login-related logic
- reports
- dashboards
- custom workflows
- multi-model business actions

## 32. Suggested Permission Naming

Use clear permission names based on business actions.

Good examples:

- `viewPosts`
- `managePosts`
- `viewUsers`
- `manageUsers`
- `publishPosts`
- `viewDashboard`

Keep naming consistent.

Avoid mixing too many styles like:

- `post.update`
- `edit_post`
- `managePosts`

Pick one convention and use it everywhere.

For this project, action-based names like `managePosts` are simple and readable.

## 33. RBAC And Vue

Vue can use permissions for UI behavior, but only as a convenience layer.

Example use cases in Vue:

- hide `Delete` button if user lacks `managePosts`
- disable `Publish` button if user lacks `publishPosts`
- hide admin menu items if user lacks `viewDashboard`

To support this, you can expose the authenticated user's permissions through an API such as:

- `/api/me`

That endpoint can return:

- user info
- roles
- permissions

But even if Vue hides the button, the API controller must still reject unauthorized requests.

## 34. RBAC And JWT

This project already uses JWT-based auth for API access.

That means the normal flow is:

1. user logs in
2. Vue stores the token
3. Vue sends `Authorization: Bearer <token>`
4. Yii authenticates the user
5. Yii checks RBAC with `Yii::$app->user->can(...)`

So RBAC still works in the normal Yii way after authentication is resolved.

JWT does not replace RBAC.
JWT only identifies the user making the request.
RBAC decides what that user is allowed to do.

## 35. Best Long-Term Pattern For This Repo

As your API grows, a good pattern is:

- use `DbManager`
- seed roles and permissions from console or migrations
- create a shared base API controller for common behaviors
- enforce CRUD permissions in `checkAccess()`
- enforce custom permissions with `can()` checks

This gives you clean separation:

- authentication with JWT
- authorization with RBAC
- frontend UI with Vue

## 36. Common RBAC Mistakes To Avoid

- checking permissions only in Vue
- putting RBAC checks in `SpaController`
- skipping backend `can()` checks because the menu is hidden already
- hardcoding admin-only logic everywhere instead of using permissions
- not seeding roles and permissions consistently between environments

## 37. RBAC Checklist

When adding RBAC to this project, follow this order:

- add `authManager` with `yii\rbac\DbManager`
- run the RBAC migration
- create roles and permissions
- assign roles to users
- enforce permissions in API controllers
- optionally expose permissions to Vue for UI behavior

## 38. Final RBAC Rule Of Thumb

Use RBAC the normal Yii2 way.

In this project:

- JWT answers: who is the user?
- RBAC answers: what can the user do?
- Vue answers: what should the UI show?

That separation is the cleanest and safest approach.
