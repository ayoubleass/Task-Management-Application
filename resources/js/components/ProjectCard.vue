<template>
  <div class=" p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-5">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
      {{ project?.title }}
    </h5>
    
    <div class="contaienr flex items-center  justify-between">
      <div class="mb-4 space-y-2 text-gray-600 dark:text-gray-300">
        <p><span class="font-semibold">Taches :</span> {{ project?.taches?.length|| 0 }}</p>
      </div>
  
      <!-- Actions -->
      <div class="flex space-x-3">
        <RouterLink
          :to="'/project-details/' + project.id"
          class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer"
        >
          Details
        </RouterLink>
        <button
          @click="updateProject(project)"
          class="px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 cursor-pointer"
        >
          Update
        </button>
        
  
      </div>

    </div>
  </div>
</template>

<script setup>
    import { RouterLink , useRouter} from 'vue-router';
    import { useErrorStore } from '@/stores/errorStore';
    const router = useRouter();
    const errorStore = useErrorStore();
    const actions = [
        'update',
        'delete'
    ];

    const props = defineProps({
        project: {
            type: Object,
            required: true
        }
    });

    const updateProject = (project) => {
      errorStore.clearErrors();
      router.push(`/project?id=${project.id}&action=${actions[0]}`);
    }

    const deleteProject = () => {
      router.push(`/project?id=${project.id}&action=${actions[1]}`);
    }

</script>