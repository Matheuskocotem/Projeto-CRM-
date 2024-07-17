import { createRouter, createWebHistory } from 'vue-router'
import store from "../store/index";

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
      path: '/ResetPassword',
      name: 'ResetPassword',
      component: () => import('../views/ResetPassword.vue'),
      meta: {
        title: 'ResetPassword',
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.meta.title){
    document.title = to.meta.title;
  }

  const Auth = store.getters.isAuth;
  const PublicRoutes = ['/login', '/register', '/forgotPassword'];
  const AuthRequired = !PublicRoutes.includes(to.path);

  if(AuthRequired && !Auth){
    next({ name: 'login', query: { error: 'Você deve estar logado!'} });
  } else {
    next();
  }
});

export default router
