<template>
    <div class="px-3 py-5  bg-white rounded-xl shadow-md  lg:w-1/3  md:w-1/2 w-full">
    

      <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-blue-500">
            {{ title }}
        </h2>
      </div>
      <!-- Login Form -->
     <form class="space-y-4 lg:px-2 text-sm" @submit.prevent="handleSubmit">
        <div class="flex h-10 gap-10 ">
            <div class="border-b h-full border-blue-100 focus-within:border-blue-500 transition-colors duration-200 w-1/2">
                <input
                    type="text"
                    :placeholder="Array.isArray(errorStore.errors?.title) ?  errorStore.errors?.title[0] : 'Task title'"
                    :class="['w-full p-2 outline-none text-gray-700 ', Array.isArray(errorStore.errors?.title) ?'placeholder-red-500' : 'placeholder-gray-400' ]"
                    v-model="tacheInput.title"
                />
    
            </div>
            <div  class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200 w-1/2 relative">
                <select v-model="tacheInput.selectedState" class="w-full absolute bottom-0 h-full">
                    <option v-for="state in status" :value="state">
                        {{ state }}
                    </option>
                </select>
            </div>
        </div>
        <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200 relative h-10">
            <select v-model="tacheInput.selectedPriority" class="w-full absolute bottom-0 h-full">
                <option v-for="priority in priorities" :value="priority">
                    {{ priority }}
                </option>
            </select>
        </div>
         <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200 ">
            <input
                type="text"
                placeholder="Assign to"
                class="w-full p-2 outline-none text-gray-700 placeholder-gray-400"
                v-model="tacheInput.assign_to"
            />
        
            <div v-if="Array.isArray(errorStore.errors?.assign_to)" class="text-red-500">
                {{ errorStore.errors?.assign_to[0] }}
            </div>
    
        </div>
        <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200">
          <textarea
            :placeholder="Array.isArray(errorStore.errors?.description) ?  errorStore.errors?.description[0] : 'Task description'"
            rows="4"
            :class="['w-full p-2 outline-none text-gray-700 placeholder-gray-400', Array.isArray(errorStore.errors?.description) ?'placeholder-red-500' : 'placeholder-gray-400']"
            v-model="tacheInput.description"
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
</template>

<script setup>
    import { onBeforeMount, reactive, ref} from 'vue';
    import { useErrorStore } from '@/stores/errorStore.js';    
    import { useTaskStore } from '@/stores/tskStore.js';
    import { useProjectStore } from '@/stores/projectStore';

    const errorStore = useErrorStore();
    const taskStore = useTaskStore();
    const projectStore = useProjectStore();

    const status = [
        'todo',
        'in_progress',
        'done'
    ];
    const priorities = [
        'low',
        'medium',
        'high'
    ];

    const props = defineProps({
        projectId : {
            type : String,
        },
        tacheId : {
            type: Number,
        },
        title : {
            type: String,
        },
        action : {
            type: String,
        }
    });

    const tacheInput = reactive({
        title: '',
        description : '',
        assign_to : '',
        selectedPriority : priorities[0],
        selectedState: status[0]
    });

    onBeforeMount(() => {
        errorStore.clearErrors();
        errorStore.clearFlashMessage();
        if (props.action === 'update') {
            const project = projectStore.projects.find((p) => p.id == props.projectId);
            const tache = project.taches.find((t) => t.id == props.tacheId);
            if (tache) {
                Object.keys(tache).forEach(key => {
                    tacheInput[key] = tache[key];
                });
            }
        }
    });


    const handleSubmit = async () => {
        if (props.action !== 'update') {
            await taskStore.createTask(
                `http://127.0.0.1:8000/api/projects/${props.projectId}/tasks`,
                tacheInput
            );
        } else {
            await taskStore.updateTask(
                `http://127.0.0.1:8000/api/tasks/${props.tacheId}`,
                tacheInput
            );
        }

    }
</script>