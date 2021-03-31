// import Vue from 'vue';
import Vue from 'vue/dist/vue.js';
import VeeValidate from 'vee-validate';

import './bootstrap';

window.Vue = Vue;
window.VeeValidate = VeeValidate;

Vue.use(VeeValidate, {
    events: 'input|change|blur',
});

Vue.prototype.$http = axios;

window.eventBus = new Vue();

$(function() {
    var app = new Vue({
        el: "#app",

		store,

        data: {
            modalIds: {},

            isMenuOpen: true
        },

        mounted() {
            this.addServerErrors();
            
            this.addFlashMessages();
        },

        methods: {
            onSubmit: function (e) {
                this.toggleButtonDisable(true);

                if (typeof tinyMCE !== 'undefined') {
                    tinyMCE.triggerSave();
                }

                this.$validator.validateAll().then(result => {
                    if (result) {
                        e.target.submit();
                    } else {
                        this.toggleButtonDisable(false);

                        eventBus.$emit('onFormError')
                    }
                });
            },

            toggleButtonDisable (value) {
                var buttons = document.getElementsByTagName("button");

                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].disabled = value;
                }
            },

            addServerErrors(scope = null) {
                for (var key in serverErrors) {
                    var inputNames = [];
                    key.split('.').forEach(function(chunk, index) {
                        if(index) {
                            inputNames.push('[' + chunk + ']')
                        } else {
                            inputNames.push(chunk)
                        }
                    })

                    var inputName = inputNames.join('');

                    const field = this.$validator.fields.find({
                        name: inputName,
                        scope: scope
                    });

                    if (field) {
                        this.$validator.errors.add({
                            id: field.id,
                            field: inputName,
                            msg: serverErrors[key][0],
                            scope: scope
                        });
                    }
                }
            },

            addFlashMessages() {
                if (typeof flashMessages == 'undefined') {
                    return;
                };

                const flashes = this.$refs.flashes;

                flashMessages.forEach(function(flash) {
                    flashes.addFlash(flash);
                }, this);
            },

            openModal(id) {
                this.$set(this.modalIds, id, true);
            },

            closeModal(id) {
                this.$set(this.modalIds, id, false);
            },

            toggleMenu() {
                this.isMenuOpen = ! this.isMenuOpen;
            }
        }
    });
});