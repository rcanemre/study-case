<script setup>
import {ref} from "vue";

let error = ref('')
let keys = ref([]);
const getUser = async () => {
    const token = localStorage.getItem('token');

    await axios.get('/api/user', {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    }).then(response => {
        if (response) {
            keys.value = response.data;
        }
    })
}
getUser()
</script>
<template>
    <div class="user-card">
<!--        <img src="user-avatar.jpg" alt="User Avatar" class="avatar">-->
        <div class="user-info">
            <h3>Welcome, {{keys.name}}</h3>
            <hr>
            <p><b>Your Id :</b> {{keys.id}}</p>
            <p><b>Your E-Mail :</b> {{keys.email}}</p>
            <hr>
        </div>
    </div>
</template>

<style>
.user-card {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 0;
}
.user-info {
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 2px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.user-info h3{
    text-align: center;
    margin-bottom: 20px;
}
.user-info hr{
    margin-bottom: 20px;
}
.user-info p{
    margin-bottom: 10px;
}
</style>
