import { defineStore } from "pinia";
import { ref, computed } from "vue";
import type { User, LoginCredentials, RegisterData } from "../../../types/auth";
import { getUserAction } from "../actions/getUserAction";
import { loginAction } from "../actions/loginAction";
import { registerAction } from "../actions/registerAction";
import { logoutAction } from "../actions/logoutAction";

export const useAuthStore = defineStore("auth", () => {
    const user = ref<User | null>(null);
    const loading = ref<boolean>(false);
    const initialized = ref<boolean>(false);

    const isAuthenticated = computed(() => !!user.value);

    const fetchUser = async () => {
        try {
            loading.value = true;
            user.value = await getUserAction();
        } catch {
            user.value = null;
        } finally {
            loading.value = false;
            initialized.value = true;
        }
    };

    const login = async (credentials: LoginCredentials) => {
        loading.value = true;
        try {
            await loginAction(credentials);
            await fetchUser();
        } finally {
            loading.value = false;
        }
    };

    const register = async (data: RegisterData) => {
        loading.value = true;
        try {
            await registerAction(data);
            await fetchUser();
        } finally {
            loading.value = false;
        }
    };

    const logout = async () => {
        loading.value = true;
        try {
            await logoutAction();
        } finally {
            user.value = null;
            loading.value = false;
        }
    };

    return {
        user,
        loading,
        initialized,
        isAuthenticated,
        fetchUser,
        login,
        register,
        logout,
    };
});
