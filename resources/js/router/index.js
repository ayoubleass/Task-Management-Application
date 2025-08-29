import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/pages/Login.vue';
import Dashboard from '@/pages/Dashboard.vue';
import Project from '@/pages/Project.vue';
import Detailprojet from '@/pages/Detailprojet.vue';
import Tache from'@/pages/Tache.vue';
import Home from '@/pages/Home.vue';

const routes = [
    {path: '/', component: Home},
    {path: '/Login' , component: Login},
    {path:'/register', component: Login},
    {path:'/dashboard', component: Dashboard},
    {path: '/project' , component: Project},
    {path: '/project-details/:id', component : Detailprojet},
    {path: '/project/:id/task', component : Tache}
];


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes,
})

export default router
