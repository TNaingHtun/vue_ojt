import { isEmpty } from "lodash";

export default {

    data() {
        return {
            keyword: "",
            posts: {},
            postInfo: null,
            dialogTitle: "",
            dialog: false,
            isDeleteDialog: false,
            postPaginate: true,
            searchPaginate: false,
            sortDirection: "asc",
            sortField: "title",
        }
    },
    mounted() {
        console.log('postList');
        this.getPosts();
    },
    methods: {
        changeSort(field) {
            if (this.sortField == field) {
                if (this.sortDirection == "asc") {
                    this.sortDirection = "desc";
                } else {
                    this.sortDirection = "asc";
                }
                console.log("change");
                console.log(this.sortDirection);
            } else {
                this.sortField = field;
            }

            if (!isEmpty(this.keyword)) {
                this.filterPosts();
            } else {
                this.getPosts();
            }
        },
        getPosts(page = 1) {
            this.searchPaginate = false;
            this.postPaginate = true;
            axios
                .get("../api/post/list?page=" + page + "&sort_direction=" + this.sortDirection + "&sort_field=" + this.sortField)
                .then(response => {
                    console.log(response);
                    this.posts = response.data;
                    console.log("post :" + this.posts);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        filterPosts(page = 1) {
            if (!isEmpty(this.keyword)) {
                this.searchPaginate = true;
                this.postPaginate = false;
                axios
                    .get("../api/post/search/" + this.keyword + "?page=" + page + "&sort_direction=" + this.sortDirection + "&sort_field=" + this.sortField)
                    .then(response => {
                        console.log(response);
                        this.posts = response.data;
                        console.log("post :" + this.posts);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            } else {
                this.getPosts();
            }
        },
        createPost() {
            this.$router.push({ name: "post-create" });
        },
        postDetail(post) {
            this.dialog = true;
            this.postInfo = post;
            this.$alert(
                this.postInfo.description,
                this.postInfo.title,
            );
        },
        showPostEdit(postId) {
            this.$router.push({ name: "post-edit", params: { id: postId } });
        },
        deletePost(postId) {
            this.$confirm("Are you sure?", "Post Delete", 'warning', true).then(() => {
                axios
                    .delete("../api/post/delete/" + postId)
                    .then(response => {
                        console.log(response.data);
                        this.$alert(response.data).then(() => {
                            location.reload();
                        });

                    })
                    .catch(err => {
                        console.log(err);
                    });
            });
        }
    }


}