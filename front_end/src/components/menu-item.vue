<template>
    <div
            class="menu-item"
            :name="keyName"
            @click="onClick()"
    >
        <div style="width: 20%;"></div>
        <img :src="imgSrc">
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
        props: [ 'imgSrc', 'title', 'keyName']
    }
</script>

<style scoped>

</style>