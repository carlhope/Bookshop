<template>
  <div class="max-w-4xl mx-auto bg-white shadow-md p-6 rounded-lg flex flex-col md:flex-row items-center gap-6">
    <!-- Book Image -->
    <div class="flex-1 flex justify-center">
      <img :src="book.cover_image" :alt="book.title" class="w-72 h-auto object-cover rounded">
    </div>

    <!-- Book Details -->
    <div class="flex-1 flex flex-col gap-y-4">
      <h2 class="text-3xl font-bold">{{ book.title }}</h2>
      <p class="text-gray-600 text-lg">Author: {{ book.author }}</p>
      <p class="text-gray-600">Published Year: {{ book.published_year }}</p>
      <p class="text-gray-600">Category: {{ book.category?.name ?? 'Uncategorized' }}</p>
      <p class="text-gray-600">Price: £{{ book.price }}</p>
      <p class="text-gray-700">{{ book.description }}</p>

      <!-- Cart Controls -->
      <div class="cart-controls">
        <button v-if="!inCart" @click="addToCart(book.id)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Add to Cart
        </button>
        <div v-else class="flex items-center space-x-2">
          <button @click="decreaseQuantity(book.id)" class="bg-red-500 text-white px-2 py-1 rounded">−</button>
          <span class="text-lg font-bold w-8 text-center">{{ cartQuantity }}</span>
          <button @click="increaseQuantity(book.id)" class="bg-blue-500 text-white px-2 py-1 rounded">+</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    book: Object
  },
  data() {
    return {
      cart: JSON.parse(localStorage.getItem('cart')) || {}
    };
  },
  computed: {
    inCart() {
      return !!this.cart[this.book.id];
    },
    cartQuantity() {
      return this.cart[this.book.id]?.quantity || 0;
    }
  },
  methods: {
    updateCart() {
      localStorage.setItem('cart', JSON.stringify(this.cart));
    },
    addToCart(bookId) {
      if (!this.cart[bookId]) {
        this.cart[bookId] = { quantity: 1 };
      }
      this.updateCart();
    },
    increaseQuantity(bookId) {
      if (this.cart[bookId]) {
        this.cart[bookId].quantity++;
        this.updateCart();
      }
    },
    decreaseQuantity(bookId) {
      if (this.cart[bookId]) {
        if (this.cart[bookId].quantity > 1) {
          this.cart[bookId].quantity--;
        } else {
          delete this.cart[bookId];
        }
        this.updateCart();
      }
    }
  }
};
</script>
