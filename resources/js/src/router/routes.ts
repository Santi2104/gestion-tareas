import { RouteRecordRaw } from "vue-router";

const routes: RouteRecordRaw[] = [
    {
        path: "/",
        component: () => import("../layout/GuessLayout.vue"),
        children: [
            {
                path: "",
                name: "welcome",
                component: () => import("../pages/WelcomePage.vue"),
            },
            {
                path: "/login",
                name: "login",
                component: () => import("../modules/auth/pages/LoginPage.vue"),
                meta: { requiresGuest: true },
            },
            {
                path: "/register",
                name: "register",
                component: () => import("../modules/auth/pages/RegisterPage.vue"),
                meta: { requiresGuest: true },
            },
            {
                path: ":pathMatch(.*)*",
                name: "not-found",
                component: () => import("../pages/NotFoundPage.vue"),
            },
        ],
    },
    {
        path: "/tasks",
        component: () => import("../layout/AuthLayout.vue"),
        meta: { requiresAuth: true },
        children: [
            {
                path: "",
                name: "tasks",
                component: () => import("../modules/tasks/pages/TaskListPage.vue"),
            },
        ],
    },
    {
        path: "/dashboard",
        redirect: "/tasks",
    },
];

export default routes;
