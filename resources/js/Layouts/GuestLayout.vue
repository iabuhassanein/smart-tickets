<template>
    <div class="guest-wrapper">
        <div class="guest-container">
            <div class="guest-header">
                <h1>Your App Name</h1>
            </div>
            <div class="guest-content">
                <slot />
            </div>
            <div class="guest-footer">
                <p>&copy; 2025 Your Company</p>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: "GuestLayout",
})
</script>

<style scoped>
.guest-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.guest-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    max-width: 400px;
    width: 100%;
}
</style>
