# YiiVue-SPA Advanced Template

A modern, high-performance boilerplate combining the **Yii2 Advanced Template** (PHP) and **Vue.js 3 + Vite** (JavaScript). This project is designed for professional-grade applications where the backend provides a robust REST API and the frontend is a highly interactive Single Page Application (SPA).

---

##  Key Philosophy: "Thin PHP, Thick Vue"
Unlike traditional Yii2 projects, this template minimizes the use of PHP-rendered views. 
- **The Backend (Yii2):** Acts primarily as a **RESTful API engine** and data provider.
- **The Frontend (Vue 3):** Handles 100% of the UI, state management, and client-side routing.
- **The Bridge:** A single `SpaController` in Yii serves the initial Vue entry point. After that, Vue takes full control.

---

##  Environment Configuration (.env)
This project uses `vlucas/phpdotenv` to manage environment variables. This allows you to store sensitive credentials (like DB passwords and JWT keys) in a single file that is **not committed to git**.

1. **Create your .env file:**
   ```bash
   cp .env.example .env
   ```
2. **Configure your variables:** Open `.env` and update the database and JWT settings to match your local or production environment.
3. **Automatic Loading:** The system automatically loads these variables in `common/config/bootstrap.php`. You can access them anywhere in PHP using `getenv('VARIABLE_NAME')`.

---

##  Quick Start (Docker - Recommended)

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd recreate-pmis-clean-codes
   ```

2. **Initialize the application:**
   This sets up the local environment files. Choose `Development` for local work.
   ```bash
   ./init
   ```

3. **Spin up Docker:**
   ```bash
   docker-compose up -d --build
   ```

4. **Run Migrations:**
   ```bash
   docker exec -it vuejs php yii migrate --interactive=0
   ```

5. **Install NPM dependencies:**
   ```bash
   npm install
   npm run dev
   ```

6. **Access the App:**
   - **Frontend (Yii Entry):** [http://localhost:9001](http://localhost:9001)
   - **Vite Dev Server:** [http://localhost:5173](http://localhost:5173) (used by Yii in dev mode for HMR)

---

##  Manual Setup (Non-Docker)

1. **Composer Install:** `composer install`
2. **Init:** `./init`
3. **Configure DB:** Update `common/config/main-local.php` with your database credentials.
4. **Migrate:** `php yii migrate`
5. **NPM Install:** `npm install`
6. **Build/Run:** `npm run dev` or `npm run build`

---

##  Project Structure & Development Tips

### Backend (`/common`, `/frontend/controllers`, `/backend/controllers`)
- **Use `yii\rest\Controller`:** For all your data endpoints. It automatically handles JSON formatting and error responses.
- **Shared Logic:** Always put your Models and Business Logic in `common/models`. This ensures both the user-facing app (`frontend`) and admin panel (`backend`) use the same rules.
- **JWT Auth:** Authentication is handled via JWT. See `AuthController.php` for login/registration examples.

### Frontend (`/frontend/resources`)
- **Vue Entry:** Located in `frontend/resources/js/app.js`.
- **Components:** Put your UI pieces in `frontend/resources/js/components`.
- **Pages:** Route-level components go in `frontend/resources/js/pages`.
- **Shadcn/Tailwind:** Styled using Tailwind CSS for rapid UI development.

---

##  Developer Tips for Ease of Setup

1. **The `init` script:** Just like the official Yii2 Advanced template, always run `./init` first. It creates your `-local.php` config files which are ignored by git.
2. **HMR (Hot Module Replacement):** In `development` mode, the Yii `SpaController` detects if the Vite server is running and automatically injects the HMR client. No need to refresh the page!
3. **One View Rule:** Only create `.php` views if you absolutely need them for SEO or meta tags. Otherwise, let Vue handle everything.
4. **API Testing:** Use Postman or Insomnia to test your `rest/` endpoints independently of the Vue UI.

---

##  Using as a Composer Template
If you want to use this as a base for new projects:
1. **Host it on Git:** Push this repository to your GitHub/GitLab.
2. **Install via Composer:**
   ```bash
   composer create-project your-username/yii2-vue-spa-template new-project
   ```
3. **Configure `composer.json`:** Update the `name`, `description`, and `authors` fields in your new project.

---

##  Documentation Indices
- [Architecture Overview](ARCHITECTURE.md) - Deep dive into system design and technology stack.
- [Frontend Guide](frontend/resources/README.md) (if exists) - Detailed frontend components and styling.

---

##  License
This project is licensed under the MIT License.
