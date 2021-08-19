<template>
    <v-card class="mt-5 p-5" outlined>
        <v-card-title class="p-0">
            Post List
        </v-card-title>
        <v-form ref="form">
            <v-row class="tool-bar mt-2 pl-3">
                <v-col class="p-0" md="3">
                    <v-text-field class="p-0" v-model="keyword" label="Search keyword" hide-details="auto"></v-text-field>
                    <p class="mt-1">{{searchKeyword}}</p>
                </v-col>
                <v-btn class="ml-1 mr-3" color="success" @click="filterPosts()">Filter</v-btn>
                <v-btn class="mr-3" color="success" @click="createPost()">Create Post</v-btn>
                <v-btn class="ml-1 mr-3" color="success"  @click="csvUpload()">Upload</v-btn>

                <!-- TODO: vue-export-excel -->
                <!-- <export-excel :data="posts" :fields="excel_heading" worksheet="posts" name="posts.xls">
                    <v-btn color="success">Download Excel</v-btn>
                </export-excel> -->

                <!-- vue-json-excel -->
                <download-excel :data="posts" :fields="excel_heading" worksheet="posts" type="csv" name="posts.xls" >
                    <v-btn color="success">Download Excel</v-btn>
                </download-excel>

                <v-btn class="ml-1 mr-3" color="success"  @click="downloadCSV()">
                    Download CSV with Laravel Excel
                </v-btn>

            </v-row>
            <v-container>
                <v-data-table
                    :headers="headerList"
                    :items="posts"
                    class="elevation-1 p-2 mt-5"
                >
                    <template v-slot:item.title="{ item }">
                        <a href="#" v-if="item.title" @click.stop="postDetail(item)">{{item.title}}</a>
                    </template>
                    <template v-slot:item.operation="{ item }">
                        <v-row>
                            <div class="operation-btn mr-2">
                                <v-btn color="success" class="post-list-btn" @click="showPostEdit(item.id)">Edit</v-btn>
                            </div>
                            <div class="operation-btn">
                                <v-btn color="error" class="post-list-btn" @click="showPostDeleteDialog(item)">Delete</v-btn>
                            </div>
                        </v-row>
                    </template>
                </v-data-table>
                <v-dialog v-model="dialog" persistent max-width="600">
                    <v-card>
                        <v-card-title class="headline">{{dialogTitle}}</v-card-title>
                        <v-card-text id="detail-dialog">
                            <v-row class="detail-row">
                                <v-col cols="4">
                                    <strong>Title :</strong>
                                </v-col>
                                <v-col cols="8">
                                    <span id="detail-title"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col cols="4">
                                    <strong>Description :</strong>
                                </v-col>
                                <v-col cols="8">
                                    <span id="detail-description"></span>
                                </v-col>
                            </v-row>
                                <v-row class="detail-row">
                                <v-col cols="4">
                                    <strong>Status :</strong>
                                </v-col>
                                <v-col cols="8">
                                    <span id="detail-status"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col cols="4">
                                    <strong>Posted Date :</strong>
                                </v-col>
                                <v-col cols="8">
                                    <span id="detail-posted-date"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col cols="4">
                                    <strong>Expired Date :</strong>
                                </v-col>
                                <v-col cols="8">
                                    <span id="detail-expired-date"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col cols="4">
                                    <strong>Posted User :</strong>
                                </v-col>
                                <v-col cols="8">
                                    <span id="detail-posted-user"></span>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions class="register-action">
                            <v-spacer></v-spacer>
                            <v-btn color="error" v-if="isDeleteDialog" large @click="deletePost()">Delete</v-btn>
                            <v-btn color="primary" large @click="closeDialog">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-form>
    </v-card>
</template>
<style scoped>
@import "../.././css/test.css";
</style>
<script src=".././services/test.js"></script>
