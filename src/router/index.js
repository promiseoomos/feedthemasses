import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView"
import SignupView from '@/views/SignupView'
import DashboardView from '@/views/DashboardView'

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
    redirect : { name : "login"}
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
  {
    path : "/login",
    name : "login",
    component : LoginView
  },
  {
    path : "/signup",
    name : "signup",
    component : SignupView
  },
  {
    path: "/dashboard",
    name : "dashboard",
    component : DashboardView,
    children : [
        {
            path: "",
            name : "dashboardhome",
            component : () => import("../views/DashboardHomeView.vue")
        },
        {
            path : "profile/:username",
            name : "profile",
            props : true,
            component : () => import ("../views/ProfilePage.vue")
        },
        {
            path : "matrix",
            name : "matrix",
            component : () => import("../views/MatrixView.vue")
        },
        {
            path : "rewards",
            name : "rewards",
            component : () => import("../views/RewardsView.vue")
        },
        {
            path : "upgrade",
            name : "upgrade",
            component : () => import("../views/UpgradeView.vue")
        }
    ]
  },
  {
      path : "/securedlogin",
      name : "sadminlogin",
      component : () => import("../views/AdminLogin.vue")
  },
  {
    path : "/adf8d9234min",
    name : "securedadmin",
    component : () => import("../views/AdminView.vue"),
    children : [
        {
            path : "home",
            name : "adminhome",
            component : () => import("../views/AdminHomeView.vue")
        }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
