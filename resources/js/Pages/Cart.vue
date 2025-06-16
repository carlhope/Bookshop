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
<script setup>
import { ref, computed, onMounted } from 'vue'

defineProps({
  book: Object
})

const cartBooks = ref([])

const loadCart = () => {
  cartBooks.value = JSON.parse(localStorage.getItem('cart')) || []
}

const updateCart = () => {
  localStorage.setItem('cart', JSON.stringify(cartBooks.value))
}

const increaseQuantity = (bookId) => {
  const book = cartBooks.value.find(b => b.id === bookId)
  if (book) book.quantity++
  updateCart()
}

const decreaseQuantity = (bookId) => {
  const index = cartBooks.value.findIndex(b => b.id === bookId)
  if (index !== -1) {
    if (cartBooks.value[index].quantity > 1) {
      cartBooks.value[index].quantity--
    } else {
      cartBooks.value.splice(index, 1)
    }
  }
  updateCart()
}

const totalPrice = computed(() =>
  cartBooks.value.reduce((sum, b) => sum + b.price * b.quantity, 0)
)

onMounted(() => {
  loadCart()
})
</script>
