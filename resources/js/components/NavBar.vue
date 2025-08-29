<template>
    <nav class="flex items-center justify-between min-h-15 px-10 lg:px-20 relative">
      <!-- Hamburger for mobile -->
      <div 
        v-if='!isOpen'
        @click="isOpen = !isOpen" 
        type="button" 
        class="block 
        text-black items-center p-2 ml-3 w-12 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 
        dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 cursor-pointer" 
        aria-controls="navbar-sticky" 
        aria-expanded="false"
      >
        <span class="block border w-full h-1 bg-black my-1"></span>
        <span class="block border w-full h-1 bg-black my-1"></span>
        <span class="block border w-full h-1 bg-black my-1"></span>
      </div>
      
      <div v-if="isOpen"
        @click="isOpen = !isOpen"
        class="flex  items-center justify-center border p-2 font-light h-11 w-10 rounded-lg lg:hidden hover:bg-gray-100 
        dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 cursor-pointer"
        aria-controls="navbar-sticky"
        aria-expanded="false"
    >
        <span class="block w-5 h-1 bg-black absolute   rotate-40"></span>
        <span class="block w-5 h-1 bg-black absolutt  -rotate-40"></span>
    </div>

      <!-- Links -->
      <div :class="isOpen ? 'block absolute left-0 top-15 w-full h-[calc(100vh -20)] z-10 bg-gray-200' : 'hidden lg:block'">
        <ul :class="!isOpen ? '' : ''" 
            class="font-semibold text-white"
        >
           
          <li :class="isOpen ?'border-b hover:border-blue-500 hover:bg-blue-200' : '' ">
            <Router-link to="/Dashboard" class="block py-2 px-3 text-gray-500 rounded-sm hover:text-blue-500">
              Dashboard
            </Router-link>
          </li>
        </ul>
      </div>
      <!-- Sign In button -->
      <div v-if="!authStore.isAuthenticated">
        <button 
            type="button"
            @click="handleClick"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
            focus:ring-blue-300 font-medium rounded-md  text-sm px-4 py-2 cursor-pointer 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Sign In
        </button>
      </div>
      
  </nav>
</template>

<script setup>
    import { handleError, ref, watch } from 'vue';
    import { useRouter } from 'vue-router';
    import { useErrorStore } from '@/stores/errorStore';
    import { useAuthStore } from '@/stores/authStore';

    const errorStore = useErrorStore();
    const isOpen = ref(false);
    const router = useRouter();
    const windowWidth = ref(window.innerWidth);
    const authStore = useAuthStore();

    const handleClick = () => {
      errorStore.clearErrors();
      router.push('/login');
    }


    watch(() => windowWidth,
      () =>  {
        if (windowWidth > 650) {
          isOpen.value = false;
        }

        console.log(window.innerWidth);
      });

</script>