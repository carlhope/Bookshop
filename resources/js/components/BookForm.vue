<template>
  <form @submit.prevent="submitForm" class="max-w-md mx-auto bg-gray-100 p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-center mb-4">
      {{ isEditing ? 'Edit Book' : 'Create a New Book' }}
    </h2>

    <div class="mb-4">
      <label class="block font-medium mb-1">Title:</label>
      <input
        type="text"
        v-model="form.title"
        @input="form.clearErrors('title')"
        required
        class="w-full p-2 border border-gray-300 rounded-md"
      />
      <p v-if="form.errors.title" class="text-red-600 mt-1">{{ form.errors.title }}</p>
    </div>

    <div class="mb-4">
      <label class="block font-medium mb-1">Author:</label>
      <input
        type="text"
        v-model="form.author"
        @input="form.clearErrors('author')"
        required
        class="w-full p-2 border border-gray-300 rounded-md"
      />
      <p v-if="form.errors.author" class="text-red-600 mt-1">{{ form.errors.author[0] }}</p>
    </div>

    <div class="mb-4">
      <label class="block font-medium mb-1">Published Year:</label>
      <input
        type="number"
        v-model="form.published_year"
        @input="form.clearErrors('published_year')"
        required
        min="1000"
        max="2099"
        class="w-full p-2 border border-gray-300 rounded-md"
      />
      <p v-if="form.errors.published_year" class="text-red-600 mt-1">{{ form.errors.published_year }}</p>
    </div>

    <div class="mb-4">
      <label class="block font-medium mb-1">Category:</label>
      <select
        v-model="form.category_id"
        @change="form.clearErrors('category_id')"
        required
        class="w-full p-2 border border-gray-300 rounded-md"
      >
        <option value="" disabled>Select a Category</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
      <p v-if="form.errors.category_id" class="text-red-600 mt-1">{{ form.errors.category_id }}</p>
    </div>

    <div class="mb-4">
      <label class="block font-medium mb-1">Description:</label>
      <textarea
        v-model="form.description"
        @input="form.clearErrors('description')"
        class="w-full p-2 border border-gray-300 rounded-md resize-none"
      ></textarea>
      <p v-if="form.errors.description" class="text-red-600 mt-1">{{ form.errors.description }}</p>
    </div>

    <div class="mb-4">
      <label class="block font-medium mb-1">Price:</label>
      <input
        type="number"
        v-model="form.price"
        step="0.01"
        @input="form.clearErrors('price')"
        class="w-full p-2 border border-gray-300 rounded-md"
      />
      <p v-if="form.errors.price" class="text-red-600 mt-1">{{ form.errors.price }}</p>
    </div>

    <div class="mb-4">
      <label class="block font-medium mb-1">Cover Image URL:</label>
      <input
        type="text"
        v-model="form.cover_image"
        @input="form.clearErrors('cover_image')"
        class="w-full p-2 border border-gray-300 rounded-md"
      />
      <p v-if="form.errors.cover_image" class="text-red-600 mt-1">{{ form.errors.cover_image }}</p>
    </div>

    <button
      type="submit"
      :disabled="form.processing"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md transition"
    >
      {{ isEditing ? 'Update' : 'Create' }} Book
    </button>

    <p
      v-if="form.recentlySuccessful && Object.keys(form.errors).length === 0"
      class="text-green-600 mt-4 text-center"
    >
      Book {{ isEditing ? 'updated' : 'created' }} successfully!
    </p>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  book: Object,
  categories: Array,
})

    const form = useForm({
      title: props.book?.title || '',
      author: props.book?.author || '',
      published_year: props.book?.published_year || '',
      category_id: props.book?.category_id || '',
      description: props.book?.description || '',
      price: props.book?.price || '',
      cover_image: props.book?.cover_image || '',
    });

    const isEditing = ref(!!props.book);

    const submitForm = () => {
      const url = isEditing.value ? `/books/${props.book.id}` : '/books';
      console.log('Submitting form to:', url);
      console.log('Form data:', form);
      console.log('Book ID:', props.book?.id);
      const method = isEditing.value ? 'put' : 'post';
      form[method](url, {
         preserveScroll: true
        });
    };
</script>