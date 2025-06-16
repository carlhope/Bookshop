<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">All Books</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <BookCard
        v-for="book in books"
        :key="book.id"
        :book="book"
        :inCart="cart[book.id] !== undefined"
        :cartQuantity="cart[book.id] ? cart[book.id].quantity : 0"
        @add-to-cart="addToCart"
        @increase-quantity="increaseQuantity"
        @decrease-quantity="decreaseQuantity"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import BookCard from '../components/BookCard.vue'

const books = ref([])
const cart = ref({})

const fetchBooks = async () => {
  const response = await axios.get('/api/books')
  books.value = response.data
  cart.value = JSON.parse(localStorage.getItem('cart')) || {}
}

const addToCart = (bookId) => {
  if (!cart.value[bookId]) {
    cart.value[bookId] = { quantity: 1 }
  }
  updateCartStorage()
}

const increaseQuantity = (bookId) => {
  if (cart.value[bookId]) {
    cart.value[bookId].quantity++
    updateCartStorage()
  }
}

const decreaseQuantity = (bookId) => {
  if (cart.value[bookId]) {
    if (cart.value[bookId].quantity > 1) {
      cart.value[bookId].quantity--
    } else {
      delete cart.value[bookId]
    }
    updateCartStorage()
  }
}

const updateCartStorage = () => {
  localStorage.setItem('cart', JSON.stringify(cart.value))
}

onMounted(fetchBooks)
</script>