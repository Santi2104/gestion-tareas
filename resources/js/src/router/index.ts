import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";

const router = createRouter({
    history: createWebHistory(),
    routes: [...routes],
});

// router.beforeEach( async (to, from, next) => {
//     const auth = useAuthStore()

//     const isAuth = await auth.getUser()
//     if ((to.meta.requiresAuth) && (isAuth == false)) {
//       next({ name: 'login' })
//     } else {
//       next()
//     }

//   })
export default router;
