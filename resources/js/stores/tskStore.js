import { defineStore } from 'pinia';
import {ref, computed} from 'vue';
import {useErrorStore} from './errorStore.js';
import {useAuthStore} from'./authStore.js';



export const  useTaskStore = defineStore('taskStore', () => {

    const errorStore = useErrorStore();
    const authStore = useAuthStore();

    const createTask = async (url, taskFormDta) => {
        try {
            const resp = await fetch(url , {
                method: 'POST',
                 headers: { 
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${authStore.token}`,
                },
                body: JSON.stringify({
                    title: taskFormDta.title,
                    description : taskFormDta.description,
                    assign_to : taskFormDta.assign_to,
                    status : taskFormDta.selectedState,
                    priority : taskFormDta.selectedPriority,
                    
                }),
            })

            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError(data.errors || data);
            }else {
                errorStore.setFlashMessage(data.message);
                errorStore.setType(errorStore.types[1]);
            }
        }catch (error) {
            errorStore.setError({message: 'Something went wrong. Please try again.'});
        }
    }

    const updateTask = async (url, taskFormDta) => {
        console.log(taskFormDta);
         try {
            const resp = await fetch(url , {
                method: 'PUT',
                 headers: { 
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${authStore.token}`,
                },
                body: JSON.stringify({
                    title: taskFormDta.title,
                    description : taskFormDta.description,
                    assign_to : taskFormDta.assign_to,
                    status : taskFormDta.selectedState,
                    priority : taskFormDta.selectedPriority,
                    
                }),
            })

            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError(data.errors || data);
            }else {
                errorStore.setFlashMessage(data.message);
                errorStore.setType(errorStore.types[1]);
            }
        }catch (error) {
            errorStore.setError({message: 'Something went wrong. Please try again.'});
        }
    }

    const deleteTask = async (url) => {
        try {
            const resp = await fetch(url , {
                method: 'DELETE',
                 headers: { 
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${authStore.token}`,
                },
            })
            const data = await resp.json();
            if (!resp.ok) {
                errorStore.setError(data.errors || data);
            }else {
                errorStore.setFlashMessage(data.message);
                errorStore.setType(errorStore.types[1]);
            }
        }catch (error) {
            errorStore.setError({message: 'Something went wrong. Please try again.'});
        }
    }

    return {
        createTask,
        updateTask,
        deleteTask,
    }

});