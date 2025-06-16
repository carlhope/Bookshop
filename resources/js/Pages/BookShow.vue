<template>
  <div class="max-w-4xl mx-auto bg-white shadow-md p-6 rounded-lg flex flex-col md:flex-row items-center gap-6">
    <!-- Book Image -->
    <div class="flex-1 flex justify-center">
      <img :src="book.cover_image" :alt="book.title" class="w-72 h-auto object-cover rounded" />
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
        <button
          v-if="!inCart"
          @click="addToCart"
          :disabled="processing"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:opacity-50"
        >
          Add to Cart
        </button>

        <div v-else class="flex items-center space-x-2">
          <button @click="decreaseQuantity" class="bg-red-500 text-white px-2 py-1 rounded">−</button>
          <span class="text-lg font-bold w-8 text-center">{{ cartQuantity }}</span>
          <button @click="increaseQuantity" class="bg-blue-500 text-white px-2 py-1 rounded">+</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const cart = computed(() => page.props.cart)
const cartCount = computed(() => page.props.cartCount)


const props = defineProps({
  book: Object
})

const processing = ref(false)

const inCart = computed(() => !!cart.value?.[props.book.id])
const cartQuantity = computed(() => cart.value?.[props.book.id]?.quantity || 0)

const addToCart = () => {
  if (processing.value) return
  processing.value = true

  router.post(`/cart/add/${props.book.id}`, {}, {
    preserveScroll: true,
    // ↓ Allow Inertia to refresh props so cartQuantity updates
    onFinish: () => {
      processing.value = false
    }
  })
}

const increaseQuantity = () => {
  try {
    const bookId = props.book.id
    const item = cart.value?.[bookId]
    const currentQty = item?.quantity ?? 0
    const newQty = currentQty + 1

    router.post(`/cart/update/${bookId}`, { quantity: newQty })
  } catch (err) {
    console.error('Error in increaseQuantity:', err)
  }
}

const decreaseQuantity = () => {
  try {
    const bookId = props.book.id
    const currentQty = cart.value?.[bookId]?.quantity
    const newQty = typeof currentQty === 'number' ? currentQty - 1 : 0

    if (newQty > 0) {
      router.post(`/cart/update/${bookId}`, { quantity: newQty })
    } else {
      router.post(`/cart/remove/${bookId}`)
    }
  } catch (err) {
    console.error('Error in decreaseQuantity:', err)
  }
}

</script>
