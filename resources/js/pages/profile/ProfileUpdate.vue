<template>
    <v-card class="mx-auto" max-width="500">
        <v-card-title class="update-title">
            <span class="title font-weight-light">Profile Update</span>
        </v-card-title>
        <v-row class="text-center">
            <v-col class="text-center" cols="12">
                <img id="old-profile" class="old-profile rounded-circle d-inline-block" src="" alt="">
            </v-col>
        </v-row>
        <v-form ref="form" v-model="valid">
            <v-card-text class="update-content">
                <div class="update-input">
                    <v-text-field v-model="name" type="text" :rules="nameRules" hide-details="auto">
                        <template #label>
                            <span>Name</span>
                            <span class="red--text">
                                <strong>*</strong>
                            </span>
                        </template>
                    </v-text-field>
                    <div v-if="errors.name">
                        <div v-for="error in errors.name" :key="error">
                            <span class="red--text">{{ error }}</span>
                        </div>
                    </div>
                </div>
                <div class="update-input">
                    <v-text-field v-model="email" type="text" :rules="emailRules" hide-details="auto">
                        <template #label>
                            <span>Email</span>
                            <span class="red--text">
                                <strong>*</strong>
                            </span>
                        </template>
                    </v-text-field>
                    <div v-if="errors.email">
                        <div v-for="error in errors.email" :key="error">
                            <span class="red--text">{{ error }}</span>
                        </div>
                    </div>
                </div>

                <div class="update-input">
                    <v-text-field v-model="phone" type="text" :rules="phoneRules" hide-details="auto">
                        <template #label>
                            <span>Phone</span>
                        </template>
                    </v-text-field>
                    <div v-if="errors.phone">
                        <div v-for="error in errors.phone" :key="error">
                            <span class="red--text">{{ error }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <v-textarea label="Address" :rules="addressRules" v-model="address" rows="2">
                    </v-textarea>
                </div>
                <div>
                    <v-file-input @change="handleProfileInput" show-size v-model="profile" :rules="profileRules" accept="image/png, image/jpeg">
                        <template #label>
                            <span>New Profile</span>>
                        </template>
                    </v-file-input>
                    <div v-if="errors.profile">
                        <div v-for="error in errors.profile" :key="error">
                            <span class="red--text">{{ error }}</span>
                        </div>
                    </div>
                    <img class="preview" id="profile-preview" />
                </div>
            </v-card-text>
            <v-card-actions class="update-action">
                <v-btn :disabled="!valid" color="success" class="mr-4" @click="updateForm" >Update</v-btn >
                <v-btn color="error" class="mr-4" @click="resetForm" >Clear</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<style scoped>
@import "../../../css/profile/profile-update.css";
</style>
<script src="../../services/profile/profile-update.js"></script>
