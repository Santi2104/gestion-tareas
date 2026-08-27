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
            },
            {
                path: "/register",
                name: "register",
                component: () => import("../modules/auth/pages/RegisterPage.vue"),
            },
        ],
    },
    {
        path: "/tasks",
        component: () => import("../layout/AuthLayout.vue"),
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
