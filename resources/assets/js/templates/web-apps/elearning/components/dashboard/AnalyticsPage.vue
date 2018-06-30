<template>
    <section>
        <h1 class="title">Website Visitors</h1>
        <b-field label="Analyise by?">
            <div class="block">
                <b-radio v-model="analseLoadPageBy" native-value="y">Year</b-radio>
                <b-radio v-model="analseLoadPageBy" native-value="m">Month</b-radio>
            </div>
        </b-field>
        <chartjs-bar :labels="mylabels" :datasets="mydatasets" :bind="true"></chartjs-bar>
    </section>
</template>

<script>
export default {
    name: 'AnalyticsPage',
    props: ['address'],
    data () {
        return {
            loading: false,
            analseLoadPageBy: 'm',
            // mylabels: ["January", "February", "March", "April", "May", "June", "July"],
            mylabels: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            mydatasets:[],
        }
    },
    mounted() {
        this.getData();
    },
    watch: {
        analseLoadPageBy(val) {
            this.getData();
        }
    },
    methods: {
        getData() {
            const loadingComponent = this.$loading.open();
            axios.get('/api/sites/info/page-analytics/' + this.address)
            .then(async res => {
                let data = [];
                if (this.analseLoadPageBy === 'y') {
                    this.mylabels = _.allKeys(res.data.years);
                    _.each(res.data.years, (item, index) => {
                        data.push(res.data.years[index].length);
                    });
                } else {
                    this.mylabels = _.allKeys(res.data.months);
                    await _.each(res.data.months, (item, index) => {
                        data.push(res.data.months[index].length);
                    });
                }
                await this.mydatasets.splice(0,this.mydatasets.length);
                await this.mydatasets.push({
                    label: 'Visitors',
                    backgroundColor: this.backgroundColor,
                    borderColor: this.borderColor,
                    borderWidth: 1,
                    data: data
                }); 
                await loadingComponent.close();
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>