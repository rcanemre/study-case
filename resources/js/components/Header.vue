<script setup>
import {useRouter} from "vue-router";

const router = useRouter();

const token = localStorage.getItem('token');
const email = localStorage.getItem('email');

const isLoggedIn = token && email;

const logout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('email');
    router.push('/')
}

</script>

<template>
    <header>
        <nav class="header-nav">
            <router-link to="/">Home</router-link>
            <router-link v-if="isLoggedIn" to="/dashboard">Dashboard</router-link>
            <router-link v-if="isLoggedIn" to="/dashboard/keys">Api Keys</router-link>
            <router-link v-if="isLoggedIn" to="/dashboard/data">My Data</router-link>
            <router-link v-if="!isLoggedIn" to="/login">Login</router-link>
            <router-link v-if="!isLoggedIn" to="/register">Register</router-link>
            <button v-if="isLoggedIn" @click="logout">Logout</button>
        </nav>
    </header>
</template>

<style>
.header-nav {
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid #cccccc;
    padding: 10px;
    margin: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}
.header-nav a {
    margin-right: 10px;
    color: #000000;
    text-decoration: none;
}
.header-nav a:hover {
    text-decoration: underline;
}
.header-nav button {
    background-color: #ff0000;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    cursor: pointer;
    padding: 5px 10px;
}
</style>
