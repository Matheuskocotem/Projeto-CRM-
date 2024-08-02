import { createRouter, createWebHistory } from 'vue-router';
import store from "../store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue'),
      meta: {
        title: 'login'
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Register.vue'),
      meta: {
        title: 'Register'
      }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/Dashboard.vue'),
      meta: {
        title: 'Dashboard',
      }
    },
    {
      path: '/resetPassword/:token',
      name: 'resetPassword',
      component: () => import('../views/ResetPassword.vue'),
      props: route => ({
        token: route.query.token,
        email: route.query.email
      }),
    },
    {
      path: '/forgot-password',
      name: 'forgot-password',
      component: () => import('../views/ForgotPassword.vue'),
      meta: {
        title: 'esqueci minha senha',
      },
    },
    {
<<<<<<< HEAD
      path: '/funnel/:name/:id',
=======
      path: '/funnel/:name/:id/:color',
>>>>>>> origin/main
      name: 'Funil',
      
      component: () => import('../views/Kanban.vue')
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.meta.title){
    document.title = to.meta.title;
  }

  const auth = store.getters['user/isAuth'];
  const PublicRoutes = ['/login', '/register'];
  const AuthRequired = !PublicRoutes.includes(to.path);

  if(AuthRequired && !auth){
    next({ name: 'login', query: { error: 'Você deve estar logado!'} });
  } else {
    next();
  }
})


export default router;
