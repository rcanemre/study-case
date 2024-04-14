<script setup>
import {ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter();

let error = ref('')
let keys = ref([]);
const deleteData = async (id) => {
    const token = localStorage.getItem('token');

    await axios.delete('/api/data/' + id, {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    }).then(response => {
        if (response.data.success) {
            error.value = response.data.message;
            setTimeout(() => {
                error.value = '';
            }, 2000);
        } else {
            error.value = response.data.message;
            setTimeout(() => {
                error.value = '';
            }, 2000);
        }
    })
    getData()
}
const getData = async () => {
    const token = localStorage.getItem('token');

    await axios.get('/api/data', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    }).then(response => {
        if (response.data.success) {
            keys.value = response.data.data;
        } else {
            error.value = response.data.message;
        }
    })
}
getData()
</script>
<template>
    <div class="content">
        <p class="error-msg" v-if="error">{{ error }}</p>
        <h1>Your Data</h1>
        <p>Here you can see your data.</p>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Key</th>
                <th>Value</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="key in keys" :key="key.id">
                <td>{{ key.id }}</td>
                <td>{{ key.user.name }}</td>
                <td>{{ key.api_key }}</td>
                <td>{{ key.value }}</td>
                <td>{{ key.created_at }}</td>
                <td><button @click="deleteData(key.id)">Delete Key</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style>
.content {
    margin-top: 50px;
    padding: 10px;
    width: 100%;
}
.content p.error-msg{
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
.content h1 {
    margin-bottom: 10px;
}
.content button {
    background-color: aqua;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    padding: 5px 10px;
    margin: 10px;
    font-weight: bold;
}
.content table {
    width: 100%;
    margin-top: 10px;
    border-collapse: collapse;
    background-color: #f7fafc;
}
.content table button {
    background-color: #ff0000;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    cursor: pointer;
    margin: 0;
}
.content table th, .content table td {
    border: 1px solid #cccccc;
    padding: 10px;
    text-align: left;
}
.content table th {
    background-color: #f0f0f0;
}
.content table tr:nth-child(even) {
    background-color: #f0f0f0;
}
.content table tr:hover {
    background-color: #e0e0e0;
}
</style>
