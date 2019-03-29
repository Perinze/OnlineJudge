<template>
    <div
            class="menu-item"
            :name="keyName"
            @click="onClick()"
            :class="{'menu-item-active': selected}"
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
        props: [ 'imgSrc', 'title', 'keyName'],
        methods: {
            onClick() {
                if(this.disable)return;
                this.$emit('menuItemUpdate',this.name);
                this.selected = true;
            }
        }
    }
</script>

<style scoped>

</style>