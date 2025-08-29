<template>
  <!-- Error -->
  <div class="min-h-screen w-full bg-gray-100 flex flex-col items-center justify-center px-10 md:px-5 border">
    <template v-if="errorStore.errors?.message ||  errorStore?.flashMessage">
      <FlashMessage :message="errorStore.errors.message"  :type="errorStore.type"/>
    </template>
    <div class="px-5 py-6 bg-white rounded-xl shadow-lg lg:w-1/3 w-90">
    <!-- Title -->
    <div class="text-center mb-6 text-blue-500">
        <h2 class="text-2xl font-bold ">
          {{ title[action] }}
        </h2>
      </div>
      <!-- Project Form -->
      <form class="space-y-4 lg:px-2 text-sm" @submit.prevent="handleSubmit">
        
        <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200">
          <input
            type="text"
            placeholder="Project Name"
            class="w-full p-2 outline-none text-gray-700 placeholder-gray-400"
            v-model="projectInputs.title"
          />

          <div v-if="Array.isArray(errorStore.errors?.title)" class="text-red-500">
              {{ errorStore.errors.title[0] }}
            </div>

        </div>
        <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200">
          <textarea
            placeholder="Project Description"
            rows="4"
            class="w-full p-2 outline-none text-gray-700 placeholder-gray-400"
            v-model="projectInputs.description"
          ></textarea>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full py-2 mt-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors duration-200 cursor-pointer"
        >
          submit
        </button>
      </form>
    </div>
  </div>

</template>

<script setup>
    import {ref, computed, reactive, watch, onBeforeMount} from 'vue';
    import {useProjectStore}  from '@/stores/projectStore.js';
    import { useAuthStore } from '@/stores/authStore';
    import { useErrorStore } from '@/stores/errorStore';
    import { useRoute, useRouter } from 'vue-router';
    import FlashMessage from '@/components/FlashMessage.vue';
    

    const errorStore = useErrorStore();
    const projectStore = useProjectStore();
    const authStore = useAuthStore();
    const route = useRoute();
    const router = useRouter();
    const projectInputs  = reactive({
        title : '',
        description : '',
    });
    const title = reactive({
      update : 'Update project',
      create: 'Create New Project',
    });
    const action = ref(null);

    const handleSubmit = async () => {

        errorStore.clearErrors();
        errorStore.clearFlashMessage();

        if (action.value !== 'update') {
          await projectStore.createProject('http://127.0.0.1:8000/api/project',
                  projectInputs);
        } else {
          await projectStore.updateProject(`http://127.0.0.1:8000/api/project/${route.query?.id}`,
                  projectInputs);
        }

        router.push('/Dashboard');
    }

    watch(
      () => errorStore.errors.message,
      () => setTimeout(() => errorStore.clearErrors(), '2000')
    );

    watch(
      () => errorStore.flashMessage, 
      () => setTimeout(() => errorStore.clearFlashMessage(), '2000')
    )

    onBeforeMount(() => {
      if (authStore.isAuthenticated && projectStore.projects.length > 0) {
        errorStore.clearErrors();
        errorStore.clearFlashMessage();
        action.value  = route.query?.action  || 'create';
        if (action.value == 'update') {
          const projectId = route.query?.id;
          const project = projectStore.projects.find((p) => p.id == projectId);
          projectInputs.title = project?.title;
          projectInputs.description = project?.description;
        }  
      } else {
        router.push('/login');
      }  

    })

</script>