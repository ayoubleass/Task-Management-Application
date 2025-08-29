<template>
    <div class="min-h-screen w-full bg-gray-50 flex flex-col items-center justify-center lg:px-15 px-10">
        <div  class="py-10 w-1/2" v-if="errorStore.errors?.message ||  errorStore?.flashMessage">
            <FlashMessage :message="errorStore.errors.message"  :type="errorStore.type"/>
        </div>
        <TaskForm 
            :title="action !== 'update' ?'Add a new Task' : 'Update Task'" 
            :projectId="route.params?.id" 
            :tacheId="tacheOldData?.id"
            :action="action"
        />
    </div>
</template>

<script setup>
    import TaskForm from '@/components/TaskForm.vue';
    import FlashMessage from '@/components/FlashMessage.vue';
    import { onBeforeMount, ref, watch } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { useProjectStore } from '@/stores/projectStore';
    import { useErrorStore } from '@/stores/errorStore';
    import { useAuthStore } from '@/stores/authStore';

    const router = useRouter();
    const route = useRoute();
    const errorStore = useErrorStore();
    const authStore = useAuthStore();
    const action = ref('create');
    const tacheOldData = ref({});
    const projectStore = useProjectStore();


    onBeforeMount(() => {
        if (authStore.isAuthenticated) {
            errorStore.clearErrors();
            errorStore.clearFlashMessage();
            const formAction = route.query?.action;
            const id = route.query?.id;
            const projectId = route.params?.id;
    
            if (formAction === 'update') {
                action.value = formAction;
                const project = projectStore.projects.find((p) => p.id == projectId);
                if (project) {
                    tacheOldData.value = project.taches.find((t) => t.id == id);
                }
            }
        } else{
            router.push('/login');
        }

    });

    watch(
      () => errorStore.flashMessage, 
      () => setTimeout(() => errorStore.clearFlashMessage(), '2000')
    );


</script>