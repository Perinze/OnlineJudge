<template>
    <div id="side-drawer" :style="marginRightStyleObject">
        <div class="close-btn" @click="close()">
            <img src="../../assets/icon/no.svg" width="15" height="15" alt="backward">
        </div>
        <problem-detail :pid="pid" :cid="cid" :key="'p='+pid+'&c='+cid"/>
    </div>
</template>

<script>
    import problemDetail from '../page/problemDetail';
    export default {
        name: "side-drawer",
        props: [ 'isDisplay', 'pid', 'cid' ],
        components: {
            problemDetail
        },
        data() {
            return {
                marginRightStyleObject: {
                    'margin-right': 0,
                    // right: 0
                }
            }
        },
        methods: {
            close() {
                this.$emit('close')
            }
        },
        watch: {
            isDisplay: function(val) {
                if(val===true) {
                    // open
                    this.marginRightStyleObject['margin-right'] = 0;
                }else{
                    // hide
                    let phantom = (this.$root.$el.clientWidth-200)/2;
                    this.marginRightStyleObject['margin-right'] = `-${phantom}px`;
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    #side-drawer {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: auto;
        width: calc((100% - 200px) / 2);
        background: white;
        z-index: 1001;
        border: {
            top-left-radius: .8em;
            bottom-left-radius: .8em;
        }
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        overflow-y: scroll;
        transition: margin-right 0.5s ease-in-out;
    }

    .close-btn {
        position: absolute;
        margin: 10px 0 0 15px;
        cursor: pointer;
        z-index: 1002;
    }
</style>