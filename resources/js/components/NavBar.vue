<template>
    <nav class="flex items-center justify-between min-h-15 px-10 relative">
      <!-- Hamburger for mobile -->
      <div 
        @click="isOpen = !isOpen" 
        type="button" 
        class="block 
        text-black items-center p-2 ml-3 w-12 text-sm text-gray-500 rounded-lg  hover:bg-gray-100 
        dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 cursor-pointer" 
        aria-controls="navbar-sticky" 
        aria-expanded="false"
      >
        <span class="block border w-full h-1 bg-black my-1"></span>
        <span class="block border w-full h-1 bg-black my-1"></span>
        <span class="block border w-full h-1 bg-black my-1"></span>
      </div>

      <!-- Links -->
      <div :class="isOpen ? 'block absolute left-0 top-15 w-full h-[calc(100vh -20)] z-10 bg-gray-200' : 'hidden'">
        <ul :class="!isOpen ? '' : ''" 
            class="font-semibold text-white"
        >
           
          <li class="border-b hover:border-blue-500 hover:bg-blue-200 ">
            <Router-link to="/Dashboard" class="block py-2 px-3 text-gray-500 rounded-sm ">
              Dashboard
            </Router-link>
          </li>
        </ul>
      </div>
      <!-- Sign In button -->
      <div>
        <button 
            type="button"
            @click="handleClick"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Sign In
        </button>
      </div>
      
  </nav>
</template>

<script setup>
    import { handleError, ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { useErrorStore } from '@/stores/errorStore';

    const errorStore = useErrorStore();
    const isOpen = ref(false);
    const router = useRouter();


    const handleClick = () => {
      errorStore.clearErrors();
      router.push('/login');
    }
</script>