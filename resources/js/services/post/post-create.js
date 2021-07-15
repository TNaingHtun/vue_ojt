import axios from "axios";
import { extend, ValidationObserver, ValidationProvider } from "vee-validate";
import { required } from 'vee-validate/dist/rules';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

extend('required_title', {
    ...required,
    message: "Please fill title",
})

extend('required_description', {
    ...required,
    message: "Please fill description",
})

extend('required_post_user', {
    ...required,
    message: "Please choose user",
})

extend('required_post_expired_date', {
    ...required,
    message: "Please fill expired date",
})

export default {
    data() {
        return {
            user_names: [],
            post: {
                title: "",
                description: "",
                created_user_id: "",
                expired_at: ""
            },
            uniqueError: false
        };
    },

    components: {
        ValidationObserver,
        ValidationProvider,
        DatePicker
    },
    mounted() {
        Promise.all([
                this.getUserId()
            ])
            .then((values) => {
                var created_users;
                [created_users] = values;
                this.setUserId(created_users);
            })
    },
    methods: {
        disabledDates(date) {
            return date < new Date(new Date().setHours(0, 0, 0, 0));
        },

        onChangeUser(created_user) {
            // console.log('data', created_user);
            for (var i in created_user) {
                if (this.post.created_user == created_user[i].name) {
                    this.post.created_user_id = created_user[i].id;
                }
            }
            console.log(this.post.created_user_id);
        },

        getUserId() {
            return axios.get('../api/user/list')
                .then((response) => response.data);
        },
        setUserId(data) {
            //console.log('user data :', data);
            var created_user_id_array = [];
            var created_user_name_array = [];
            this.created_user = data;

            for (var i in data) {
                created_user_id_array[i] = data[i].id;
                created_user_name_array[i] = data[i].name;
            }

            this.user_ids = created_user_id_array;
            this.user_names = created_user_name_array;
            if (this.$route.params.post) {
                this.post.created_user_id = this.$route.params.post.created_user_id;
                this.post.created_user_name = this.$route.params.post.created_user_name;
            }
        },
        saveForm(event) {
            this.$refs.formValidationObserver.validate().then(success => {
                if (!success) {
                    setTimeout(() => {
                        const errors = Object.entries(this.$refs.formValidationObserver.errors)
                            .map(([key, value]) => ({ key, value }))
                            .filter(error => error["value"].length);
                        this.$refs.formValidationObserver.refs[errors[0]["key"]].$el.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }, 100);
                } else {
                    console.log('post data', this.post);
                    axios.post(
                        '../../../api/post/create', {
                            title: this.post.title,
                            description: this.post.description,
                            created_user_id: this.post.created_user_id,
                            expired_at: this.post.expired_at
                        },
                    ).then(response => {
                        if (response.data.status === 422) {
                            this.uniqueError = true;
                            this.error = "Post title is already existed"
                        } else {
                            this.$router.push({ name: "test" });
                        }
                    })
                }
            })
        },

        cancelForm() {
            this.$router.push({ name: "test" });
        }
    }
}