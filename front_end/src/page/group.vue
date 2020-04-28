<template>
    <div class="container">
        <group-card isAdd="false" v-for="item in groups" :key="item.group_name" :group="item"></group-card>
        <group-card isAdd="true"></group-card>
    </div>
</template>

<script>
    import groupCard from "../components/groupCard";
    import { addGroup, getUserGroups } from "../api/getData";
    export default {
        name: "group",
        components: { groupCard },
        data() {
            return {
                groups: []
            };
        },
        mounted() {
            getUserGroups().then(res => {
                window.console.log(res);
                if (res.status === 0) {
                    this.groups = res.data.data;
                }
            });
        }
    };
</script>

<style lang="scss" scoped>
    .container {
        padding-top: 130px;
        padding-left: 54px;
        padding-right: 54px;
        display: flex;
        flex-wrap: wrap;
    }
</style>
