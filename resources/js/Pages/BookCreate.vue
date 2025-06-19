<template>
  <BookForm :book="book" :categories="categories" />
</template>



<script setup>
import BookForm from '@/Components/BookForm.vue';
import { usePage } from '@inertiajs/vue3';

const book = usePage().props.book;
const categories = usePage().props.categories;
</script>

