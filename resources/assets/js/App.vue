<template>
    <el-tree :data="data" :props="defaultProps" accordion @node-click="handleNodeClick"></el-tree>
</template>

<script>
export default {
    data() {
        return {
            data: [],
            defaultProps: {
                children: "notes",
                label: "title",
                isLeaf: "isNote"
            }
        }
    },
    methods: {
        handleNodeClick(data) {
            if (data.hasOwnProperty("isNote")) {
                console.log(data)
                axios
                    .get("/api/notes/" + data.uuid)
                    .then(response => {
                        this.$alert(response.data.content,"Title: "+response.data.title, {
                            confirmButtonText: "确定"
                        })
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
                //console.log(response.data)
                //var temp1 = response.data
                //console.log(temp1);
                //给每条节点加上'isLeaf'属性
                // temp1 = temp1.notes_list.forEach(e=> {
                //     e.notes.forEach(n=> {
                //         n["isNote"] = true
                //     })
                // })
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

</style>
