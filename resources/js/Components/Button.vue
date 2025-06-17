<template>
<button
    @click="handleClick"
    :class="['btn btn-primary btn-lg mt-4', buttonClass]"
    :disabled="buttonDisabled"
>
{{ buttonText }}
</button>
</template>
<script setup>
const props = defineProps({
    handleClick:Function,
    buttonText:String,
    buttonClass:String,
    buttonDisabled:Boolean
})
</script>
