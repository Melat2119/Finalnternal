<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Log in" />

  <div class="flex min-h-screen bg-white">
    <!-- Left Side: Image & Logo -->
    <div
      class="hidden md:flex md:w-1/2 relative bg-cover bg-center"
      style="background-image: url('/assets/register.jpg');"
    >
      <div class="absolute top-[40%] left-[60%] transform -translate-x-1/4 -translate-y-1/2 z-10">
        <img
          src="/assets/image.png"
          alt="Omishtu Joy Logo"
          class="max-w-[120px]"
        />
      </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-12 bg-gray-100">
      <div class="w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Login</h2>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
          {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
          <!-- Email -->
          <div>
            <TextInput
              id="email"
              type="email"
              placeholder="Email"
              class="w-full rounded-md border-gray-300 focus:border-green-600 focus:ring focus:ring-green-200"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <!-- Password -->
          <div>
            <TextInput
              id="password"
              type="password"
              placeholder="Password"
              class="w-full rounded-md border-gray-300 focus:border-green-600 focus:ring focus:ring-green-200"
              v-model="form.password"
              required
              autocomplete="current-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <!-- Remember & Forgot -->
          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center space-x-2">
              <Checkbox name="remember" v-model:checked="form.remember" />
              <span class="text-gray-600">Remember me</span>
            </label>

            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-gray-600 hover:text-green-600 underline"
            >
              Forgot password?
            </Link>
          </div>

          <!-- Submit -->
          <PrimaryButton
            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-md"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Log in
          </PrimaryButton>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
img {
  max-height: 240px;
  object-fit: contain;
}
</style>
