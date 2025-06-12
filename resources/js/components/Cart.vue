<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Your Cart</h2>

    <div v-if="cartBooks.length" id="cart-container">
      <ul class="space-y-4">
        <li v-for="book in cartBooks" :key="book.id" class="cart-item bg-white shadow-md p-4 rounded-lg flex justify-between items-center">
          <div>
            <h3 class="text-lg font-bold">{{ book.title }}</h3>
            <p class="text-gray-600">Price: £{{ book.price }}</p>

            <div class="flex items-center space-x-2">
              <button class="bg-red-500 text-white px-2 py-1 rounded" @click="decreaseQuantity(book.id)">−</button>
              <span class="text-lg font-bold">{{ book.quantity }}</span>
              <button class="bg-blue-500 text-white px-2 py-1 rounded" @click="increaseQuantity(book.id)">+</button>
            </div>
          </div>
        </li>
      </ul>
      <div class="cart-summary mt-4">
        <strong>Total Price: £{{ totalPrice.toFixed(2) }}</strong>
      </div>
    </div>
    <p v-else class="text-gray-500">Your cart is empty.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cartBooks: []
    };
  },
  computed: {
    totalPrice() {
      return this.cartBooks.reduce((total, book) => total + book.price * book.quantity, 0);
    }
  },
  created() {
    this.loadCart();
  },
  methods: {
    loadCart() {
      this.cartBooks = JSON.parse(localStorage.getItem('cart')) || [];
    },
    updateCart() {
      localStorage.setItem('cart', JSON.stringify(this.cartBooks));
    },
    increaseQuantity(bookId) {
      const book = this.cartBooks.find(b => b.id === bookId);
      if (book) book.quantity++;
      this.updateCart();
    },
    decreaseQuantity(bookId) {
      const bookIndex = this.cartBooks.findIndex(b => b.id === bookId);
      if (bookIndex !== -1) {
        if (this.cartBooks[bookIndex].quantity > 1) {
          this.cartBooks[bookIndex].quantity--;
        } else {
          this.cartBooks.splice(bookIndex, 1); // Remove book if quantity reaches zero
        }
      }
      this.updateCart();
    }
  }
};
</script>
