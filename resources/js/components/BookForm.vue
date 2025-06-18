<template>
  <form @submit.prevent="submitForm">
    <div>
      <label>Title:</label>
      <input type="text" v-model="form.title" required />
    </div>

    <div>
      <label>Author:</label>
      <input type="text" v-model="form.author" required />
    </div>

    <div>
      <label>Price:</label>
      <input type="number" v-model="form.price" required />
    </div>

    <button type="submit">{{ isEditing ? 'Update' : 'Create' }} Book</button>

    <p v-if="errors.length">
      <strong>Errors:</strong> {{ errors.join(', ') }}
    </p>
  </form>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';

export default {
  props: {
    book: Object, // Receives book data for editing or null for creation
  },
  setup(props) {
    // Initialize form with existing book or empty fields
    const form = useForm({
      title: props.book?.title || '',
      author: props.book?.author || '',
      price: props.book?.price || '',
    });

    const isEditing = ref(!!props.book); // Detect if editing
    const errors = ref([]);

    const submitForm = () => {
      const url = isEditing.value ? `/books/${props.book.id}` : '/books';
      const method = isEditing.value ? 'put' : 'post';

      form[method](url, {
        onError: (err) => (errors.value = Object.values(err)),
      });
    };

    return { form, submitForm, errors, isEditing };
  },
};
</script>