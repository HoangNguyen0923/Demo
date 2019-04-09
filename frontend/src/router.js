import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import Dashboard from './views/Dashboard.vue'
import ResetPassword from './views/ResetPassword.vue'
import ResetPasswordLink from './views/ResetPasswordLink.vue'
import ResetPasswordForm from './views/ResetPasswordForm.vue'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/reset_password',
      name: 'reset_password',
      component: ResetPassword
    },
    {
      path: '/reset_password_link',
      name: 'reset_password_link',
      component: ResetPasswordLink,
      meta: {
        requiresToken: true
      }
    },
    {
      path: '/reset_password_form',
      name: 'reset_password_form',
      component: ResetPasswordForm,
      meta: {
        requiresToken: true
      }
    }
  ]
})

export default router

router.beforeEach((to, from, next) => {
  // to and from are both route objects. must call `next`.
  console.log(to)
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    //
    // let authUser = JSON.stringify(localStorage.getItem('storedData'))
    // When sending data to a web server, the data has to be a string.
    // Convert a JavaScript object into a string with JSON.stringify().
    // When receiving data from a web server, the data is always a string.
    // Parse the data with JSON.parse(), and the data becomes a JavaScript object.
    //
    let authUser = localStorage.storedData
    // console.log(authUser)
    if (!authUser) {
      next({
        path: '/'
      })
    } else {
      next()
    }
  } else {
    next()
  }
  if (to.matched.some(record => record.meta.requiresToken)) {
    let tokenUser = localStorage.token_reset
    if (!tokenUser) {
      next({
        path: '/'
      })
    } else {
      next()
    }
  } else {
    next()
  }
})
