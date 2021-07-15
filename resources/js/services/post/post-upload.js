export default {
    data: () => ({
        error: "",
        valid: true,
        csvFile: null,
        csvFileRules: [
            value => !!value || "The CSV File field is required.",
            value => !value || value.size < 2000000 || "CSV File size should be less than 2MB!",
            value => !value || value.name.split(".").pop() == "csv" || "CSV File must be CSV format"
        ]
    }),
    methods: {
        resetForm() {
            this.$refs.form.reset();
        },
        submitForm() {
            // To send data like form data including CSV File
            const formData = new FormData();
            formData.append("csv_file", this.csvFile);
            axios
                .post("../../../api/post/upload", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    this.error = "";
                    this.$router.push({ name: "test" });
                })
                .catch(err => {
                    this.valid = false;
                    this.error = err.response.data.error;
                    console.log(this.error[0].message);
                });
        }
    }
};