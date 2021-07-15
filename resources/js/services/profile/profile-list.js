import { isEmpty } from "lodash";
import moment from "moment";
import constants from "../../constant";

export default {
    data() {
        return {
            keyword: "",
            users: [],
            filterUser: [],
            profileInfo: null,
            dialogTitle: "",
            dialog: false,
            isDeleteDialog: false,
            headerList: [{
                    text: "User Name",
                    aligin: "center",
                    value: "name"
                },
                {
                    text: "User Email",
                    aligin: "center",
                    value: "email"
                },
                {
                    text: "User Image",
                    aligin: "center",
                    value: "image"
                },
                {
                    text: "User Phone",
                    aligin: "center",
                    value: "phone"
                },
                {
                    text: "User Address",
                    aligin: "center",
                    value: "address"
                },
                {
                    text: "Operation",
                    aligin: "center",
                    value: "operation"
                }
            ],
            profileUrl: constants.PROFILE_URL
        };
    },
    mounted() {
        axios
            .get("../api/profile")
            .then(response => {
                console.log(response);
                this.users = response.data;
                this.filterUser = this.users;
                console.log("user :" + this.users);
            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
        filterProfiles() {
            this.users = this.filterUser.filter(user => {
                return (
                    user.name.includes(this.keyword) ||
                    user.email.includes(this.keyword) ||
                    user.phone.includes(this.keyword) ||
                    user.address.includes(this.keyword)
                );
            });
        },

        createUser() {
            this.$router.push({ name: "profile-create" });
        },

        profiletDetail(profile) {
            this.dialogTitle = "Profile Details";
            this.dialog = true;
            this.profileInfo = profile;
        },

        showProfileEdit(profileId) {
            this.$router.push({ name: "profile-edit", params: { id: profileId } });
        },

        showProfileDeleteDialog(profile) {
            this.dialogTitle = "Profile Delete Confirmation";
            this.isDeleteDialog = true;
            this.dialog = true;
            this.profileInfo = profile;
        },

        closeDialog() {
            this.dialogTitle = "";
            this.dialog = false;
            this.isDeleteDialog = false;
        },

        deleteProfile() {
            console.log('delete');
            axios
                .delete("../api/profile/delete/" + this.profileInfo.id)
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
        }
    },
    updated() {
        if (document.getElementById("detail-dialog")) {
            if (this.profileInfo.image.includes('profile')) {
                document.getElementById("detail-profile").src =
                    "/images/" + this.profileInfo.image;
            } else {

                document.getElementById("detail-profile").src =
                    this.profileUrl + this.profileInfo.image;
            }
            document.getElementById(
                "detail-profile"
            ).alt = this.profileInfo.image;
            document.getElementById(
                "detail-name"
            ).textContent = this.profileInfo.name;
            document.getElementById(
                "detail-email"
            ).textContent = this.profileInfo.email;
            document.getElementById(
                "detail-phone"
            ).textContent = this.profileInfo.phone;
            document.getElementById(
                "detail-address"
            ).textContent = this.profileInfo.address;
        }
    }
};