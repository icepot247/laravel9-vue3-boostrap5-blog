import { createRouter, createWebHistory } from "vue-router";

const baseUrl = import.meta.env.VITE_BUILD_ADDRESS;

export const routes = [
  {
    path: `${baseUrl}/`,
    visable:true,
    component: () => import("@/layouts/Default.vue"),
    children: [
      { path: "", name: "Home", component: () => import("@/views/Home.vue") }
    ],
  },
  {
    path: `${baseUrl}/about`,
    visable:true,
    component: () => import("@/layouts/Page.vue"),
    children: [
      { path: "", name: "About", component: () => import("@/views/About.vue") }
    ],
  },
  {
    path: `${baseUrl}/blog`,
    visable:true,
    component: () => import("@/layouts/Page.vue"),
    children: [
      { path: "", name: "Blog", component: () => import("@/views/Blog.vue") },
    ],
  },
  {
    path: `${baseUrl}/blog/:slug`,
    visable:false,
    component: () => import("@/layouts/Page.vue"),
    children: [
      { path: "", name: "blog", component: () => import("@/views/Post.vue") },
    ],
  },

  {
    path: `${baseUrl}/contacts`,
    visable:true,
    component: () => import("@/layouts/Page.vue"),
    children: [
      { path: "", name: "Contacts", component: () => import("@/views/Contacts.vue") },
    ],
  },
  {
    path: `${baseUrl}/login`,
    visable:true,
    component: () => import("@/layouts/Page.vue"),
    children: [
      { path: "", name: "Login", component: () => import("@/views/Login.vue") },
    ],
  },
];

export const router = createRouter({
  history: createWebHistory(),
  routes: routes,
});
