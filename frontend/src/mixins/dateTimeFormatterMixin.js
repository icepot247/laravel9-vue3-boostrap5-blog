import moment from "moment";

export default {
    data() {
        return {
            msg: 'Hello World',
        }
    },
    created: function () {
        console.log('Printing from the Mixin')
    },
    methods: {
        formatDate(date,format = 'DD-MMM-YYYY' ){
            return moment(date).format(format);
        },
       formatTime(time,convertTo24 = 'HH:mm',format = "hh:mm A"){
            return moment(time,convertTo24).format(format);
        },
    }
}
