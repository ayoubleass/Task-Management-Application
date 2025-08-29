<template>
  <div class="w-full mb-5 lg:w-1/2 mx-auto">
    <div role="alert">
      <div
        :class="[
          'text-white font-bold rounded-t px-4 py-2',
          type === 'error' ? 'bg-red-500' : 'bg-green-500'
        ]"
      >
        {{ type === 'error' ? 'Error' : 'Success' }}
      </div>
  
      <div
        :class="[
          'border rounded-b px-4 py-3',
          type === 'error'
            ? 'border-red-400 bg-red-100 text-red-700'
            : 'border-green-400 bg-green-100 text-green-700'
        ]"
      >
        <p>{{ errorStore.errors?.message || errorStore?.flashMessage}}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
    import { computed, watch} from 'vue';
    import { useErrorStore } from '@/stores/errorStore';


    const errorStore = useErrorStore();
    const props = defineProps({
        message : {
            type : String,
        },
        type : {
            type : String,
        }
    });

</script>