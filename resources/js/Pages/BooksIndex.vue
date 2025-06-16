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

<script>
import axios from 'axios';
import BookCard from '../components/BookCard.vue';

export default {
  components: { BookCard },
  data() {
    return {
      books: [],
      cart: {}
    };
  },
  async created() {
    const response = await axios.get('api/books');
    this.books = response.data;
    this.cart = JSON.parse(localStorage.getItem('cart')) || {};
  },
  methods: {
    addToCart(bookId) {
      if (!this.cart[bookId]) {
        this.cart[bookId] = { quantity: 1 };
      }
      localStorage.setItem('cart', JSON.stringify(this.cart));
    },
    increaseQuantity(bookId) {
      if (this.cart[bookId]) {
        this.cart[bookId].quantity++;
        localStorage.setItem('cart', JSON.stringify(this.cart));
      }
    },
    decreaseQuantity(bookId) {
      if (this.cart[bookId] && this.cart[bookId].quantity > 1) {
        this.cart[bookId].quantity--;
      } else {
        delete this.cart[bookId];
      }
      localStorage.setItem('cart', JSON.stringify(this.cart));
    }
  }
};
</script>