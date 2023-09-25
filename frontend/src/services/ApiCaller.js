import axios from "axios";

export default {
    request: async function (method = 'GET', ur = '', param = {}, headers = {}) {
        try {
            if (method = 'GET') {
                const res = await axios.get(ur);
            }

            if (method = 'POST') {
                const res = await axios.post(ur);
            }

            if (method = 'PUT') {
                const res = await axios.put(ur);
            }

            if (method = 'DELETE') {
                const res = await axios.delete(ur);
            }

            if (method = 'PATCH') {
                const res = await axios.patch(ur);
            }

            return res.data;

        } catch (error) {
            console.log(error);
        }

        return false;
    }
}
