import { isEmpty } from "lodash";
import moment from "moment";

export default {

    data() {
        return {
            keyword: "",
            searchKeyword: "This is search keyword",
            posts: [],
            filterPost: [],
            downloadPosts: [],
            postInfo: null,
            dialogTitle: "",
            dialog: false,
            isDeleteDialog: false,
            headerList: [{
                    text: "Post Title",
                    aligin: "center",
                    value: "title"
                },
                {
                    text: "Post Desciption",
                    aligin: "center",
                    value: "description"
                },
                {
                    text: "Post Status",
                    aligin: "center",
                    value: "status"
                },
                {
                    text: "Post Expired",
                    aligin: "center",
                    value: "expired_at"
                },
                {
                    text: "Posted User",
                    aligin: "center",
                    value: "created_user"
                },
                {
                    text: "Operation",
                    aligin: "center",
                    value: "operation"
                }
            ],
            excel_heading: {
                "Post Title": "title",
                "Post Desciption": "description",
                "Post Expired Date": "expired_at",
                "Post User": "created_user"
            },
        }
    },
    watch: {
        // whenever search keyword changes, this function will run
        keyword(newQuestion, oldQuestion) {
            this.searchKeyword = 'Waiting for you to stop typing...'
            this.debouncedGetKeyword();
        }
    },
    created() {
        // _.debounce is a function provided by lodash to limit how
        this.debouncedGetKeyword = _.debounce(this.getKeyword, 500)
    },
    mounted() {
        axios
            .get("../api/post")
            .then(response => {
                console.log(response);
                for (var i in response.data) {
                    if (response.data[i].status == 1) {
                        response.data[i].status = "Available";
                    } else {
                        response.data[i].status = "Unavailable";
                    }
                    response.data[i].created_at = moment(response.data[i].created_at).format("YYYY/MM/DD");
                    response.data[i].expired_at = moment(response.data[i].expired_at).format("YYYY/MM/DD");
                }
                this.posts = response.data;
                this.filterPost = this.posts;
                console.log("post :" + this.posts);
            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
        getKeyword() {
            if (!isEmpty(this.keyword)) {
                this.searchKeyword = this.keyword;
                return
            }
            this.searchKeyword = "This is search keyword";
        },
        filterPosts() {
            this.posts = this.filterPost.filter(post => {
                return (
                    post.title.includes(this.keyword) ||
                    post.description.includes(this.keyword) ||
                    post.created_user.includes(this.keyword)
                );
            });
        },

        createPost() {
            this.$router.push({ name: "post-create" });
        },
        postDetail(post) {
            this.dialogTitle = "Post Details";
            this.dialog = true;
            this.postInfo = post;
        },
        showPostEdit(postId) {
            this.$router.push({ name: "post-edit", params: { id: postId } });
        },
        showPostDeleteDialog(post) {
            this.dialogTitle = "Post Delete Confirmation";
            this.isDeleteDialog = true;
            this.dialog = true;
            this.postInfo = post;
        },
        deletePost() {
            axios.delete("../api/post/delete/" + this.postInfo.id)
                .then(response => {
                    this.dialog = false;
                    this.isDeleteDialog = false;
                    console.log(response.data);
                    this.$alert(response.data).then(() => {
                        location.reload();
                    });

                })
                .catch(err => {
                    console.log(err);
                });
        },
        closeDialog() {
            this.dialogTitle = "";
            this.dialog = false;
            this.isDeleteDialog = false;
        },
        csvUpload() {
            this.$router.push({ name: "post-upload" });
        },

        downloadCSV() {
            for (var i in this.posts) {
                this.posts[i].expired_at = moment(this.posts[i].expired_at, "YYYY/MM/DD").format("MM/DD/YYYY");
            }
            axios.post('/api/post/download/', this.posts)
                .then(response => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'posts.csv');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                    console.log(response.data);
                })
                .catch(err => {
                    console.log(err);
                })
        }
    },
    updated() {
        if (document.getElementById("detail-dialog")) {
            document.getElementById("detail-title").textContent = this.postInfo.title;
            document.getElementById("detail-description").textContent = this.postInfo.description;

            if (this.postInfo.status == 1) {
                document.getElementById("detail-status").textContent = "Available";
            } else {
                document.getElementById("detail-status").textContent = "Unavailable";
            }

            document.getElementById("detail-posted-date").textContent = moment(this.postInfo.created_at).format("YYYY/MM/DD");
            document.getElementById("detail-expired-date").textContent = moment(this.postInfo.expired_at).format("YYYY/MM/DD");
            document.getElementById("detail-posted-user").textContent = this.postInfo.created_user;
        }
    }

}