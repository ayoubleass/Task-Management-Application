import { ref, computed } from 'vue';
import { defineStore } from 'pinia';
import { useAuthStore } from './authStore';
import { useErrorStore } from './errorStore';

export const useProjectStore = defineStore('projectStore', () => {
    //state
    //const isLoading = ref(false);
    const projects = ref([]);
    const authStore = useAuthStore();
    const errorStore = useErrorStore();


    const fetchProjects = async (url) => {
        try {
            const resp = await fetch(url, {
                method : 'GET',
                headers: { 
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${authStore.token}`,
                },
            });

            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError({message: "Please login to see your projects!"});
            }else {
                projects.value = data.data;
            }
        } catch (error) {
            errorStore.setError({message: "Something went wrong. Please try again."});
        }
    };

    const createProject = async(url, formData = {}) => {
        try {
            const resp = await fetch(url, {
                method : 'POST',
                headers: { 
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${authStore.token}`,
                },
                body : JSON.stringify({
                    title : formData.title,
                    description : formData.description,
                }),
            });
            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError(data.errors || data);
            }else {
                errorStore.setFlashMessage(data.message);
                errorStore.setType(errorStore.types[1]);
            }
        } catch (error) {
            errorStore.setError({
                message: "Something went wrong. Please try again."
            });
        }
    }
    
    const updateProject = async (url, fromData) => {
        try {
            const resp = await fetch(url, {
                method : 'PUT',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${authStore.token}`,
                },
                body : JSON.stringify({
                    title : fromData.title,
                    description : fromData.description,
                }),
            });

            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError(data.errors || data);
            }else {
                errorStore.setFlashMessage(data.message);
                errorStore.setType(errorStore.types[1]);
            }
        } catch (error) {
            errorStore.setError({
                message: "Something went wrong. Please try again."
            });
        }
    }

    return {
       projects,
       fetchProjects,
       createProject,
       updateProject,

    };
});
