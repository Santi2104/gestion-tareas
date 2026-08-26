import { RouteRecordRaw } from "vue-router";

const routes: RouteRecordRaw[] = [
    // Rutas para usuarios no autenticados (con GuessLayout)
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
                component: () =>
                    import("../modules/auth/pages/RegisterPage.vue"),
            },
        ],
    },

    // Rutas para usuarios autenticados (sin layout por ahora)
    {
        path: "/dashboard",
        component: () => import("../layout/AuthLayout.vue"), // Temporal
        children: [
            {
                path: "",
                name: "dashboard",
                component: () => import("../modules/DashboardPage.vue"),
            },
        ],
    },
];

export default routes;
