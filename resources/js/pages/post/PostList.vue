<template>
    <div class="main">
        <div class="mt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-5 bg-white border-b border-gray-200">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left">
                                <h2>Post List</h2>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <input type="text" name="keyword" id="keyword" placeholder="Keyword" v-model="keyword">
                            <button class="btn btn-success" @click="filterPosts()">Filter</button>
                            <button class="btn btn-success" @click="createPost()">Create Post</button>
                        </div>
                        <!-- Create Table -->
                        <table class="w-100 table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-2">
                                        <a href="#" @click.prevent="changeSort('title')">Post Title</a>
                                        <span class="sortArr">
                                            <i class="fas fa-long-arrow-alt-up"></i>
                                            <i class="fas fa-long-arrow-alt-down"></i>
                                        </span>
                                    </th>
                                    <th scope="col" class="col-2">
                                        <a href="#" @click.prevent="changeSort('description')">Post Description</a>
                                        <span class="sortArr">
                                            <i class="fas fa-long-arrow-alt-up"></i>
                                            <i class="fas fa-long-arrow-alt-down"></i>
                                        </span>
                                    </th>
                                    <th class="col-2">Post User</th>
                                    <th class="col-2">Post Status</th>
                                    <th class="col-2">Post Date</th>
                                    <th class="col-2">Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="post in posts.data" :key="post.id">
                                    <td class="align-middle">
                                        <a href="#" @click="postDetail(post)">{{ post.title }}</a>
                                    </td>
                                    <td class="align-middle">{{ post.description }}</td>
                                    <td class="align-middle">{{ post.created_user }}</td>
                                    <td class="align-middle" v-if="post.status == 0">Unavailable</td>
                                    <td class="align-middle" v-if="post.status == 1">Available</td>
                                    <td class="align-middle" >{{ post.created_at|moment('YYYY/MM/DD') }}</td>
                                    <td>
                                        <button class="btn btn-success" @click="showPostEdit(post.id)">Edit</button>
                                        <button class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- end table -->

                        <pagination v-if="postPaginate" :data="posts" @pagination-change-page="getPosts"></pagination>
                        <pagination v-if="searchPaginate" :data="posts" @pagination-change-page="filterPosts"></pagination>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<style scoped>
@import "../../../css/post/post-list.css";
</style>
<script src="../../services/post/post-list.js"></script>
