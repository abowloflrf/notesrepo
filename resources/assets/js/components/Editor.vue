<template>
    <div>
        <el-button class="notesrepo-save-btn" type="primary" :loading="saveLoading" @click="saveNote">Save</el-button>
        <markdown-editor v-model="content" :configs="configs" ref="markdownEditor"></markdown-editor>
    </div>
</template>

<style>
@import "~simplemde/dist/simplemde.min.css";
</style>

<script>
import markdownEditor from "vue-simplemde/src/markdown-editor"

export default {
    components: {
        markdownEditor
    },
    props: ["note"],
    data: function() {
        return {
            saveLoading: false,
            content: this.note.content,
            configs: {
                spellChecker: false // 禁用拼写检查
            }
        }
    },
    methods: {
        saveNote: function() {
            this.saveLoading = true
            axios
                .post("/api/notes/" + this.note.uuid, {
                    content: this.content
                })
                .then(response => {
                    this.saveLoading = false
                    let msg=""
                    if(response.data.status=="SUCCESS"){
                        msg="已保存！"
                    }else{
                        msg="保存失败！"
                    }
                    this.$notify({
                        message: msg
                    })
                })
        }
    },
    watch: {
        note(val) {
            this.content = val.content
        }
    }
}
</script>

<style>
.notesrepo-save-btn{
    margin-bottom: 20px;
}
</style>
