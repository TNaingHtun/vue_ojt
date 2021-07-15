<template>
    <div class="main">
        <div class="mt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-5 bg-white border-b border-gray-200">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left">
                                    <h2>Create Post</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ValidationObserver v-slot="{ handleSubmit }" ref="formValidationObserver">
                                <form
                                    v-on:submit.prevent="handleSubmit(saveForm)"
                                >
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputTitle"
                                                >Post Title</label
                                            >
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                rules="required_title"
                                            >
                                                <input
                                                    class="form-control"
                                                    id="inputTitle"
                                                    :state="
                                                        errors[0] ? false : null
                                                    "
                                                    placeholder="Please enter title"
                                                    v-model="post.title"
                                                    required
                                                />
                                                <p
                                                    class="form__error text-danger"
                                                >
                                                    {{ errors[0] }}
                                                </p>
                                                <p
                                                    v-if="uniqueError"
                                                    class="form__error text-danger"
                                                >
                                                    {{ error }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputDescription"
                                                >Post Description</label
                                            >
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                rules="required_description"
                                            >
                                                <input
                                                    class="form-control"
                                                    id="inputDescription"
                                                    :state="
                                                        errors[0] ? false : null
                                                    "
                                                    placeholder="Please enter description"
                                                    v-model="post.description"
                                                    required
                                                />
                                                <p
                                                    class="form__error text-danger"
                                                >
                                                    {{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputUser"
                                                >Post User</label
                                            >
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                rules="required_post_user"
                                            >
                                                <select
                                                    class="form-control select-width"
                                                    @change="
                                                        onChangeUser(
                                                            created_user
                                                        )
                                                    "
                                                    v-model="post.created_user"
                                                    required
                                                >
                                                    <option
                                                        v-for="user_name in user_names"
                                                        :state="
                                                            errors[0]
                                                                ? false
                                                                : null
                                                        "
                                                        :key="user_name.value"
                                                        :value="user_name"
                                                        >{{ user_name }}</option
                                                    >
                                                </select>
                                                <p
                                                    class="form__error text-danger"
                                                >
                                                    {{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputDate"
                                                >Post Expired Date</label
                                            >
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                rules="required_post_expired_date"
                                            >
                                                <date-picker
                                                    class="form-control date"
                                                    id="inputDate"
                                                    :state="
                                                        errors[0] ? false : null
                                                    "
                                                    format="YYYY/MM/DD"
                                                    placeholder="YYYY/MM/DD"
                                                    v-model="post.expired_at"
                                                    required
                                                    value-type="YYYY-MM-DD"
                                                    :disabled-date="
                                                        disabledDates
                                                    "
                                                />
                                                <p
                                                    class="form__error text-danger"
                                                >
                                                    {{ errors[0] }}
                                                </p>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </form>
                            </ValidationObserver>
                        </div>

                        <div class="buttons">
                            <button
                                class="btn btn-secondary cancel-btn"
                                @click="cancelForm()"
                            >
                                Cancel
                            </button>
                            <button
                                class="btn btn-success submit-btn"
                                @click="saveForm(post)"
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import "../../../css/post/post-create.css";
</style>
<script src="../../services/post/post-create.js"></script>
