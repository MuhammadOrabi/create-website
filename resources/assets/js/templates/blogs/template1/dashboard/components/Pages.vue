<template>
    <section>
        <b-field>
            <b-input placeholder="Filter by Title Or Types Or Created at" type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>
        <b-table :data="filtered" :mobile-cards="true" :loading="loading">
            <template slot-scope="props">
                <b-table-column field="title" label="Title">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="items" label="Sections">
                    {{ props.row.items }}
                    <a :href="`/dashboard/items/${props.row.id}/${address}`" class="button is-link is-rounded is-inverted">
                        <b-icon pack="fa" icon="cog"></b-icon>
                    </a>
                </b-table-column>

                <b-table-column label="Type">
                    {{ props.row.type }}                    
                </b-table-column>

                <b-table-column field="created_at" label="Created at">
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column label="Actions">
                    <pages-crud r u d :address="address" :token="token" @getData="getData" :sectionid="props.row.id + ''"></pages-crud>              
                </b-table-column>
            </template>
            
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon icon="emoticon-sad" size="is-large"></b-icon>
                        </p>
                        <p>You don't have any pages!, Create Page Here</p>
                        <p>
                            <b-icon icon="arrow-down" size="is-large"></b-icon>
                        </p>
                    </div>
                </section>
            </template>
            <template slot="footer">
                <pages-crud c :address="address" :token="token" @getData="getData" :id="id" ></pages-crud>
            </template>
        </b-table>        
    </section>
</template>

<script>
import moment from "moment";
import * as JsSearch from 'js-search';
const _ = window._;

export default {
  	name: 'Pages',
  	props: ['token', 'address', 'id'],
  	data() {
		return {
			pages: [],
            key: '',
            loading: true 
		};
  	},
    computed: {
        filtered() {
            if (this.key) {
                let search = new JsSearch.Search('id');
                search.addIndex('title');
                search.addIndex('type');
                search.addIndex('created_at');
                search.addDocuments(this.pages);
                return search.search(this.key);
            } else {
                return this.pages;
            }
        }
    },
  	mounted() {
    	this.getData();
  	},
	methods: {
        moment,
		getData() {
    		window.axios.get(`/api/dashboard/pages/${this.id}`, { headers: { Authorization: `Bearer ${this.token}` } })
			.then(res => {
                this.pages = res.data.sections;
                this.pages = [];
                res.data.sections.forEach((section) => {
                    let items = section.contents ? section.contents.length : 0;
                    this.pages.push(
                        {id: section.id, title: section.title, type: section.type, items: items, created_at: moment(section.created_at).calendar()}
                    );
                });
                this.loading = false;
			})
			.catch(err => console.log(err));
		}
	}
};
</script>

<style>

</style>
