<template>
    <el-container>
        <el-aside width="240px">
            <el-tree :data="data" :props="defaultProps" accordion @node-click="handleNodeClick"></el-tree>
        </el-aside>
        <el-container class="notesrepo-right">
            <el-header>Header</el-header>
            <el-main>
                <div class="notesrepo-note" v-loading="noteLoading" v-if="currentNote">
                    <Editor :note="currentNote"></Editor>
                </div>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
import Editor from './components/Editor'
export default {
    components:{
        Editor
    },
    data() {
        return {
            data: [],
            currentNote:null,
            defaultProps: {
                children: "notes",
                label: "title",
                isLeaf: "isNote"
            },
            noteLoading:false
        }
    },
    methods: {
        handleNodeClick(data) {
            if (data.hasOwnProperty("isNote")) {
                this.noteLoading=true
                axios
                    .get("/api/notes/" + data.uuid)
                    .then(response => {
                        this.currentNote=response.data
                        this.noteLoading=false
                    })
                    .catch(function(error) {
                        console.log(error)
                    })
            }
        }
    },
    created() {
        axios
            .get("/api/notes")
            .then(response => {
                let tempList = response.data.notes_list
                tempList.forEach(e => {
                    e.notes.forEach(n => {
                        n["isNote"] = true
                    })
                })
                this.data = tempList
            })
            .catch(function(error) {
                console.log(error)
            })
    }
}
</script>

<style>
.el-header,
.el-footer {
    background-color: #b3c0d1;
    text-align: center;
    line-height: 60px;
}

.notesrepo-right {
    width: calc(100vw-240px);
    height: 100vh;
}
.notesrepo-note{
    word-wrap:break-word;
    max-width: 100%;
    overflow-y: auto;
}

.el-main {
    background-color: #e9eef3;
}
</style>
