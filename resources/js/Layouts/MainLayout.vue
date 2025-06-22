<template>
    <div class="auth-wrapper">
        <header class="header">
            <h1>{{ appName }}</h1>
            <nav v-if="showNavigation">
                <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
                <router-link to="/tickets" class="nav-link">Tickets</router-link>
                <router-link v-if="showBackButton" to="/tickets" class="nav-link">Back</router-link>
            </nav>
        </header>
        <main class="main-content">
            <slot />
        </main>
        <footer class="footer">
            <p>&copy; {{ currentYear }} {{ appName }}</p>
        </footer>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: "MainLayout",
    props: {
        showNavigation: {
            type: Boolean,
            default: true
        },
        showBackButton: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            appName: 'Smart Tickets',
            currentYear: new Date().getFullYear()
        }
    }
})
</script>

<style scoped>
body {
    padding: 0;
    margin: 0;
}
.auth-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: #f8fafc;
}

.header {
    background: white;
    padding: 1rem 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    margin: 0;
    color: #2d3748;
}

.nav-link {
    margin-left: 1rem;
    color: #4a5568;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.nav-link:hover {
    background-color: #edf2f7;
}

.main-content {
    flex: 1;
    padding: 2rem;
}

.footer {
    background: white;
    padding: 1rem 2rem;
    text-align: center;
    border-top: 1px solid #e2e8f0;
}
</style>
