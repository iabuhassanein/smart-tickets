import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../Pages/Dashboard.vue';
import TicketsList from "../Pages/Tickets/TicketsList.vue";
import ViewTicket from "../Pages/Tickets/ViewTicket.vue";
import { isAuthorized, isGuest } from "../utils/auth.js";

const routes = [
    {
        path: '/',
        name: 'index',
        component: Dashboard,
        beforeEnter: [isAuthorized]
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        beforeEnter: [isAuthorized]
    },
    {
        path: '/tickets',
        name: 'tickets',
        component: TicketsList,
        beforeEnter: [isAuthorized]
    },
    {
        path: '/ticket/:id',
        name: 'ticket.view',
        component: ViewTicket,
        beforeEnter: [isAuthorized]
    }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
