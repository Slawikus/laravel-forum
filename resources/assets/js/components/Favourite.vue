<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favouritesCount"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                favouritesCount: this.reply.favouritesCount,
                isFavourited: this.reply.isFavourited
            }
        },
        computed: {
            classes() {
                return ['btn', this.isFavourited ? 'btn-primary' : 'btn-default'];
            }
        },
        methods: {
            toggle() {
                if (this.isFavourited) {
                    axios.delete('/replies/' + this.reply.id + '/favourites');
                    this.isFavourited = false;
                    this.favouritesCount--;
                } else {
                    axios.post('/replies/' + this.reply.id + '/favourites');
                    this.isFavourited = true;
                    this.favouritesCount++;
                }
            }
        }
    }
</script>
