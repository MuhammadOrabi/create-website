<template>
    <div class="flex-container p-b-100">
        <section class="section has-text-centered">
            <div class="container">
                <h1 class="title">Section</h1>
                <h2 class="subtitle">
                    A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading
                </h2>
                <video width="800" height="480" src="/img/out.ogv" controls preload="auto"></video>
            </div>
        </section>
        <div class="columns">
            <div class="column">
                <p class="content">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
            <aside class="column menu">
                <ul class="menu-list">
                    <li>
                    <a class="is-active">Lessons</a>
                        <ul class="p-t-5">
                            <li><a href="">Lesson 1</a></li>
                            <li><a href="">Lesson 2</a></li>
                            <li><a href="">Lesson 3</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
        </div>
    </div>
</template>

<script>
export default {

  name: 'Lesson',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>
</style>