import { defineStore } from 'pinia';
import {ref, computed} from 'vue';


export const  useErrorStore = defineStore('errorStore', () => {
    const types = ['error', 'success'];
    const errors = ref({});
    const type = ref(types[0]);
    const flashMessage = ref(null);

    const  setError = (newErrors) => {
        errors.value = newErrors;
    }

    const setType= (newType) => {
        type.value = newType;
    }

    const clearErrors = () => {
        errors.value = {};
    }

    const setFlashMessage = (newFlashMessage) => {
        flashMessage.value = newFlashMessage;
    }

    const clearFlashMessage = () =>  {
        flashMessage.value = '';
    }


    return {
        clearErrors,
        setError,
        errors,
        type,
        setType,
        types,
        flashMessage,
        setFlashMessage,
        clearFlashMessage
    }

});