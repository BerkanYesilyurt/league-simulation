import { createRouter, createWebHistory } from 'vue-router';
import Homepage from '../../views/Vue/Homepage.vue';
import FixtureList from '../../views/Vue/FixtureList.vue';
import Simulation from "../../views/Vue/Simulation.vue";

const routes = [
    { path: '/', component: Homepage },
    { path: '/fixture', component: FixtureList },
    { path: '/simulation', component: Simulation },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
