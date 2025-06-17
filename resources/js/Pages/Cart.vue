<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Your Cart</h2>

    <div v-if="Object.keys(page.props.cart).length" id="cart-container">
      <ul class="space-y-4">
        <li v-for="book in cartBooks" :key="book.id" class="cart-item bg-white shadow-md p-4 rounded-lg flex justify-between items-center">
          <div>
            <h3 class="text-lg font-bold">{{ book.title }}</h3>
            <p class="text-gray-600">Price: £{{ book.price }}</p>

            <div class="flex items-center space-x-2">
              <button class="bg-red-500 text-white px-2 py-1 rounded" @click="decreaseQuantity(book.book_id)">−</button>
              <span class="text-lg font-bold">{{ book.quantity }}</span>
              <button class="bg-blue-500 text-white px-2 py-1 rounded" @click="increaseQuantity(book.book_id)">+</button>
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
<script setup>
import { ref, computed, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

// Retrieve session cart via Inertia
const page = usePage()
const cartBooks = ref([])

// Convert Vue Proxy Object into a plain object for reactivity
const updateCart = () => {
  const cartData = JSON.parse(JSON.stringify(page.props.cart)) || {}
  cartBooks.value = Object.values(cartData) // Convert object to array
  console.log("Cart received from Inertia:", page.props.cart);
}

// Watch for cart changes in Laravel session
watch(() => page.props.cart, (newCart) => {
  const cartData = JSON.parse(JSON.stringify(newCart)) || {}
  cartBooks.value = Object.values(cartData) // Ensure Vue sees an array
}, { deep: true })


const updateQuantity = (bookId, newQty) => {
  const bookIndex = cartBooks.value.findIndex(b => b.book_id === bookId);
  if (bookIndex !== -1) {
    cartBooks.value[bookIndex].quantity = newQty; // ✅ Immediately update UI
  }

  router.post(`/cart/update/${bookId}`, { quantity: newQty }, {
    preserveScroll: true,
    onSuccess: () => {
      updateCart(); // ✅ Sync with Laravel after backend update
    }
  });
};

const increaseQuantity = (bookId) => {
  console.log("Increasing quantity for book:", bookId);
  const book = cartBooks.value.find(b => b.book_id === bookId)
  if (book) updateQuantity(bookId, book.quantity + 1)
}

const decreaseQuantity = (bookId) => {
  console.log("Decreasing quantity for book:", bookId);
  const book = cartBooks.value.find(b => b.book_id === bookId)
  if (book) {
    if (book.quantity > 1) {
      updateQuantity(bookId, book.quantity - 1)
    } else {
      router.post(`/cart/remove/${bookId}`, {}, {
        preserveScroll: true,
        onSuccess: () => {
          updateCart() // Ensure UI updates after removal
        }
      })
    }
  }
}

// Compute total price
const totalPrice = computed(() =>
  cartBooks.value.reduce((sum, b) => sum + b.price * b.quantity, 0)
)

// Initialize cart on mount
updateCart()
</script>