import { createRouter, createWebHistory } from 'vue-router'
import DefaultLayout from './layout/DefaultLayout.vue'
import DashboardLayout from './layout/DashboardLayout.vue'

// Public pages (use DefaultLayout)
import Home from './pages/Home.vue'
import Login from './pages/auth/Login.vue'
import Register from './pages/auth/Register.vue'

// Dashboard pages (use DashboardLayout)
import DashboardHome from './pages/admin/Dashboard.vue'
import Profile from './pages/admin/Profile.vue'
import Settings from './pages/admin/Settings.vue'
import { isAuthenticated } from '@/lib/auth'

const DOCS_URL = 'https://yiivue.zcreations.xyz/'

function openDocumentation() {
    window.open(DOCS_URL, '_blank', 'noopener')
    return false
}

const routes = [
    {
        path: '/',
        component: DefaultLayout,
        children: [
            { path: '', component: Home },
            { path: 'login', component: Login },
            { path: 'register', component: Register },
            { 
                path: 'documentation', 
                beforeEnter: openDocumentation,
                meta: {
                    title: 'Documentation',
                    description: 'Open the external YiiVue documentation.',
                }
            },
        ]
    },
    {
        path: '/dashboard',
        component: DashboardLayout,
        meta: {
            requiresAuth: true,
            title: 'Dashboard',
            description: 'Navigate your workspace from the sidebar.',
        },
        children: [
            {
                path: '',
                component: DashboardHome,
                meta: {
                    title: 'Overview',
                    description: 'Track activity and get a quick system snapshot.',
                },
            },
            {
                path: 'profile',
                component: Profile,
                meta: {
                    title: 'Profile',
                    description: 'Update your personal account details.',
                },
            },
            {
                path: 'settings',
                component: Settings,
                meta: {
                    title: 'Settings',
                    description: 'Manage preferences and workspace options.',
                },
            },
            {
                path: 'documentation',
                beforeEnter: openDocumentation,
                meta: {
                    title: 'Documentation',
                    description: 'Open the external YiiVue documentation.',
                },
            },
        ]
    },
    // Catch-all 404 inside DefaultLayout (optional)
    {
        path: '/:pathMatch(.*)*',
        component: DefaultLayout,
        children: [
            { path: '', component: () => import('./pages/NotFound.vue') }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

// Global guard for authentication
router.beforeEach((to, from) => {
    const authenticated = isAuthenticated()

    if (to.meta.requiresAuth && !authenticated) {
        return '/login'
    }

    if (authenticated && (to.path === '/login' || to.path === '/register' || to.path === '/')) {
        return '/dashboard'
    }
})

export default router
