<template>
  <div class="flex min-h-screen bg-white ">
    <!-- Simple Sidebar (Laravel Style) -->
    <aside class="hidden lg:block w-72 border-r border-gray-100  p-8 overflow-y-auto sticky top-0 h-screen">
      <div class="mb-10">
        <router-link to="/" class="flex items-center gap-2 font-black text-2xl tracking-tighter ">
          <span class="text-[#FF2D20] uppercase">YiiVue</span>
        </router-link>
      </div>

      <nav class="space-y-8">
        <div>
          <h5 class="text-xs font-bold text-[#FF2D20] uppercase tracking-widest mb-4">Prologue</h5>
          <ul class="space-y-3 text-sm font-medium">
            <li><a href="#introduction" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Introduction</a></li>
            <li><a href="#installation" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Installation</a></li>
          </ul>
        </div>

        <div>
          <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">The Backend</h5>
          <ul class="space-y-3 text-sm font-medium">
            <li><a href="#yii2-core" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Yii2 Configuration</a></li>
            <li><a href="#jwt-auth" class="text-gray-600  hover:text-[#FF2D20] transition-colors">JWT Authentication</a></li>
            <li><a href="#migrations" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Migrations & Seeds</a></li>
          </ul>
        </div>

        <div>
          <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">The Frontend</h5>
          <ul class="space-y-3 text-sm font-medium">
            <li><a href="#vue-structure" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Vue Component Tree</a></li>
            <li><a href="#vite-workflow" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Vite & HMR</a></li>
            <li><a href="#shadcn" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Shadcn Components</a></li>
          </ul>
        </div>

        <div>
          <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Deployment</h5>
          <ul class="space-y-3 text-sm font-medium">
            <li><a href="#docker-prod" class="text-gray-600  hover:text-[#FF2D20] transition-colors">Production Docker</a></li>
          </ul>
        </div>
      </nav>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-8 lg:p-20 max-w-5xl overflow-hidden">
      <div class="prose prose-slate  max-w-none">
        <h1 id="introduction" class="text-5xl font-black tracking-tight mb-8 ">Introduction</h1>
        
        <p class="text-xl text-gray-600  leading-relaxed mb-12">
          The YiiVue (Personnel Management Information System) stack is a high-performance boilerplate designed for large-scale personnel data management. It combines the industrial-grade stability of <strong>Yii2</strong> with the modern, reactive user interface of <strong>Vue 3</strong>.
        </p>

        <section id="installation" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Installation</h2>
          <p class="text-gray-600  mb-6">Setting up your development environment is fully automated via Docker Compose. Ensure you have Docker and Git installed on your machine.</p>
          
          <div class="bg-[#0b0b0b] rounded-2xl p-6 mb-6 overflow-hidden">
            <pre class="text-sm text-gray-300 font-mono mb-0 overflow-x-auto"><code><span class="text-gray-500"># 1. Clone the repository</span>
git clone https://github.com/your-repo/yiivue-stack.git

<span class="text-gray-500"># 2. Start the Docker environment</span>
docker compose up -d --build

<span class="text-gray-500"># 3. Initialize Database (Initial Migration)</span>
docker exec -it vuejs php yii migrate --interactive=0</code></pre>
          </div>
        </section>

        <section id="yii2-core" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Yii2 Configuration</h2>
          <p class="text-gray-600  mb-4">The backend is powered by Yii2 Advanced Template. Configuration is split into <code>common</code>, <code>frontend</code>, <code>backend</code>, and <code>console</code>.</p>
          <p class="text-gray-600  mb-4">We use <code>phpdotenv</code> for environment-specific settings. You should create a <code>.env</code> file based on <code>.env.example</code>.</p>
          <div class="bg-gray-50  border border-gray-100  p-6 rounded-2xl">
            <h4 class="font-bold mb-2 ">Key Files:</h4>
            <ul class="space-y-2 text-sm text-gray-600 ">
              <li>• <code>common/config/main.php</code>: Shared components (DB, Cache, JWT).</li>
              <li>• <code>frontend/config/main.php</code>: Frontend-specific components and routes.</li>
              <li>• <code>.env</code>: Local environment variables (DB credentials, API keys).</li>
            </ul>
          </div>
        </section>

        <section id="jwt-auth" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">JWT Authentication</h2>
          <p class="text-gray-600  mb-4">Security is handled by the <code>kaabar/jwt-yii2</code> extension. Every request from the Vue frontend includes a Bearer token in the Authorization header.</p>
          <p class="text-gray-600  mb-4">Configuration for JWT can be found in <code>common/config/main.php</code> under the <code>jwt</code> component:</p>
          <div class="bg-[#0b0b0b] rounded-2xl p-6 mb-6 overflow-hidden">
            <pre class="text-sm text-gray-300 font-mono mb-0 overflow-x-auto"><code><span class="text-gray-500">// common/config/main.php</span>
