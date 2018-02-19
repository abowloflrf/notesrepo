<template>
    <el-container>
        <el-aside class="notesrepo-left" v-bind:class={showSidebar:isSidebarActive}>
            <div class="notesrepo-side-container">

                <div style="display: flex; align-items: center; justify-content: space-between; flex: 0 0 auto; height: 40px; margin-top: 0px;margin-bottom:20px; box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 1px; background: white; width: 100%; z-index: 1;">
                    <div style="display: block; align-items: center; min-width: 0px; height: auto;">
                        <div class="notion-button notion-cursor-pointer" style="align-items: center; user-select: none; width: 100%; display: flex; height: 100%;">
                            <div style="display: flex; align-items: center; min-height: 26px; font-size: 14px; padding: 0px; overflow: hidden; width: 100%;">
                                <div style="flex: 1 1 auto; white-space: nowrap; overflow: hidden; min-width: 1px; margin-bottom: 1px; text-overflow: ellipsis;">
                                    <div style="display: flex; align-items: center;padding-left: 12px; padding-right: 12px; ">
                                        <div style="margin-right: 6px; color: rgb(68, 68, 68); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            Workspace
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <el-tree :data="notesList" :props="notesListProps" accordion @node-click="handleNodeClick"></el-tree>

                <div class="notesrepo-new new-note" v-popover:chooseCategory>
                    <el-popover
                        ref="chooseCategory"
                        placement="bottom"
                        width="160"
                        v-model="showChooseCategory">
                        <p>选择文件夹</p>
                        <el-select v-model="choosenCategory" placeholder="请选择">
                            <el-option
                            v-for="item in categoryOptions"
                            :key="item"
                            :label="item"
                            :value="item">
                            </el-option>
                        </el-select>
                        <div style="text-align: right; margin-top: 10px">
                            <el-button size="mini" type="text" @click="showChooseCategory=false">取消</el-button>
                            <el-button type="primary" size="mini" @click="newNote">确定</el-button>
                        </div>
                    </el-popover>
                    <div class="notesrepo-side-button" style="align-items: center; user-select: none; width: 100%; display: flex;">
                        <div style="display: flex; align-items: center; min-height: 26px; font-size: 16px; padding: 8px 10px; color: rgb(136, 136, 136);">
                            <div style="display: flex; align-items: center; justify-content: center; flex-shrink: 0; flex-grow: 0; margin-right: 4px; color: rgb(186, 185, 184); width: 28px; height: 24px;">
                                <div style="width: 20px; display: flex; align-items: center; justify-content: center;">
                                    <svg width="100%" height="100%" viewBox="0 0 18 18" style="fill: currentcolor; display: block; width: 13px; height: 13px;">
                                        <polygon points="17,8 10,8 10,1 8,1 8,8 1,8 1,10 8,10 8,17 10,17 10,10 17,10 "></polygon>
                                    </svg>
                                </div>
                            </div>
                            <div style="flex: 1 1 auto; white-space: nowrap; overflow: hidden; min-width: 1px; margin-bottom: 1px; text-overflow: ellipsis;">
                                新建笔记
                            </div>
                        </div>
                    </div>
                </div>
                <div class="notesrepo-new new-folder" v-popover:inputFolder>
                    <el-popover
                        ref="inputFolder"
                        placement="bottom"
                        width="160"
                        v-model="showInputFolder">
                        <p>新建文件夹</p>
                        <el-input v-model="newFolderName" placeholder="文件夹名"></el-input>
                        <div style="text-align: right; margin-top: 10px">
                            <el-button size="mini" type="text" @click="showInputFolder=false">取消</el-button>
                            <el-button type="primary" size="mini" @click="newFolder(newFolderName)">确定</el-button>
                        </div>
                    </el-popover>
                    <div class="notesrepo-side-button" style="align-items: center; user-select: none; width: 100%; display: flex;">
                        <div style="display: flex; align-items: center; min-height: 26px; font-size: 16px; padding: 8px 10px; color: rgb(136, 136, 136);">
                            <div style="display: flex; align-items: center; justify-content: center; flex-shrink: 0; flex-grow: 0; margin-right: 4px; color: rgb(186, 185, 184); width: 28px; height: 24px;">
                                <div style="width: 20px; display: flex; align-items: center; justify-content: center;">
                                    <svg width="100%" height="100%" viewBox="0 0 18 18" style="fill: currentcolor; display: block; width: 13px; height: 13px;">
                                        <polygon points="17,8 10,8 10,1 8,1 8,8 1,8 1,10 8,10 8,17 10,17 10,10 17,10 "></polygon>
                                    </svg>
                                </div>
                            </div>
                            <div style="flex: 1 1 auto; white-space: nowrap; overflow: hidden; min-width: 1px; margin-bottom: 1px; text-overflow: ellipsis;">
                                新建文件夹
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </el-aside>
        <el-container class="notesrepo-right" v-bind:class={showSidebar:isSidebarActive}>
            <el-header class="notesrepo-header" :height="headerHeight">
                <div class="notesrepo-toggler" @click="showSidebar">
                    <svg width="18px" height="18px" viewBox="0 0 14 14" style="fill: currentcolor; display: block; width: 18px; height: 18px;"><path d="M0,1.25 L14,1.25 L14,2.75 L0,2.75 L0,1.25 Z M0,6.25 L14,6.25 L14,7.75 L0,7.75 L0,6.25 Z M0,11.25 L14,11.25 L14,12.75 L0,12.75 L0,11.25 Z"></path></svg>
                </div>
                <div v-if="currentNote" style="display:inline">
                    <el-button class="notesrepo-top-btn" size="mini" type="primary" :loading="saveLoading" @click="saveNote">保存</el-button>
                    <el-button class="notesrepo-top-btn" size="mini" type="danger" :loading="deleteLoading" @click="deleteNote">删除</el-button>
                    <el-popover
                        ref="sharePopover"
                        placement="bottom"
                        width="260"
                        v-model="showSharePopover">
                        <div style="padding:5px 10px">
                            <span>分享为一篇可公开访问的文章</span>
                            <el-switch
                                v-model="currentNote.is_public"
                                @change="changeShareStatus"
                                active-color="#4aa9e2"
                                inactive-color="#c4c4c4"
                                style="float:right">
                            </el-switch>
                            <div style="margin-top:15px" v-if="currentNote.is_public">
                                <el-input
                                size="small"
                                v-model="publicUrl"
                                id="url-input">
                                </el-input>
                                <el-button type="text" @click="copyURL">复制链接</el-button>
                            </div>
                        </div>    
                    </el-popover>
                    <el-button class="notesrepo-top-btn" size="mini" type="text" v-popover:sharePopover style="margin-left:10px">分享</el-button>
                </div>
            </el-header>
            <el-main v-loading="noteLoading">
                <div class="notesrepo-note" v-if="currentNote">
                    <div>
                        <div class="notesrepo-title">
                            <el-input class="notesrepo-title-input" v-model="currentNote.title" placeholder="请输入标题"></el-input>
                        </div>
                        <markdown-editor v-model="currentNote.content" :configs="editorConfigs" ref="markdownEditor"></markdown-editor>
                    </div>
                </div>
                <div v-else>
                    <span class="notesrepo-empty-str">从左侧选择笔记</span>
                </div>
            </el-main>
        </el-container>
        <div id="todo-btn" @click="showTodo = true">
            <i class="el-icon-tickets"></i>
        </div>
        <el-dialog
            title="TODOs"
            :visible.sync="showTodo"
            top="10vh"
            class="notesrepo-todo-dialog">
            <Todo v-if="showTodo"></Todo>
        </el-dialog>
    </el-container>
