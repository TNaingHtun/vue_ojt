<template>
    <v-card class="mt-5 p-5" outlined>
        <v-card-title class="p-0">
            User List
        </v-card-title>
        <v-form ref="form">
            <v-row class="tool-bar mt-2 pl-3">
                <v-col class="p-0" md="3">
                    <v-text-field class="p-0" v-model="keyword" label="Search keyword" hide-details="auto"></v-text-field>
                </v-col>
                <v-btn class="ml-1 mr-3" color="success" @click="filterProfiles()">Filter</v-btn>
                <v-btn class="mr-3" color="success" @click="createUser()">Create User</v-btn>
            </v-row>
            <v-container>
                <v-data-table
                    :headers="headerList"
                    :items="users"
                    class="elevation-1 p-2 mt-5"
                >
                    <template v-slot:item.name="{ item }">
                        <a href="#" v-if="item.name" @click.stop="profiletDetail(item)">{{item.name}}</a>
                    </template>
                    <template v-slot:item.operation="{ item }">
                        <v-row>
                            <div class="operation-btn mr-2">
                                <v-btn color="success" class="post-list-btn" @click="showProfileEdit(item.id)">Edit</v-btn>
                            </div>
                            <div class="operation-btn">
                                <v-btn color="error" class="post-list-btn" @click="showProfileDeleteDialog(item)">Delete</v-btn>
                            </div>
                        </v-row>
                    </template>
                </v-data-table>
                <v-dialog v-model="dialog" persistent max-width="600">
                    <v-card>
                        <v-card-title class="headline">{{dialogTitle}}</v-card-title>
                        <v-card-text id="detail-dialog">
                            <v-row class="detail-row text-center">
                                <v-col class="text-center" cols="12">
                                    <img id="detail-profile" class="detail-profile rounded-circle d-inline-block" src="" alt="">
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col class="text-right" cols="6">
                                    <strong>Name :</strong>
                                </v-col>
                                <v-col cols="6">
                                    <span id="detail-name"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col class="text-right" cols="6">
                                    <strong>Email :</strong>
                                </v-col>
                                <v-col cols="6">
                                    <span id="detail-email"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col class="text-right" cols="6">
                                    <strong>Phone :</strong>
                                </v-col>
                                <v-col cols="6">
                                    <span id="detail-phone"></span>
                                </v-col>
                            </v-row>
                            <v-row class="detail-row">
                                <v-col class="text-right" cols="6">
                                    <strong>Address :</strong>
                                </v-col>
                                <v-col cols="6">
                                    <span id="detail-address"></span>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions class="register-action">
                            <v-spacer></v-spacer>
                            <v-btn color="error" v-if="isDeleteDialog" @click="deleteProfile()">Delete</v-btn>
                            <v-btn color="secondary" @click="closeDialog">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-form>
    </v-card>
</template>
<style scoped>
@import "../../../css/profile/profile-list.css";
</style>
<script src="../../services/profile/profile-list.js"></script>
