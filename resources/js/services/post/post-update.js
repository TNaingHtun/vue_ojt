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
extend('required_post_expired_date', {
    ...required,
    message: "Please fill expired date",
})

export default {
    data() {
        return {
            post: [],
            uniqueError: false,
        };
    },

    components: {
        ValidationObserver,
        ValidationProvider,
        DatePicker
    },
    mounted() {
        console.log(this.$route.params.id);

        axios
            .get("../../../api/post/list/" + this.$route.params.id)
            .then(response => {
                console.log(response);
                this.post = response.data.data[0];
                console.log(this.post);
            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
        disabledDates(date) {
            return date < new Date(new Date().setHours(0, 0, 0, 0));
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
                    if (this.post.status == true) {
                        this.post.status = 1;
                    } else {
                        this.post.status = 0;
                    }

                    axios.put(
                        '../../../api/post/edit/' + this.$route.params.id, {
                            title: this.post.title,
                            description: this.post.description,
                            status: this.post.status,
                            expired_at: this.post.expired_at
                        },
                    )

                    .then(response => {
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