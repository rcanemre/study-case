<script setup>
import {reactive, ref} from "vue";

let form = reactive({
    value: '',
    api_key: ''
});

let error = ref('')

const createData = async () => {
    const headers = {
        'Accept': 'application/json'
    };

    await axios.post('/api/data', form, { headers })
        .then(response => {
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
}
</script>

<template>
    <div class="login">
        <div class="formLogin">
            <h3>Send Data With RestAPI</h3>
            <p class="error-msg" v-if="error">{{ error }}</p>
            <form @submit.prevent="createData">
                <input type="text" placeholder="Enter your data value" v-model="form.value">
                <input type="text" placeholder="Enter your api key" v-model="form.api_key">
                <button type="submit">Send My Data</button>
            </form>
        </div>
    </div>
</template>

<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.login{
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 0;
}
.formLogin{
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 2px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.formLogin h3{
    text-align: center;
    margin-bottom: 20px;
}
.formLogin p.error-msg{
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
.formLogin form input{
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.formLogin form button{
    width: 100%;
    padding: 10px;
    border: 0;
    border-radius: 5px;
    background-color: #333;
    color: #fff;
    cursor: pointer;
}
</style>
