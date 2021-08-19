export default {
    data() {
        return {
            errors: "",
            valid: true,
            name: "",
            email: "",
            phone: "",
            address: "",
            profile: null,

            // validataion rules for user name
            nameRules: [
                value => !!value || "The name field is required.",
                value =>
                !value ||
                value.length <= 255 ||
                "The name filed must be at most 255 characters."
            ],

            // validation rules for user email
            emailRules: [
                value => !!value || "The email field is required..",
                value =>
                /.+@.+\..+/.test(value) ||
                "The email field must be an email.",
                value =>
                !value ||
                value.length <= 255 ||
                "The email filed must be at most 255 characters."
            ],

            // validataion rules for user phone
            phoneRules: [
                value =>
                !value ||
                value.length <= 11 ||
                "The phone filed must be at most 11 characters."
            ],

            // validation rules for user address
            addressRules: [
                value =>
                !value ||
                value.length <= 255 ||
                "The address filed must be at most 255 characters."
            ],

            // validation rules for profile picture
            profileRules: [
                value =>
                !value ||
                value.size < 2000000 ||
                "Profile size should be less than 2MB!",
                value =>
                !value ||
                /^image/.test(value.type) ||
                "Profile must be image (png or jpg)."
            ]
        };
    },
    methods: {
        handleProfileInput(profile) {
            console.log(profile);
            console.log(/^image/.test(profile.type));
            const image = document.getElementById("profile-preview");
            image.style.display = "none";
            if (profile && /^image/.test(profile.type)) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    image.src = event.target.result;
                    image.style.border = "1px solid rgb(206, 212, 218)";
                    image.style.display = "block";
                };
                reader.readAsDataURL(profile);
                console.log(reader);
            }
        },

        cancelForm() {
            this.$router.push({ name: "profile-list" });
        },

        submitForm() {
            const formData = new FormData();
            formData.append("name", this.name);
            formData.append("email", this.email);
            formData.append("phone", this.phone);
            formData.append("address", this.address);
            if (this.profile) {
                formData.append("profile", this.profile);
            }
            console.log(formData);
            axios
                .post('../../../api/profile/create', formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    this.errors = "";
                    this.$router.push({ name: "profile-list" });
                })
                .catch(err => {
                    this.valid = false;
                    this.errors = err.response.data.errors;
                    console.log(this.errors);
                });
        }
    }
};