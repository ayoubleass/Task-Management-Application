<template>
  <div
    class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 my-5"
  >
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
      {{ tache?.title }}
    </h5>

    <div class="container p-10">
      <div class="mb-4 space-y-2 text-gray-600 dark:text-gray-300">
        <p><span class="font-semibold">Description:</span> {{ tache?.description }}</p>
        <p><span class="font-semibold">Assigné à:</span> {{ tache?.assign_to }}</p>
        <p><span class="font-semibold">Statut:</span> {{ tache?.status }}</p>
        <p><span class="font-semibold">Priorité:</span> {{ tache?.priority }}</p>
        <p><span class="font-semibold">Créé le:</span> {{ formatDate(tache?.created_at) }}</p>
        <p><span class="font-semibold">Mis à jour le:</span> {{ formatDate(tache?.updated_at) }}</p>
      </div>

      <!-- Actions -->
      <div class="flex space-x-3">

        <button
         @click="updateTask(tache)"
         class="px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 cursor-pointer"
       >
         Update
       </button>

       <button
        @click="deleteTask(tache)"
        class="px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 cursor-pointer"
      >
        Delete
      </button>

       <button
        class="px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 cursor-pointer"
      >
        change statuts
      </button>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { useRouter } from 'vue-router';
  import { useTaskStore } from '@/stores/tskStore';
  
  const baseUrl = import.meta.env.VITE_API_BASE_URL;
  const router = useRouter();
  const taskStore = useTaskStore();

  const props = defineProps({
    tache: {
      type: Object,
      required: true,
    },
  })


  const formatDate = (date) => {
    if (!date) return ''
    return new Date(date).toLocaleString('fr-FR', {
      dateStyle: 'short',
      timeStyle: 'short',
    })
  }


  const updateTask = (task) => {
    router.push(`/project/${task.project_id}/task?id=${task.id}&action=update`);
  }

  const deleteTask = async () => {
    await taskStore.deleteTask(`${baseUrl}/tasks/${props.tache.id}`);
  }


</script>
