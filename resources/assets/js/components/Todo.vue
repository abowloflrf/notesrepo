<template>
<div>
    <el-input v-model="newTodo" placeholder="回车添加todo" @keyup.enter.native="addTodo" autofocus spellcheck="false"></el-input>
    <el-table
    :data="todos"
    v-loading="isLoading"
    :show-header="false"
    style="width: 100%">
    <el-table-column
      fixed="left"
      width="50">
      <template slot-scope="scope">
        <input type="checkbox" class="toggle" v-model="scope.row.todo_active" @click="updateTodo">
      </template>
    </el-table-column>
    <el-table-column>
        <template slot-scope="scope">
            <span :class="{completed:scope.row.todo_active}">{{scope.row.todo_body}}</span>
        </template>
    </el-table-column>
    <el-table-column
      fixed="right"
      width="50">
      <template slot-scope="scope">
        <i class="el-icon-close" @click="removeTodo(scope.row)" style="cursor:pointer"></i>
      </template>
    </el-table-column>
    </el-table>
</div>
</template>

<script>
import _ from "lodash"
export default {
    data() {
        return {
            //用户的所有todo
            todos: null,
            //新建input内容绑定
            newTodo: "",
            //正在编辑的todo
            editedTodo: null,
            isLoading: false
        }
    },
    methods: {
        addTodo() {
            //检查输入是否为空
            var value = this.newTodo && this.newTodo.trim()
            if (!value) {
                return
            }
            //添加到todos数组中
            this.todos.push({
                todo_body: value,
                todo_active: 0
            })
            //ajax发送数据保存
            axios.post("/api/todo", {
                todos: JSON.stringify(this.todos)
            })
            //将输入新todo的输入框置空
            this.newTodo = ""
        },
        updateTodo: _.debounce(function(e) {
            axios.post("/api/todo", {
                todos: JSON.stringify(this.todos)
            })
        }, 500),
        removeTodo(todo) {
            this.todos.splice(this.todos.indexOf(todo), 1)
            axios.post("/api/todo", {
                todos: JSON.stringify(this.todos)
            })
        }
    },
    created() {
        this.isLoading = true
        axios.get("/api/todo").then(response => {
            this.isLoading = false
            this.todos = response.data
        })
    }
}
</script>

<style>
.toggle {
    text-align: center;
    width: 40px;
    height: 40px;
    position: absolute;
    top: 8px;
    bottom: 0;
    margin: auto 0;
    border: none;
    -webkit-appearance: none;
    outline: none;
}
.toggle:after {
    content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#ededed" stroke-width="5"/></svg>');
}
.toggle:checked:after {
    content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#bddad5" stroke-width="5"/><path fill="#5dc2af" d="M72 25L42 71 27 56l-4 4 20 20 34-52z"/></svg>');
}
.completed {
    color: #d9d9d9;
    text-decoration: line-through;
}
</style>
