<template>
<div>
    <p>Translation key <code>SUBSCRIPTION_EXAMPLE</code> from <code>subscription/resources/lang/**/js.php</code>: {{$lang.SUBSCRIPTION_EXAMPLE}}</p>
    <button class="form-builder__send btn" @click="testDebug">Test console log for debug</button>
    <p>From config JS file: {{this.example_data}}</p>
    <p>Example function: {{this.exampleFromFunction}}</p>
    <p>
        <button class="form-builder__send btn" @click="testLoading">Test loading</button>
        <span v-if="isLoading">is loading...</span>
    </p>
</div>
</template>

<script>
import subscriptionMixin from '../js/mixins/subscription'
import {consoleDebug} from '../js/modules/helpers'

let _uniqSectionId = 0;

export default {

    name: 'subscription',

    mixins: [ subscriptionMixin ],

    props: {
        name: {
            type: String,
            default() {
                return `subscription-${ _uniqSectionId++ }`
            }
        },

        default: Object,

        storeData: String,
    },


    computed: {
        subscription() {
            return this.$store.state.subscription[this.name]
        },

        isLoading() {
            return this.subscription && this.subscription.isLoading
        },
    },

    created() {

        let data = this.storeData ? this.$store.state[this.storeData] : (this.default || {})

        this.$store.commit('subscription/create', {
            name: this.name,
            data
        })
    },

    mounted() {

    },

    methods: {
        testDebug(){
            consoleDebug('message', ['data1'], ['data2'])
        },

        testLoading(){
            if ( this.isLoading) return;

            AWEMA.emit(`subscription::${this.name}:before-test-loading`)

            this.$store.dispatch('subscription/testLoading', {
                name: this.name
            }).then( data => {
                consoleDebug('data', data);
                this.$emit('success', data.data)
                this.$store.$set(this.name, this.$get(data, 'data', {}))
            })
        }
    },


    beforeDestroy() {

    }
}
</script>
