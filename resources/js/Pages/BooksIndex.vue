<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">All Books</h1>

    <div v-if="books && books.length"> <!-- ✅ Corrected -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <BookCard
          v-for="book in books"
          :key="book.id + cartVersion"
          :book="book"
          :cartItem="getCartItem(book.id).value"
          @add-to-cart="addToCart"
          @increase-quantity="increaseQuantity"
          @decrease-quantity="decreaseQuantity"
        />
      </div>
    </div>

    <p v-else class="text-gray-500 text-lg">Loading books...</p>
  </div>
</template>

<script setup>
import { ref, computed, watch, nextTick } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import BookCard from '../components/BookCard.vue' // Ensure this import is correct

// Fetch data from Laravel session via Inertia
const page = usePage()
const books = computed(() => page.props.books || [])
const cart = ref({})
const cartVersion = ref(0) // Used to force re-renders

// Computed function to ensure cart updates properly
const getCartItem = (bookId) => computed(() => {
  return cart.value[bookId] ? { ...cart.value[bookId] } : null;
});

// Convert Vue Proxy Object into a plain object for reactivity
const updateCart = () => {
  const cartData = JSON.parse(JSON.stringify(page.props.cart)) || {}
  cart.value = {} // Reset the object first

  nextTick(() => {
    cart.value = { ...cartData } // Assign new data after Vue processes
    cartVersion.value += 1 // Force Vue to recognize updates
    console.log("Updated cart state:", cart.value) // Debugging check
  })
}

// Watch for cart updates from Laravel
watch(() => page.props.cart, (newCart) => {
  console.log("Cart updated from Laravel:", newCart)
  updateCart()
}, { deep: true })

const addToCart = (bookId) => {
  router.post(`/cart/add/${bookId}`, {}, {
    preserveScroll: true,
    onSuccess: ({ props }) => {
      console.log("Cart response from Laravel:", props.cart);

      // ✅ Force Vue reactivity by replacing the entire cart object
      cart.value = JSON.parse(JSON.stringify(props.cart)); 
      cartVersion.value += 1; // Trigger component refresh
    }
  });
};

const increaseQuantity = (bookId) => {
  if (cart.value[bookId]) {
    cart.value[bookId].quantity++; // Update UI before waiting on server response
    router.post(`/cart/update/${bookId}`, { quantity: cart.value[bookId].quantity }, {
      preserveScroll: true,
      onSuccess: updateCart
    })
  }
}

const decreaseQuantity = (bookId) => {
  if (cart.value[bookId]?.quantity > 1) {
    cart.value[bookId].quantity--; // Update UI immediately
    router.post(`/cart/update/${bookId}`, { quantity: cart.value[bookId].quantity }, {
      preserveScroll: true,
      onSuccess: updateCart
    })
  } else {
    delete cart.value[bookId] // Remove item locally for immediate UI change
    router.post(`/cart/remove/${bookId}`, {}, {
      preserveScroll: true,
      onSuccess: updateCart
    })
  }
}

// Initialize cart state on mount
updateCart()
</script>