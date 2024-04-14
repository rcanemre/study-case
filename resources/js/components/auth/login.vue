<script setup>
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter();

let form = reactive({
    email: '',
    password: ''
});

let error = ref('')

const login = async () => {
    await axios.post('/api/login', form)
        .then(response => {
            if(response.data.success){
                localStorage.setItem('token', response.data.data.token);
                localStorage.setItem('email', response.data.data.email);
                router.push('/dashboard');
            }else {
                error.value = response.data.message;
                setTimeout(() => {
                    error.value = '';
                }, 3000);
            }
        })
}
</script>

<template>
    <div class="login">
         <div class="formLogin">
             <h3>Login</h3>
             <p class="error-msg" v-if="error">{{ error }}</p>
             <form @submit.prevent="login">
                 <input type="email" placeholder="Enter your e-mail address" v-model="form.email">
                 <input type="password" placeholder="Enter your password" v-model="form.password">
                 <button type="submit">Login</button>
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