</template>

<script>
import Todo from "./components/Todo"
import markdownEditor from "vue-simplemde/src/markdown-editor"

export default {
    components: {
        markdownEditor,
        Todo
    },
    data() {
        return {
            user: null,
            notesList: [],
            currentNote: null,
            notesListProps: {
                children: "notes",
                label: "title",
                isLeaf: "isNote"
            },
            noteLoading: false,
            saveLoading: false,
            deleteLoading: false,
            editorConfigs: {
                spellChecker: false, // 禁用拼写检查
                toolbar: ["bold", "italic", "heading", "link", "image", "|", "preview"]
            },
            isSidebarActive: false,
            showChooseCategory: false,
            showInputFolder: false,
            showSharePopover: false,
            choosenCategory: "未指定目录", // TODO: 这里改成第一个文件夹
            newFolderName: "未命名目录",
            headerHeight: "40px",
            showTodo: false
        }
    },
    methods: {
        showSidebar() {
            this.isSidebarActive = !this.isSidebarActive
        },
        handleNodeClick(data) {
            //判断是笔记还是文件夹，若点击的是笔记则获取详细内容
            if (data.hasOwnProperty("isNote")) {
                this.noteLoading = true
                axios
                    .get("/api/notes/" + data.uuid)
                    .then(response => {
                        this.currentNote = response.data
                        this.noteLoading = false
                    })
                    .catch(function(error) {
                        console.log(error)
                    })
                this.isSidebarActive = false
            }
        },
        newNote() {
            this.showChooseCategory = false
            var noteCategory = this.choosenCategory
            this.currentNote = {
                title: "未命名笔记",
                category: noteCategory,
                content: "## 写点什么吧"
            }
            axios
                .post("/api/notes/new", {
                    title: this.currentNote.title,
                    category: this.currentNote.category,
                    content: this.currentNote.content
                })
                .then(response => {
                    if (response.data.status == "SUCCESS") {
                        //新建成功回调uuid传回currentNote
                        this.currentNote.uuid = response.data.uuid
                        //再获取笔记列表
                        this.refreshList()
                    } else {
                        this.$message({
                            message: "创建笔记出错",
                            type: "error"
                        })
                    }
                })
        },
        saveNote: function() {
            this.saveLoading = true
            axios
                .post("/api/notes/" + this.currentNote.uuid, {
                    title: this.currentNote.title,
                    content: this.currentNote.content
                })
                .then(response => {
                    this.saveLoading = false
                    if (response.data.status == "SUCCESS") {
                        this.$message({
                            message: "已保存",
                            type: "success"
                        })
                        //再获取笔记列表
                        this.refreshList()
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
                    axios.delete("/api/notes/" + this.currentNote.uuid).then(response => {
                        this.deleteLoading = false
                        if (response.data.status == "SUCCESS") {
                            //清空currentNote
                            this.currentNote = null
                            //刷新笔记列表
                            this.refreshList()
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
        },
        newFolder: function(folderName) {
            this.showInputFolder = false
            this.noteLoading = true
            axios
                .post("/api/folder/new", {
                    category: folderName
                })
                .then(response => {
                    if (response.data.status == "SUCCESS") {
                        this.currentNote = response.data.note
                        this.refreshList()
                        this.noteLoading = false
                    } else {
                        this.noteLoading = false
                        this.$message({
                            message: response.data.msg,
                            type: "error"
                        })
                    }
                })
        },
        changeShareStatus: function(isPublic) {
            axios.post("/api/notes/publish/" + this.currentNote.uuid, {
                is_public: this.currentNote.is_public
            })
        },
        copyURL: function() {
            var urlInput = document.getElementById("url-input")
            urlInput.select()
            try {
                var success = document.execCommand("copy")
                var msg = success ? "已复制！" : "浏览器不支持赋值，请手动复制链接"
                this.$message({
                    message: msg
                })
            } catch (err) {
                alert("浏览器不支持赋值，请手动复制链接")
            }
        },
        refreshList: function() {
            axios
                .get("/api/notes")
                .then(response => {
                    let tempList = response.data.notes_list
                    tempList.forEach(e => {
                        e.notes.forEach(n => {
                            n["isNote"] = true
                        })
                    })
                    this.notesList = tempList
                })
                .catch(function(error) {
                    console.log(error)
                })
        }
    },
    computed: {
        categoryOptions: function() {
            var options = []
            this.notesList.forEach(e => {
                options.push(e.title)
            })
            return options
        },
        publicUrl: function() {
            return "http://notesrepo.com/p/" + this.currentNote.uuid
        }
    },
    beforeCreate() {
        //获取用户信息
        axios
            .post("/api/auth/me")
            .then(response => {
                this.user = response.data
            })
            .catch(function(error) {
                console.log(error)
            })
        //获取笔记列表
        axios
            .get("/api/notes")
            .then(response => {
                let tempList = response.data.notes_list
                tempList.forEach(e => {
                    e.notes.forEach(n => {
                        n["isNote"] = true
                    })
                })
                this.notesList = tempList
                //获取第一个目录
                if (this.notesList.length > 0) {
                    this.choosenCategory = this.notesList[0].title
                }
            })
            .catch(function(error) {
                console.log(error)
            })
    }
}
</script>

<style>
@import "~simplemde/dist/simplemde.min.css";
body {
    font-family: "PingFang SC", "Source Han Sans CN", "Hiragino Sans GB", "Microsoft YaHei", Arial, sans-serif;
}
.CodeMirror-code {
    font-family: "Fira Code", monospace;
}
.el-tree {
    margin-bottom: 20px;
}
.el-main {
    background-color: #e9eef3;
}
.el-container {
    overflow: hidden;
}
.el-message {
    min-width: 200px !important;
}
.notesrepo-left {
    position: absolute;
    top: 0px;
    left: 0px;
    bottom: 0px;
    display: flex;
    flex-direction: column;
    width: 300px;
    display: none;
    overflow: visible;
}
.notesrepo-left.showSidebar {
    display: block !important;
}
.notesrepo-side-container {
    width: 300px;
    flex-grow: 0;
    flex-shrink: 0;
    position: relative;
}
.notesrepo-side-button {
    cursor: pointer;
    transition: 140ms ease-in；;
}
.notesrepo-side-button:hover {
    background: #f5f7fa;
}
.notesrepo-right {
    height: 100vh;
    box-shadow: rgba(84, 70, 35, 0.3) 0px 6px 20px;
    flex-grow: 1;
    flex-shrink: 1;
    display: flex;
    flex-direction: column;
    z-index: 1;
    max-height: 100%;
}
.notesrepo-right.showSidebar {
    transform: translateX(300px);
    transition: 0.2s;
}
.notesrepo-header {
    z-index: 100;
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.1);
    padding: 0;
}
.notesrepo-toggler {
    padding: 11px;
    cursor: pointer;
    display: inline-block;
}
.notesrepo-toggler svg {
    height: 18px;
    width: 18px;
}
.notesrepo-note {
    word-wrap: break-word;
    max-width: 1200px;
    overflow-y: auto;
    margin: auto;
}
.notesrepo-new {
    display: block;
    color: rgb(160, 159, 158);
    flex: 0 0 auto;
    margin-top: auto;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 1px inset;
}
.notesrepo-empty-str {
    text-align: center;
    margin: 100px auto;
    color: #1f2f3d;
}
.el-message-box {
    width: 240px;
}
.notesrepo-top-btn {
    vertical-align: 130%;
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
#todo-btn {
    position: absolute;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: #eeeeee;
    border-radius: 50%;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
    z-index: 999;
    cursor: pointer;
}
#todo-btn:hover {
    box-shadow: 0 0 16px rgba(0, 0, 0, 0.4);
    transition: 0.2s;
}
#todo-btn i {
    color: #606266;
    font-size: 30px;
    line-height: 50px;
    position: relative;
    left: 9px;
}
.notesrepo-todo-dialog {
    padding: 0 20px;
}
.notesrepo-todo-dialog .el-dialog {
    max-width: 500px;
    width: auto;
}
</style>
