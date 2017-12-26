<template>
    <v-container>
        <v-card>
            <v-card-title class="headline">
                News
                <v-spacer></v-spacer>
                <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search" ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="items" :search="search" class="elevation-1">
                <template slot="items" slot-scope="props">
                    <tr @click="props.expanded = !props.expanded">
                        <td class="">{{ props.item.heading }}</td>
                        <td class="">{{ props.item.date }}</td>
                        <td><crud-news r u d :parent="parent" :token="token" :address="address" :newsid="props.item.id+''" ></crud-news></td>	
                    </tr>
                </template>
                <template slot="expand" slot-scope="props">
                    <v-card flat>
                        <v-card-text>{{ props.item.paragraph }}</v-card-text>
                    </v-card>
                </template>
                <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                    From {{ pageStart }} to {{ pageStop }}
                </template>
            </v-data-table>
            <div class="text-xs-center pt-2">
                <crud-news c :parent="parent" :token="token" :address="address" :id="id" ></crud-news>
            </div>
        </v-card>
    </v-container>
</template>

<script>
    const _ = window._;
    const axios = window.axios;
    import moment from 'moment';
    export default {
        name: 'News',
        props: ['token', 'address', 'id'],
        data() {
            return {
                headers: [
                    { text: 'Title', align: 'left', value: 'h' },
                    { text: 'Date', align: 'left', value: 'date' },
                ],
                items: [],
                search: '',
            };
        },
        computed: {
            parent() {
                return this;
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                const vm = this;
                axios.get('/api/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.items = [];
                    res.data.page.sections.forEach(section => {
                        let h = _.findWhere(section.contents, {type: 'heading'});
                        let img = _.findWhere(section.contents, {type: 'img'});
                        let p = _.findWhere(section.contents, {type: 'paragraph'});
                        let date = moment(section.created_at).calendar();
                        this.items.push({id: section.id, img: img.content, paragraph: p.content, heading: h.content, date: date,
                            imgId: img.id, pId: p.id, hId: h.id, show: false, imgDialog: false, delDialog: false});
                    });
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped>

</style>


