import LocalStore from "../plugins/LocalStore";

/*export default function auth({ next, router }) {
    console.log('hello')
    if (!localStorage.getItem('token')) {
        return router.push({ name: 'login' });
    }

    return next();
}*/

export default (to, from, next) => {
    if (1==2) {
        console.log('1')
        // if (!localStorage.getItem('token')) {
        return { path: '/home' }
    }
    console.log('2', to, from, next)
    // return next;

    return next();
    return { path: '/test' }

    // return { path: to.path, query: to.query}
}
