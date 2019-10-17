<template>
    <textarea
            ref="mycode"
            class="codesql"
            v-model="code"
            style="height:100%;width:100%;"
    ></textarea>
</template>

<script>
    import "codemirror/theme/material.css";
    import "codemirror/lib/codemirror.css";
    import 'codemirror/mode/python/python';
    import 'codemirror/mode/clike/clike';

    let CodeMirror = require("codemirror/lib/codemirror");
    require("codemirror/addon/edit/matchbrackets");
    require("codemirror/addon/selection/active-line");
    export default {
        name: "codemirror",
        data () {
            return {
                // 按Ctrl键进行代码提示
                code: ''
            }
        },
        mounted () {
            let mime = "text/clike";

            let editor = CodeMirror.fromTextArea(this.$refs.mycode, {
                mode: mime,//选择对应代码编辑器的语言，我这边选的是数据库，根据个人情况自行设置即可
                indentWithTabs: true,
                smartIndent: true,
                lineNumbers: true,
                matchBrackets: true,
                theme: 'material',
            });
            //代码自动提示功能，记住使用cursorActivity事件不要使用change事件，这是一个坑，那样页面直接会卡死
            editor.on('cursorActivity', function () {
                // editor.showHint()
            })
        }
    }
</script>

<style lang="scss" scoped>
    .codesql {
        font-size: 11pt;
        font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
    }
</style>