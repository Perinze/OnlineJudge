<template>
    <!--<div>-->
        <codemirror
                ref="mycode"
                class="-codeMirrorEditor"
                v-model="code"
                :options="cmOptions"
        >
        </codemirror>
    <!--</div>-->
</template>

<script>
    import { codemirror } from 'vue-codemirror-lite';
    import 'codemirror/lib/codemirror.css';
    require('codemirror/mode/clike/clike.js');
    require("codemirror/mode/python/python.js");
    require("codemirror/addon/edit/matchbrackets.js");
    require("codemirror/addon/selection/active-line");
    require("codemirror/theme/material.css");
    // require("codemirror/addon/lint/lint.css");
    // require('codemirror/addon/fold/foldcode.js');
    // require('codemirror/addon/fold/foldgutter.js');
    // require("codemirror/addon/fold/foldgutter.css");
    // require('codemirror/addon/fold/brace-fold.js');
    // require('codemirror/addon/fold/xml-fold.js');
    // require('codemirror/addon/fold/indent-fold.js');
    // require('codemirror/addon/fold/markdown-fold.js');
    // require('codemirror/addon/fold/comment-fold.js');
    require("codemirror/addon/edit/closebrackets");
    export default {
        name: "mycodemirror",
        props: {
            lang: {
                type: String,
                default: 'clike'
            },
            readOnly: {
                type: Boolean,
                default: false
            },
            precode: {
                type: String,
                default: ''
            },
            expectHeight: {
                type: Number,
                default: 480
            }
        },
        components: {
            codemirror
        },
        data () {
            return {
                code: this.precode,
                cmOptions: {
                    mode: {
                        name: 'text/x-csrc',            // 语言
                        json: true
                    },
                    readOnly: this.readOnly,
                    theme: 'material',                  // 主题
                    indentUnit: 4,                      // 默认缩进宽度
                    tabSize: 4,                         // tab宽度
                    indentWithTabs: true,               // 用Tab替换缩进
                    smartIndent: true,                  // 智能缩进
                    lineNumbers: true,                  // 显示行号
                    matchBrackets: true,                // 括号匹配
                    lineWrapping: true,                 // 自动换行
                    autoCloseBrackets: true,            // 自动闭合符号
                }
            }
        },
        computed: {
            editor() {
                return this.$refs.mycode.editor;
            }
        },
        watch: {
            lang: function(val) {
                this.cmOptions.mode.name = val;
                this.editor.setOption("mode",{
                    name: val,
                    json: true
                });
            }
        },
        mounted() {
            if(!this.readOnly) this.editor.focus();
            // console.log(this.editor);
        }
    }
</script>

<style lang="scss">
    .-codeMirrorEditor {
        font: {
            size: 11pt;
            family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
        }
    }

    .CodeMirror {
        height: 480px;
        overflow: hidden;
    }

    .cm-s-material {
        .CodeMirror-gutters {
            background: unset;
        }
    }

    .cm-s-material.CodeMirror {
        background-color: rgba(38, 50, 56, 0.9);
    }

    @media screen and (min-height: 780px) {
        .CodeMirror {
            height: 730px;
        }
    }
</style>