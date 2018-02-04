<template>
    <el-container>
        <el-aside class="noterepo-left" :width="asideWidth" v-bind:style="{ width: asideWidth }">
            <div class="notesrepo-side-container">
                <UserInfo v-if="user" :user="user"></UserInfo>
                <el-button type="primary" @click="newNote" plain>新笔记</el-button>
                <el-button type="primary" plain>新目录</el-button>
                <el-tree :data="notesList" :props="notesListProps" accordion @node-click="handleNodeClick"></el-tree>
                <div class="notesrepo-new">New Note</div>
            </div>
        </el-aside>
        <el-container class="notesrepo-right">
            <el-header class="notesrepo-header" :height="headerHeight">
                <div class="notesrepo-toggler" @click="hideSidebar">   
                    <svg width="18px" height="18px" viewBox="0 0 14 14" style="fill: currentcolor; display: block; width: 18px; height: 18px;"><path d="M0,1.25 L14,1.25 L14,2.75 L0,2.75 L0,1.25 Z M0,6.25 L14,6.25 L14,7.75 L0,7.75 L0,6.25 Z M0,11.25 L14,11.25 L14,12.75 L0,12.75 L0,11.25 Z"></path></svg>
                </div>
                <span>保存</span>
            </el-header>
            <el-main v-loading="noteLoading">
                <div class="notesrepo-note" v-if="currentNote">
                    <Editor :note="currentNote"></Editor>
                </div>
                <Empty v-else></Empty >
            </el-main>
        </el-container>
        <div id="todo-btn" @click="showTodo = true"></div>
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
import Editor from "./components/Editor"
import Empty from "./components/Empty"
import UserInfo from "./components/UserInfo"
import Todo from "./components/Todo"

export default {
    components: {
        Editor,
        Empty,
        UserInfo,
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
            headerHeight: "40px",
            asideWidth: "230px",
            showTodo:false
        }
    },
    methods: {
        hideSidebar() {
            if (this.asideWidth == "230px") {
                this.asideWidth = "0px"
            } else {
                this.asideWidth = "230px"
            }
        },
        handleNodeClick(data) {
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
            }
        },
        newNote() {}
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
            })
            .catch(function(error) {
                console.log(error)
            })
    }
}
</script>

<style>
.notesrepo-left {
    width: 230px;
    flex-grow: 0;
    flex-shrink: 0;
    pointer-events: none;
    position: relative;
    z-index: 99;
}
.notesrepo-side-container {
    padding: 10px;
}
.notesrepo-right {
    height: 100vh;
    box-shadow: rgba(84, 70, 35, 0.3) 0px 6px 20px;
    flex-grow: 1;
    flex-shrink: 1;
    display: flex;
    flex-direction: column;
    z-index: 1;
    width: calc(100vw - 230px);
    max-height: 100%;
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
    max-width: 100%;
    overflow-y: auto;
}
.notesrepo-new {
    display: block;
    flex: 0 0 auto;
    margin-top: auto;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 1px inset;
}
.el-main {
    background-color: #e9eef3;
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
}
.notesrepo-todo-dialog{
    padding: 0 20px;

}
.notesrepo-todo-dialog .el-dialog{
    max-width: 500px;
    width: auto;
}
</style>
