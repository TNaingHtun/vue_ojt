import Vue from "vue";
import VueRouter from "vue-router";
import PostList from "../pages/post/PostList.vue";
import PostCreate from "../pages/post/PostCreate.vue";
import PostUpdate from "../pages/post/PostUpdate.vue";
import PostUpload from "../pages/post/PostUpload.vue";
import Test from "../pages/Test.vue";
import ProfileList from "../pages/profile/ProfileList.vue";
import ProfileCreate from "../pages/profile/ProfileCreate.vue";
import ProfileUpdate from "../pages/profile/ProfileUpdate.vue";

Vue.use(VueRouter);

/**
 * This is router setup for frontend side.
 */

console.log('vue');
const routes = [{
        path: "/vue/post-list",
        name: "post-list",
        component: PostList,
    },
    {
        path: "/vue/post-create",
        name: "post-create",
        component: PostCreate,
    },
    {
        path: "/vue/post-edit/:id",
        name: "post-edit",
        component: PostUpdate,
    },
    {
        path: "/vue/post-upload",
        name: "post-upload",
        component: PostUpload,
    },
    {
        path: "/vue/test",
        name: "test",
        component: Test,
    },
    {
        path: "/vue/profile",
        name: "profile-list",
        component: ProfileList,
    },
    {
        path: "/vue/profile-create",
        name: "profile-create",
        component: ProfileCreate,
    },
    {
        path: "/vue/profile-edit",
        name: "profile-edit",
        component: ProfileUpdate,
    }
]

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;