'components' => [
    'jwt' => [
        'class' => \kaabar\jwt\Jwt::class,
        'key' => 'your-secret-key',
        'signer' => 'HS256',
    ],
],</code></pre>
          </div>
        </section>

        <section id="migrations" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Migrations & Seeds</h2>
          <p class="text-gray-600  mb-4">The database schema is managed through Yii2 migrations. You can find them in the <code>console/migrations</code> directory.</p>
          <div class="bg-gray-50  border border-gray-100  p-6 rounded-2xl">
            <h4 class="font-bold mb-2 ">Useful Commands:</h4>
            <ul class="space-y-2 text-sm text-gray-600  font-mono">
              <li>• php yii migrate/up</li>
              <li>• php yii migrate/create create_user_table</li>
              <li>• php yii fixture/load "*"</li>
            </ul>
          </div>
        </section>

        <section id="vue-structure" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Vue Component Tree</h2>
          <p class="text-gray-600  mb-6">The frontend is located in <code>frontend/resources/js</code>. It follows a modular structure:</p>
          <ul class="list-disc pl-6 space-y-3 text-gray-600 ">
            <li><strong>/pages:</strong> Full-page components (Home, Documentation, Dashboard).</li>
            <li><strong>/components/ui:</strong> Base UI components (Buttons, Inputs, Cards).</li>
            <li><strong>/layout:</strong> Master layouts (Default, Dashboard).</li>
            <li><strong>/lib:</strong> Utility functions and API clients.</li>
          </ul>
        </section>

        <section id="vite-workflow" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Vite & HMR</h2>
          <p class="text-gray-600  mb-4">Vite handles asset compilation and provides Hot Module Replacement. When you change a Vue component, the changes are reflected instantly without a page reload.</p>
          <p class="text-gray-600  font-bold mb-4">Development URL: <span class="text-[#FF2D20]">http://localhost:5173</span></p>
        </section>

        <section id="shadcn" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Shadcn Components</h2>
          <p class="text-gray-600  mb-4">We use a customized version of <strong>Shadcn UI</strong> adapted for Vue 3. These components are located in <code>frontend/resources/js/components/ui</code>.</p>
          <p class="text-gray-600  mb-4">To use a component, simply import it into your Vue file:</p>
          <div class="bg-[#0b0b0b] rounded-2xl p-6 mb-6 overflow-hidden">
            <pre class="text-sm text-gray-300 font-mono mb-0 overflow-x-auto"><code>import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'</code></pre>
          </div>
        </section>

        <section id="docker-prod" class="mb-16 pt-8 border-t border-gray-100 ">
          <h2 class="text-3xl font-bold mb-6 ">Production Docker</h2>
          <p class="text-gray-600  mb-4">For production deployments, use the <code>Dockerfile</code> and <code>docker-compose.yml</code> optimized for performance.</p>
          <ul class="list-disc pl-6 space-y-3 text-gray-600 ">
            <li>Multi-stage builds to reduce image size.</li>
            <li>Nginx configured for SPA routing.</li>
            <li>PHP-FPM optimized for high-concurrency.</li>
          </ul>
        </section>

        <div class="mt-20 pt-12 border-t border-gray-100  flex justify-between items-center">
            <p class="text-sm text-gray-500 font-medium">© 2026 YiiVue Clean Codes. Engineered for high-performance personnel management.</p>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
}
.prose h2 {
    margin-top: 0;
}
a {
    text-decoration: none;
}
</style>
