<template>
    <div>
        <el-button class="notesrepo-save-btn" type="primary" :loading="saveLoading" @click="saveNote" plain>保存</el-button>
        <el-button class="notesrepo-del-btn" type="danger" :loading="deleteLoading" @click="deleteNote" plain>删除</el-button>
        <div class="notesrepo-title">
            <el-input class="notesrepo-title-input" v-model="note.title" placeholder="请输入标题"></el-input>
        </div>
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
            deleteLoading: false,
            content: this.note.content,
            configs: {
                spellChecker: false, // 禁用拼写检查
                toolbar: ["bold", "italic", "heading", "link", "image", "|", "preview"]
            }
        }
    },
    methods: {
        saveNote: function() {
            this.saveLoading = true
            axios
                .post("/api/notes/" + this.note.uuid, {
                    title: this.note.title,
                    content: this.content
                })
                .then(response => {
                    this.saveLoading = false
                    if (this.isEditingTitle) {
                        this.isEditingTitle = false
                    }
                    if (response.data.status == "SUCCESS") {
                        this.$message({
                            message: "已保存",
                            type: "success"
                        })
                    } else {
                        this.$message({
                            message: "保存出错",
                            type: "error"
                        })
                    }
                })
        },
        deleteNote: function() {
            this.$confirm("永久删除该笔记？", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning"
            })
                .then(() => {
                    this.deleteLoading = true
                    axios.delete("/api/notes/" + this.note.uuid).then(response => {
                        this.deleteLoading = false
                        if (response.data.status == "SUCCESS") {
                            this.$message({
                                message: "已删除",
                                type: "success"
                            })
                        } else {
                            this.$message({
                                message: "删除出错",
                                type: "error"
                            })
                        }
                    })
                })
                .catch(() => {
                    console.log("cancelled")
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
.el-message-box {
    width: 240px;
}
.notesrepo-save-btn {
    margin-bottom: 20px;
}
.notesrepo-title {
    margin-bottom: 10px;
}
.notesrepo-title-input {
    width: 100%;
}
.notesrepo-title-btn {
    margin-left: 10px;
}
</style>
