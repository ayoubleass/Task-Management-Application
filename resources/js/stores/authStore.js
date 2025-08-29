import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { useErrorStore } from './errorStore'


export const useAuthStore = defineStore('authStore', () => {
    //state
    const user = ref(null);
    const token = ref(null) ;
    const isLoading = ref(false);
    const errorStore = useErrorStore();
    //getter
    const isAuthenticated = computed(() => token.value !== null );

    const login = async(url,  userData) => {
        try {
            isLoading.value = true;
            const resp = await fetch(url, {
                method : 'POST',
                Accept: 'application/json',
                headers: { 
                    'Content-Type': 'application/json'
                },
                body : JSON.stringify({
                    email : userData.email,
                    password: userData.password
                }),
            });

            const data = await resp.json();

            if (resp.ok && data.user) {
                user.value = data.user;
                token.value = data.token;
                errorStore.setType(errorStore.types[1]);
            } else {
                errorStore.setError(data.errors || data);
            }
        } catch (error) {
            errorStore.setError({ message: 'Network error' });
        } finally {
            isLoading.value = false;
        }
    };
    

    const register = async (url, userData) => {
        try {
            isLoading.value = true;
            const resp = await fetch(url, {
                method : 'POST',
                Accept: 'application/json',
                headers: { 
                    'Content-Type': 'application/json'
                },
                body : JSON.stringify(userData),
            });

            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError(data.errors);
            } else {
                user.value = data.user;
                token.value = data.token;
                errorStore.setType(errorStore.types[1]);
            }
        } catch (error) {
            errorStore.setError({ message: 'Network error' });
        } finally {
            isLoading.value = true;
        }
    }


    
    
    return {
        user,
        login,
        register,
        isAuthenticated,
        token,
    };

});