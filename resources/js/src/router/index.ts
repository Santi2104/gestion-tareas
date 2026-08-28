import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";
import { useAuthStore } from "../modules/auth/stores/useAuthStore";

const router = createRouter({
    history: createWebHistory(),
    routes: [...routes],
});

router.beforeEach(async (to) => {
    const authStore = useAuthStore();

    if (!authStore.initialized) {
        await authStore.fetchUser();
    }

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return { name: "login", query: { redirect: to.fullPath } };
    }

    if (to.meta.requiresGuest && authStore.isAuthenticated) {
        return { name: "tasks" };
    }
});

export default router;
