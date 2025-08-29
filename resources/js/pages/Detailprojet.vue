<template>
    <div class="bg-gray-100  min-h-screen ">
        <div class="flex flex-col w-full m-auto max-w-screen-xl p-5 ">
            <div class="mt-6 w-full flex items-center justify-end ">
                <RouterLink
                    :to="`/project/${project.id}/task`"
                    class="inline-block text-blue-500 font-semibold  hover:underline underline-offset-1 transition-colors duration-200 "
                >
                    Add task
                </RouterLink>
            </div>
            <template v-if="project.taches?.length > 0">
                <div v-for="tache in project.taches">
                    <TaskCard  :tache="tache" />
                </div>
            </template>
            <template v-else>
                <p class="mt-20 text-center text-gray-500">No tasks found.</p>
            </template>
        </div>
    </div>
</template>


<script setup>
    import { ref, onBeforeMount } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { useProjectStore } from '@/stores/projectStore';
    import TaskCard from '@/components/TaskCard.vue';

    
    const route = useRoute();
    const projectStore = useProjectStore();
    const project = ref({});
    
    onBeforeMount(() => {
        if (projectStore.projects.length > 0) {
            project.value = projectStore.projects.find((p) => p.id == route.params.id);
        }
    });


</script>