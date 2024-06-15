<template>
  <nav class="flex items-center justify-between px-4 py-2">
    <div>
      <!-- Your application logo or brand name -->
      <router-link to="/">
        <img src="/logo.png" alt="Logo" />
      </router-link>
    </div>

    <div class="flex items-center">
      <ul class="flex items-center space-x-4">
        <!-- Navigation links -->
        <li>
          <router-link to="/about">About</router-link>
        </li>
        <li>
          <router-link to="/contact">Contact</router-link>
        </li>
      </ul>

      <div v-if="isLoggedIn" class="flex items-center space-x-4">
        <!-- User profile and logout link -->
        <div class="relative">
          <button @click="toggleDropdown" class="flex items-center space-x-2">
            <img :src="user.profileImage" alt="Profile" class="w-8 h-8 rounded-full" />
            <span>{{ user.name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 1.414 0l6.363-6.364a1 1 0 0 1-1.414 1.414l-4.95 4.95a1 1 0 0 1-1.414 0l-4.95-4.95a1 1 0 0 1 1.414-1.414z" />
            </svg>
          </button>

          <div v-show="isDropdownOpen" class="absolute right-0 top-10 w-48 bg-white rounded-md shadow-md p-2">
            <ul class="space-y-2">
              <li>
                <router-link to="/profile">Profile</router-link>
              </li>
              <li>
                <button @click="logout">Logout</button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div v-else class="flex items-center space-x-4">
        <!-- Login and registration links -->
        <router-link to="/login" class="text-blue-500 hover:text-blue-700">Login</router-link>
        <router-link to="/register" class="text-blue-500 hover:text-blue-700">Register</router-link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

// Replace with your actual user data
const user = {
  name: 'John Doe',
  profileImage: '/profile-image.jpg',
};

const isLoggedIn = ref(true); // Replace with your actual login status

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const logout = () => {
  // Replace with your actual logout logic
  isLoggedIn.value = false;
};
</script>

<style scoped>
/* Add any custom styles for the navigation component */
</style>
