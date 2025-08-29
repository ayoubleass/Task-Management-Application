<template>
  <div class="min-h-screen w-full bg-gray-100 flex flex-col items-center justify-center px-10 md:px-5">
    <template v-if="errorStore.errors?.message || errorStore?.flashMessage">
      <FlashMessage :message="errorStore.errors.message" :type="'error'"/>
    </template>
    <div class="px-3 py-5  bg-white rounded-xl shadow-md  lg:w-1/4  md:w-1/2 w-full">
    

      <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-blue-500">
            {{ title }}
        </h2>
      </div>
      <!-- Login Form -->
      <form class="space-y-4 lg:px-2 text-sm" @submit.prevent="handleSubmit">
        <div
            class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200"
            v-show="$route.fullPath == '/register'"
        >
            
          <input
            type="text"
            placeholder="Name"
            class="w-full p-2 outline-none text-gray-700 placeholder-gray-400 "
            v-model="userInputs.name"
            autocomplete="username"
          />
            <div v-if="Array.isArray(errorStore.errors?.name)" class="text-red-500">
              {{ errorStore.errors?.name[0] }}
            </div>
        </div>

        <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200 relative">
           
          <input
            type="email"
            placeholder="Email"
            class="w-full p-2 outline-none text-gray-700 placeholder-gray-400"
            v-model="userInputs.email"
          />
           <div  v-if="Array.isArray(errorStore.errors?.email)" class="text-red-500">
             {{ errorStore.errors?.email[0]}}
            </div>
        </div>

        <div class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200">
          <input
            type="password"
            placeholder="Password"
            class="w-full p-2 outline-none text-gray-700 placeholder-gray-400"
            v-model="userInputs.password"
            autocomplete="new-password"
          />
            <div v-if="Array.isArray(errorStore.errors?.password)" class="text-red-500">
             {{ errorStore.errors?.password[0]}}
            </div>
        </div>

        <div
            class="border-b border-blue-100 focus-within:border-blue-500 transition-colors duration-200" 
            v-show="$route.fullPath == '/register'"
        >
          <input
            type="password"
            placeholder="Password confirmation"
            class="w-full p-2 outline-none text-gray-700 placeholder-gray-400"
            v-model="userInputs.password_confirmation"
          />
          <div v-if="Array.isArray(errorStore.errors?.password_confirmation)" class="text-red-500">
             {{ errorStore.errors?.password_confirmation[0]}}
          </div>
        </div>

        <button
          type="submit"
          class="w-full py-2 mt-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition-colors duration-200 cursor-pointer"
        >
          {{ action}}
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-500">
        <RouterLink :to="link" class="text-blue-500 hover:underline font-bold">{{ linkText }}</RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup>
    import { computed, watch, reactive, watchEffect, onBeforeMount } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import {useAuthStore} from '@/stores/authStore.js';
    import { useErrorStore } from '@/stores/errorStore';
    import FlashMessage from '@/components/FlashMessage.vue';


    const authStore = useAuthStore();
    const route = useRoute();
    const router = useRouter();
    const errorStore = useErrorStore();
    const fromTitle = {
        login : "Welcome back!",
        register : "Create your account",
    } 

    const link = computed(() => route.fullPath === '/login' ? '/register' : '/login');

    const linkText = computed(() => {
        return route.fullPath === '/login' ?
        'Sign up'
        : 'Sign In'
    });

    const title = computed(() => 
      route.fullPath === '/login' 
        ? fromTitle.login
        : fromTitle.register
    );

    const action = computed(() => 
      route.fullPath === '/login' 
        ? 'Login'
        : 'Register'
    );

    const userInputs = reactive({
        name : '',
        email : '',
        password : '',
        password_confirmation : '',
    });

    watch(
      () => authStore.token,
      () => {
        if (authStore.isAuthenticated !== null) {
          router.push('/dashboard');
        }
      }
    );

    watch(
      () => route.fullPath,
      () => {
        errorStore.clearErrors();
        Object.assign(userInputs, {
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
        });
      }
    );

    watch(() => errorStore.errors.message,
      () => setTimeout(() => errorStore.clearErrors(), '2000')
    );
        

    async function handleSubmit() {
        errorStore.clearErrors();
        if (route.fullPath === '/login') {
            await authStore.login('http://127.0.0.1:8000/api/login', userInputs);
        }else{
            await authStore.register('http://127.0.0.1:8000/api/register', userInputs);
        }
        
    }

    onBeforeMount(() => {
      if (authStore.isAuthenticated) {
        router.push('/Dashboard');  
      }
    })


</script>