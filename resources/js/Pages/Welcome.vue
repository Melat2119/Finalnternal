<template>
  <div
    class="min-h-screen bg-gradient-to-br from-white to-gray-100 flex items-center justify-center px-6"
    style="background-image: url('/assets/register.Jpg'); background-size: cover; background-position: center;"
  >
    <div class="max-w-6xl w-full flex flex-col md:flex-row items-center gap-12">
      <!-- Left: Mascot / Image (optional, since now it's the background) -->
      <div class="w-full md:w-1/2 flex justify-center">
        <!-- You can remove this part since the background image is set on the main div -->
      </div>

      <!-- Right: Text and Actions -->
      <div class="w-full md:w-1/2 ml-52 mr-0 mt-0 mb-30 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 leading-tight">
          Welcome to<br />
          <span class="text-green-400">Our Family</span>
        </h1>
        <p class="mt-4 text-lg text-gray-600">
          Join one of our awesome communities and explore knowledge together!
        </p>

        <!-- Action Buttons -->
        <div class="mt-6 ml-4 flex justify-center md:justify-start gap-4">
          <Link
            :href="route('register')"
            class="bg-green-500 hover:bg-green-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition"
          >
            Register
          </Link>
          <Link
            :href="route('login')"
            class="border border-green-400 text-green-400 hover:bg-green-100 font-semibold py-2 px-6 rounded-lg transition"
          >
            Login
          </Link>
        </div>

       
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
