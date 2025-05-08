<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Register" />

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

    <!-- Right Side: Register Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-12 bg-gray-100">
      <div class="w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Register</h2>

        <form @submit.prevent="submit" class="space-y-4">
          <!-- Name -->
          <div>
            <InputLabel for="name" value="Name" />
            <TextInput
              id="name"
              type="text"
              placeholder="Your name"
              class="w-full rounded-md border-gray-300 focus:border-green-600 focus:ring focus:ring-green-200"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Email -->
          <div>
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              type="email"
              placeholder="you@example.com"
              class="w-full rounded-md border-gray-300 focus:border-green-600 focus:ring focus:ring-green-200"
              v-model="form.email"
              required
              autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <!-- Password -->
          <div>
            <InputLabel for="password" value="Password" />
            <TextInput
              id="password"
              type="password"
              placeholder="••••••••"
              class="w-full rounded-md border-gray-300 focus:border-green-600 focus:ring focus:ring-green-200"
              v-model="form.password"
              required
              autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <!-- Confirm Password -->
          <div>
            <InputLabel for="password_confirmation" value="Confirm Password" />
            <TextInput
              id="password_confirmation"
              type="password"
              placeholder="••••••••"
              class="w-full rounded-md border-gray-300 focus:border-green-600 focus:ring focus:ring-green-200"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </div>

          <!-- Submit -->
          <div class="flex items-center justify-between mt-4">
            <Link
              :href="route('login')"
              class="text-sm text-gray-600 underline hover:text-gray-900"
            >
              Already registered?
            </Link>

            <PrimaryButton
              class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Register
            </PrimaryButton>
          </div>
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
