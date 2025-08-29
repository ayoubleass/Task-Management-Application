<template>
    <div class="bg-gray-100  min-h-screen">
        <div class="flex flex-col w-full m-auto max-w-screen-xl p-5 ">
            <div class="mt-6 w-full flex items-center justify-end ">
                <RouterLink
                    to="/project"
                    class="inline-block text-blue-500 font-semibold  hover:underline underline-offset-1 transition-colors duration-200 "
                >
                    Create Project
                </RouterLink>
            </div>
            <template v-if="projectStore.projects.length > 0">
                <div v-for="project in projectStore.projects">
                    <ProjectCard :project="project"/>
                </div>
            </template>
            <template v-else>
                <p class="mt-20 text-center text-gray-500">No projects found.</p>
            </template>
        </div>
    </div>
</template>

<script setup>
    import { onMounted, onBeforeMount } from 'vue';
    import {useAuthStore} from '@/stores/authStore.js';
    import {useProjectStore} from '@/stores/projectStore.js';
    import ProjectCard from '@/components/ProjectCard.vue';
    import { RouterLink, useRouter } from 'vue-router';
  
    const baseUrl = import.meta.env.VITE_API_BASE_URL;
    const authStore = useAuthStore();
    const projectStore = useProjectStore();
    const router = useRouter();

    onBeforeMount(() => {
        if (!authStore.isAuthenticated) {
            router.push('/login');
        }
    });
    
    onMounted(async () => {
        await projectStore.fetchProjects(
            `${baseUrl}/projects`,
            authStore.token
        );
    });

</script>