<template>
    <div class="relative inline-block group">
        <img 
            src="/logo.png" 
            alt="Howlson Logo" 
            class="transition-all duration-300 group-hover:opacity-0"
            v-bind="$attrs"
        />
        <img 
            src="/logo-hover.png" 
            alt="Howlson Logo Hover" 
            class="absolute inset-0 transition-all duration-300 opacity-0 group-hover:opacity-100"
            v-bind="$attrs"
        />
    </div>
</template>
