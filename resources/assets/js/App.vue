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
                label: "title"
            }
        }
    },
    methods: {
        handleNodeClick(data) {
            console.log(data)
        }
    },
    created() {
        axios
            .get("/api/notes")
            .then(response => {
                console.log(response.data)
                this.data = JSON.parse(response.data.notes_list)
                //this.titleList = response.data
            })
            .catch(function(error) {
                console.log(error)
            })
    }
}
</script>

<style>

</style>
