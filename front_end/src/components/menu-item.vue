<template>
    <div
            :name="keyName"
            @click="onClick()"
    >
        <div style="width: 40px;"></div>
        <img class="icon" :src="imgSrc" width="18px" height="19px" :class="{'icon-active': isActive}">
        <div style="width: 20px;"></div>
        <span>{{ title }}</span>
    </div>
</template>

<script>
    export default {
        name: "menu-item",
        data() {
            return {
                selected: false
            }
        },
        props: [ 'imgSrc', 'title', 'keyName', 'isActive' ]
    }
</script>

<style scoped>
    .icon-active{
        filter: invert(1) sepia(1) saturate(3) hue-rotate(175deg);
    }
</style>