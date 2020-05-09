<template>
    <div class="pagination" v-if="total - pageSize > 0 && total - 0 > 0">
        <div class="pagination-btn-start pagination-block" @click="fetchStart">
            <img src="../../assets/media/arrow-start.png" />
        </div>
        <div class="pagination-btn-prev pagination-block" @click="fetchPrev">
            <img src="../../assets/media/arrow-prev.png" />
        </div>
        <div
                :class="['pagination-block', 1 == index ? 'pagination-block-active' : '']"
                @click="fetchIndex(1)"
        >1</div>
        <div class="pagination-block" style="cursor: auto" v-if="isShowPrevMore">···</div>
        <div
                :class="['pagination-block', item == index ? 'pagination-block-active' : '']"
                v-for="item in blockArr"
                :key="item"
                @click="fetchIndex(item)"
        >{{item}}</div>
        <div class="pagination-block" style="cursor: auto" v-if="isShowNextMore">···</div>
        <div
                :class="['pagination-block', pageNum.length == index ? 'pagination-block-active' : '']"
                @click="fetchIndex(pageNum.length)"
        >{{pageNum.length}}</div>
        <div class="pagination-btn-next pagination-block" @click="fetchNext">
            <img src="../../assets/media/arrow-next.png" />
        </div>
        <div class="pagination-btn-end pagination-block" @click="fetchEnd">
            <img src="../../assets/media/arrow-end.png" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "pagination",
        props: ["total", "pageSize", "pageCount", "fetchData"],
        data() {
            return {
                index: 1
            };
        },
        computed: {
            pageNum: function() {
                let arr = [],
                    pages = Math.ceil(this.total / this.pageSize);
                for (let i = 1; i <= pages; i++) {
                    arr.push(i);
                }
                return arr;
            },
            blockArr: function() {
                let pageCount = this.pageCount - 0,
                    pageNum = JSON.parse(JSON.stringify(this.pageNum)),
                    index = this.index;
                if (pageNum.length === 2) return [];
                if (pageNum.length <= pageCount)
                    return pageNum.slice(1, pageNum.length - 1);
                if (index - 1 < pageCount / 2) return pageNum.slice(1, pageCount - 1);
                if (pageNum.length - index <= pageCount / 2)
                    return pageNum.slice(
                        pageNum.length - pageCount + 1,
                        pageNum.length - 1
                    );
                return pageCount % 2 === 0
                    ? pageNum.slice(
                        index - (pageCount - 2) / 2,
                        index + (pageCount - 2) / 2
                    )
                    : pageNum.slice(
                        index - Math.ceil((pageCount - 2) / 2),
                        index + Math.floor((pageCount - 2) / 2)
                    );
            },
            isShowPrevMore: function() {
                return this.pageNum.length - this.pageCount > 0 &&
                this.index - 1 >= this.pageCount / 2
                    ? true
                    : false;
            },
            isShowNextMore: function() {
                return this.pageNum.length - this.pageCount > 0 &&
                this.pageNum.length - this.index > this.pageCount / 2
                    ? true
                    : false;
            }
        },
        methods: {
            fetchStart: function() {
                if (this.index === 1) return;
                this.fetchData(1);
                this.index = 1;
            },
            fetchPrev: function() {
                if (this.index === 1) return;
                this.fetchData(this.index - 1);
                this.index = this.index - 1;
            },
            fetchNext: function() {
                if (this.pageNum.length === this.index) return;
                this.fetchData(this.index + 1);
                this.index = this.index + 1;
            },
            fetchEnd: function() {
                if (this.pageNum.length === this.index) return;
                this.fetchData(this.pageNum.length);
                this.index = this.pageNum.length;
            },
            fetchIndex: function(index) {
                this.fetchData(index);
                this.index = index;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .pagination {
        width: 100%;
        margin-top: 26px;
        margin-bottom: 12px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    .pagination-block {
        width: 35px;
        height: 35px;
        margin: 0 15px;
        background: rgba(238, 238, 238, 1);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 13px;
        font-weight: 400;
        color: rgba(160, 160, 160, 1);
        cursor: pointer;
        flex-shrink: 0;
    }
    .pagination-block:first-of-type {
        margin-left: 0;
    }
    .pagination-block:last-of-type {
        margin-right: 0;
    }
    .pagination-block-active {
        background: rgba(66, 136, 206, 1);
        color: rgba(255, 255, 255, 1);
    }
    .pagination-btn-start > img,
    .pagination-btn-end > img {
        width: 13px;
        height: 13px;
    }
    .pagination-btn-prev > img,
    .pagination-btn-next > img {
        width: 7.5px;
        height: 13px;
    }
    .more {
        cursor: auto;
    }
</style>
