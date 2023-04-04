<template>
    <div>
      <header>
        <!-- header content here -->
      </header>
      <nav>
            <router-link to="/">Home</router-link>
            <router-link to="/favorite">Favorite</router-link>  
      </nav>
      <main>
        <router-view></router-view>
      </main>
      <footer>
        <!-- footer content here -->
      </footer>
    </div>
  </template>
 